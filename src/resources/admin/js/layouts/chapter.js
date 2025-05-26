import '../modules';
import Swal from 'sweetalert2';
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHRUpload from '@uppy/xhr-upload';
import ImageEditor from '@uppy/image-editor';
import ru from '@uppy/locales/lib/ru_RU';

import '@uppy/core/dist/style.css';
import '@uppy/dashboard/dist/style.css';
import '@uppy/image-editor/dist/style.css';
import axios from 'axios';

const apiPath = `${import.meta.env.VITE_APP_API_URL}/${import.meta.env.VITE_APP_API_PATH}`;

$(function () {
    const uppy = new Uppy({
        debug: true, // Включить режим отладки
        autoProceed: false, // Не начинать загрузку автоматически
        restrictions: {
            maxNumberOfFiles: 1, // Ограничение на 1 файл
            allowedFileTypes: ['image/*'], // Разрешенные типы файлов (опционально)
        },
        locale: ru
    });

    uppy.use(Dashboard, {
        inline: true,
        target: '#uppy-dashboard',
        // hideUploadButton: true,
        width: '100%',
        height: '500px',
        showProgressDetails: true,
    });

    uppy.use(ImageEditor, {
        target: Dashboard, // Интеграция с Dashboard
        cropperOptions: {
            aspectRatio: NaN, // Соотношение сторон (16:9)
            viewMode: 1, // Режим просмотра
            guides: true, // Показывать направляющие
            // autoCropArea: 1, // Автоматически выделять область обрезки
            mask: true, // Включить маску
            maskColor: 'rgba(0, 0, 0, 0.5)', // Цвет маски
            maskOpacity: 0.5, // Прозрачность маски
            maskShape: 'rect', // Форма маски (прямоугольник)
            minCanvasHeight: 100,
            minContainerHeight: 100
        },
    });

    let matches = location.pathname.match(/\/admin\/titles\/([a-zA-z\-]+)\/chapters\/(\d+)/);

    uppy.use(XHRUpload, {
        endpoint: `${apiPath}/titles/${matches[1]}/chapters/${matches[2]}/images/`,  // Укажите ваш эндпоинт для загрузки
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
        },
        withCredentials: true,
    });

    uppy.on('file-added', (file) => {
        let number = $(".modal.fade.show").data("number");

        uppy.setFileMeta(file.id, {
            id: $(".modal.fade.show").data("id"),
            number: number,
        });
    });

    // Событие начала загрузки
    uppy.on('upload', (data) => {
        console.log(data);
    });

    //  Обработчик завершения загрузки
    uppy.on('complete', (result) => {
        if (result.successful)
            $(`#flush-collapse-${result.successful[0].meta.number} img`).attr("src", `${result.successful[0].response.body[0]}?v=${Date.now()}`);
    });

    uppy.on('save', (result) => {
        const editedFile = new File([editedImageObject.imageBase64], file.name, {
            type: file.type,
            id: $(this).parents(".accordion-item").find(".accordion-collapse").data("chapter-id")
        });
        uppy.removeFile(file.id);
        uppy.addFile({
            name: file.name,
            type: file.type,
            data: editedFile,
        });

    });

    /**
     * Отображение модального окна для редактирования изображения
     */
    $("a.image-edit-btn").on("click", function () {
        let src = $(this).parents(".accordion-item").find(".accordion-body img").attr("src");

        let name = src.split("/")[src.split("/").length - 1];
        let id = $(this).parents(".accordion-item").find(".accordion-collapse").data("chapter-id");
        let translator = $("select[name='translator']").data('translator');

        fetch(`http://mangaspace.ru:82/${src}`) // Получаем изображение по URL
            .then(response => response.blob()) // Преобразуем в Blob
            .then(blob => {
                const file = {
                    name: name, // Имя файла
                    type: blob.type, // Тип файла
                    data: blob, // Данные файла,
                    meta: {
                        id: id
                    },
                };

                console.log(file);

                uppy.cancelAll();
                // Добавляем файл в Uppy
                uppy.addFile(file);
            })
            .catch(error => console.error('Ошибка при загрузке изображения:', error));

        $(".modal.fade").attr("data-id", $(this).data("id"));
        $(".modal.fade").attr("data-number", $(this).data("number"));
    });

    /**
     * Удаление изображения
     */
    $("a.image-delete-btn").on("click", function () {

        let matches = location.pathname.match(/\/admin\/titles\/([a-zA-Z-_0-9]+)\/chapters\/(\d+)/);
        let title = matches[1];
        let chapter = matches[2];

        Swal.fire({
            icon: "warning",
            title: "Вы действительно хотите изображение",
            showCancelButton: true,
            confirmButtonText: "Удалить",
            cancelButtonText: `Отмена`,
        }).then((result) => {
            if (result.isConfirmed) {
                let params = {
                    image: $(this).parents(".accordion-item").find(".accordion-collapse img").attr("src").split("/")[$(this).parents(".accordion-item").find(".accordion-collapse img").attr("src").split("/").length - 1],
                    person: $("select[name='translator']").val()
                }
                axios.delete(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters/${chapter}/images`, { params })
                    .then((response) => {
                        Swal.fire("Saved!", "", "success");
                    })
                    .catch((error) => { });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });

    $("button[name='chapter-save']").on("click", function () {
        let oldNumber = $(".breadcrumb-item.active").text().trim();
        let newNumber = $("input[name='chapter_number']").val();
        let title = $("ol.breadcrumb .breadcrumb-item a").eq($("ol.breadcrumb .breadcrumb-item a").length - 1).attr("href").split("/")[$("ol.breadcrumb .breadcrumb-item a").eq($("ol.breadcrumb .breadcrumb-item a").length - 1).attr("href").split("/").length - 1];
        let translator = $("select[name='translator']").data('translator');

        let params1 = {
            number: $("input[name='chapter_number']").val(),
            volume: $("input[name='chapter_volume']").val(),
            name: $("input[name='name']").val(),
        };

        let params2 = {
            person: translator
        };

        const chapterRequest = axios.patch(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters/${oldNumber}`, params1);
        const chapterImageRequest = axios.patch(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters/${oldNumber}/images`, params2);

        Promise.all([chapterRequest, chapterImageRequest])
            .then(responses => {
                const [response1, response2] = responses;
                history.pushState(null, null, location.pathname.replace(/\d+/, newNumber));
                $(".breadcrumb-item.active").text(newNumber);
                $("select[name='translator']").attr('data-translator', $("select[name='translator']").val());

                Swal.fire({
                    icon: "success",
                    title: "Данные успешно обновлены",
                    // showCancelButton: true,
                    confirmButtonText: "OK",
                    // cancelButtonText: `Отмена`,
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Не удалось обновить данные",
                    // showCancelButton: true,
                    confirmButtonText: "OK",
                    // cancelButtonText: `Отмена`,
                });
            });

    });
})