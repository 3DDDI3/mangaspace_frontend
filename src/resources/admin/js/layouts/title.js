import Choices from 'choices.js';
import Sortable from 'sortablejs';
import Swiper from "swiper/bundle";
import "swiper/css/bundle";
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHRUpload from '@uppy/xhr-upload';
import ImageEditor from '@uppy/image-editor';
import ru from '@uppy/locales/lib/ru_RU';

import '@uppy/core/dist/style.css';
import '@uppy/dashboard/dist/style.css';
import '@uppy/image-editor/dist/style.css';

import Swal from 'sweetalert2';

$(function () {
    Array.from($(".choices")).forEach((el) => {
        if ($(el).hasClass("multiple-remove")) {
            new Choices(el, {
                allowHTML: true,
                delimiter: ",",
                editItems: true,
                searchEnabled: true,
                maxItemCount: -1,
                removeItemButton: true,
                placeholderValue: null,
                placeholder: true,
                searchPlaceholderValue: 'asd123',
                prependValue: null,
                appendValue: null,
                renderSelectedChoices: 'auto',
                loadingText: 'Загрузка...',
                noResultsText: 'Ничего не найдено',
                noChoicesText: 'Нет вариантов для выбора',
                itemSelectText: 'Нажми для выбора',
                addItemText: (value) => {
                    return `Press Enter to add <b>"${value}"</b>`;
                },
            })
        }
        else new Choices(el, {
            allowHTML: true,
            delimiter: ",",
            editItems: true,
            searchEnabled: true,
            maxItemCount: -1,
            removeItemButton: true,
            placeholderValue: null,
            placeholder: true,
            searchPlaceholderValue: 'asd123',
            prependValue: null,
            appendValue: null,
            renderSelectedChoices: 'auto',
            loadingText: 'Загрузка...',
            noResultsText: 'Ничего не найдено',
            noChoicesText: 'Нет вариантов для выбора',
            itemSelectText: 'Нажми для выбора',
            addItemText: (value) => {
                return `Press Enter to add <b>"${value}"</b>`;
            },
        });
    })

    const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: false,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        }
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
        if (file.meta.id != undefined)
            FILE = {
                name: file.name,
                size: file.size,
            }
        else {
            if (file.size == FILE.size || file.name == FILE.name)
                $(".uppy-Dashboard-progressindicators").css("display", "none");
            else
                $(".uppy-Dashboard-progressindicators").css("display", "block");
        }
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
        let src = $(swiper.slides[swiper.activeIndex]).find("img").attr("src");

        let name = src.split("/")[src.split("/").length - 1];
        let id = $(swiper.slides[swiper.activeIndex]).find("img").data("image-id");

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

    /**
     * Функционал кнопки удаления
     */
    $("a.image-delete-btn").on("click", function () {
        // Toastify({
        //     text: "This is toast in top left",
        //     duration: 3000,
        //     close: true,
        //     gravity: "top",
        //     position: "left",
        //     backgroundColor: "#4fbe87",
        // }).showToast()

        // let toastLive = $("#liveToast");
        // $(toastLive).find(".toast-body").text('asda');
        // const toast = new bootstrap.Toast(toastLive);
        // toast.show();

        Swal.fire({
            icon: "warning",
            title: "Вы дествительно хотите удалить изображение",
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

    console.log($('tbody tr')[0]);


    let sortable = new Sortable($('tbody')[0], {
        handle: ".btn-group",
        ghostClass: 'active-sortable-row',
        onUpdate: function (evt) {
            /**
             * @TODO добавить реализацию сортировки
             */
        }
    });

    $("thead tr th").on("click", function (e) {
        if (!$(this).hasClass("sorting"))
            return;

        if ($(this).hasClass("sorting_asc") || $(this).hasClass("sorting_desc")) {
            if ($(this).hasClass("sorting_asc")) {
                $("thead tr th").removeClass("sorting_asc");
                $("thead tr th").removeClass("sorting_desc");
                $(this).removeClass("sorting_asc");
                $(this).addClass("sorting_desc");
            }
            else {
                $("thead tr th").removeClass("sorting_asc");
                $("thead tr th").removeClass("sorting_desc");
                $(this).removeClass("sorting_desc");
                $(this).addClass("sorting_asc");
            }
        } else {
            $("thead tr th").removeClass("sorting_asc");
            $("thead tr th").removeClass("sorting_desc");
            $(this).addClass("sorting_asc");
        }
    });

});