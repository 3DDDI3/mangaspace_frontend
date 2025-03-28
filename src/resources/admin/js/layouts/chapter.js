import Swal from 'sweetalert2';
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHRUpload from '@uppy/xhr-upload';
import ImageEditor from '@uppy/image-editor';
import ru from '@uppy/locales/lib/ru_RU';

import '@uppy/core/dist/style.css';
import '@uppy/dashboard/dist/style.css';
import '@uppy/image-editor/dist/style.css';

$(function () {
    /**
     * Удаление изображения
     */
    $("a.image-delete-btn").on("click", function () {
        Swal.fire({
            icon: "warning",
            title: "Вы действительно хотите изображение",
            showCancelButton: true,
            confirmButtonText: "Удалить",
            cancelButtonText: `Отмена`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire("Saved!", "", "success");
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });

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

    uppy.use(XHRUpload, {
        endpoint: 'https://example.com/upload', // Укажите ваш эндпоинт для загрузки
    });

    uppy.on('file-added', (file) => {
        // if (file.meta.id != undefined)
        //     FILE = {
        //         name: file.name,
        //         size: file.size,
        //     }
        // else {
        //     if (file.size == FILE.size || file.name == FILE.name)
        //         $(".uppy-Dashboard-progressindicators").css("display", "none");
        //     else
        //         $(".uppy-Dashboard-progressindicators").css("display", "block");
        // }
    });

    // Событие начала загрузки
    uppy.on('upload', (data) => {
        console.log(data);
    });

    //  Обработчик завершения загрузки
    uppy.on('complete', (result) => {
        console.log('Загрузка завершена:', result);
        if (result.successful) {
            alert('Файлы успешно загружены!');
        } else {
            alert('Ошибка при загрузке файлов.');
        }
    });

    uppy.on('save', (result) => {
        const editedFile = new File([editedImageObject.imageBase64], file.name, {
            type: file.type,
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

        fetch(`http://mangaspace.ru:82/${src}`) // Получаем изображение по URL
            .then(response => response.blob()) // Преобразуем в Blob
            .then(blob => {
                const file = {
                    name: name, // Имя файла
                    type: blob.type, // Тип файла
                    data: blob, // Данные файла,
                    meta: {
                        id: id,
                    },
                };

                console.log(file);

                uppy.cancelAll();
                // Добавляем файл в Uppy
                uppy.addFile(file);
            })
            .catch(error => console.error('Ошибка при загрузке изображения:', error));
    });

    $("button[name='chapter-save']").on("click", function () {
        let number = $(".breadcrumb-item.active").text().trim();
        let title = $("ol.breadcrumb .breadcrumb-item a").eq($("ol.breadcrumb .breadcrumb-item a").length - 1).attr("href").split("/")[$("ol.breadcrumb .breadcrumb-item a").eq($("ol.breadcrumb .breadcrumb-item a").length - 1).attr("href").split("/").length - 1];

        let params = {
            number: $("input[name='chapter_number']").val(),
            volume: $("input[name='chapter_volume']").val(),
            name: $("input[name='name']").val(),
        };

        axios.patch(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters/${number}`, params)
            .then((response) => {

            }).catch((error) => {

            });
    });
})