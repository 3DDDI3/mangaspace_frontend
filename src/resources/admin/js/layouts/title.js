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
import axios from 'axios';

$(function () {
    let offset = $("#table-record-header").val();

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
            title: "Вы действительно хотите удалить изображение",
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

        let title = window.location.pathname.split("/")[window.location.pathname.split("/").length - 1];

        if ($(this).hasClass("sorting_asc") || $(this).hasClass("sorting_desc")) {
            if ($(this).hasClass("sorting_asc")) {
                /**
                 * Сортировка по убыванию
                 */
                $("thead tr th").removeClass("sorting_asc");
                $("thead tr th").removeClass("sorting_desc");
                $(this).removeClass("sorting_asc");
                $(this).addClass("sorting_desc");

                let params = {
                    orderByDesc: $(this).data("field"),
                    offset: offset,
                }

                if ($("input[name='chapter-search']").val() != "")
                    params.search = $("input[name='chapter-search']").val();

                console.log($("input[name='chapter-search']"));
                axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters`, { params })
                    .then((response) => {
                        updateTable(response, title);
                        updatePaginationList(response, title);
                        updateTableInfo(response);
                    });
            }
            else {
                /**
                 * Сортировка по возрастанию
                 */
                $("thead tr th").removeClass("sorting_asc");
                $("thead tr th").removeClass("sorting_desc");
                $(this).removeClass("sorting_desc");
                $(this).addClass("sorting_asc");

                let params = {
                    orderByAsc: $(this).data("field"),
                    offset: offset,
                }

                console.log($("input[name='chapter-search']"));


                if ($("input[name='chapter-search']").val() != "")
                    params.search = $("input[name='chapter-search']").val();


                axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters`, { params })
                    .then((response) => {
                        updateTable(response, title);
                        updatePaginationList(response, title);
                        updateTableInfo(response);
                    });
            }
        } else {
            $("thead tr th").removeClass("sorting_asc");
            $("thead tr th").removeClass("sorting_desc");
            $(this).addClass("sorting_asc");

            let params = {
                orderByAsc: $(this).data("field"),
                offset: offset,
            }

            if ($("input[name='chapter-search']").val() != "")
                params.search = $("input[name='chapter-search']").val();


            console.log($("input[name='chapter-search']"));
            axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters`, { params })
                .then((response) => {
                    updateTable(response, title);
                    updatePaginationList(response, title);
                    updateTableInfo(response);
                });
        }
    });

    $(".dataTable-bottom").on("click", ".page-item", function (e) {
        e.preventDefault();

        if ($(this).hasClass("active"))
            return;

        let page = $(this).find(".page-link").attr("href").match(/\?page=(\d+)/)[1];
        let title = window.location.pathname.split("/")[window.location.pathname.split("/").length - 1];

        $(".page-item").removeClass("active");
        $(this).addClass("active");

        let params = {
            page: page,
            offset: offset,
        };

        if ($("th.sorting_asc").data("field") != undefined)
            params.orderByAsc = $("th.sorting_asc").data("field");

        if ($("th.sorting_desc").data("field") != undefined)
            params.orderByDesc = $("th.sorting_desc").data("field");

        axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters`, { params })
            .then((response) => {
                updateTable(response, title);
                updatePaginationList(response, title);
                updateTableInfo(response);
            }).catch((error) => {

            });
    });

    $("input[name='chapter-search']").on("input", function () {
        let title = window.location.pathname.split("/")[window.location.pathname.split("/").length - 1];

        let params = {
            search: $(this).val(),
            offset: offset,
        }

        axios.get(`${import.meta.env.VITE_APP_API_URL}/v1.0/titles/${title}/chapters`, { params })
            .then((response) => {
                updateTable(response, title);
                updatePaginationList(response, title);
                updateTableInfo(response);
            });
    });

    $("tbody a.delete-btn").on("click", function () {
        Swal.fire({
            icon: "warning",
            title: "Вы действительно хотите удалить главу",
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

});

/**
 * Обновление таблицы
 * @param {*} response 
 * @param {string} title 
 * @returns 
 */
function updateTable(response, title) {
    let chapter = response.data.data;

    $("table tbody tr").remove();

    if (chapter.length == 0) {
        $("table tbody").append(
            `
                <tr class="odd">
                    <td valign="top" colspan="6" class="dataTables_empty text-center">
                        Не удалось найти совпадения
                    </td>
                </tr>
            `
        );
        return;
    }

    chapter.forEach((item) => {
        $("table tbody").append(
            `
            <tr>
                <td>
                    <div class="btn-group d-flex justify-content-center" role="group"
                        aria-label="Basic example">
                        <i class="icon sorting-button flex-shrink-0 bi bi-list"></i>
                    </div>
                </td>
                <td>
                    <a
                        href="${location.origin}/admin/titles/${title}/chapters/${chapter[0].number}">
                        ${item.number}
                    </a>
                </td>
                <td> ${item.volume} </td>
                <td> ${item.name != null ? item.name : ""} </td>
                <td> ${item.created_at} </td>
                <td>
                    <div class="btn-group d-flex justify-content-end column-gap-2 ps-2"
                        role="group" aria-label="Basic example">
                        <a href="${location.origin}/admin/titles/${title}/chapters/${chapter[0].number}"
                            class="action-btn edit-btn btn icon btn-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a class="action-btn delete-btn btn icon btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            `
        );
    });
}

/**
 * Обновление списка пагинации
 * @param {*} response 
 * @param {*} title 
 */
function updatePaginationList(response, title) {
    $(".table-responsive .dataTable-pagination .page-item").remove();

    response.data.meta.links.forEach((el) => {
        /**
         * Формирование списка страниц
         */
        if (el.label != "&laquo; Previous" && el.label != "Next &raquo;") {
            if (el.active) {
                $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                    `   
                    <li class="page-item" aria-disabled="true">
                        <span class="page-link active">
                            ${el.label}
                        </span>
                    </li>
                `
                );
            }
            else {
                $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                    `
                        <li class="page-item">
                            <a class="page-link" href="${location.origin}/admin/titles/${title}?page=${el.label}">
                                ${el.label}
                            </a>
                        </li>
                    `
                );
            }

        }

        if (el.label == "&laquo; Previous" && el.url != null) {
            $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                `
                    <li class="pager page-item">
                        <a class="page-link" href="${location.origin}/admin/titles/${title}/${el.url.split("/")[el.url.split("/").length - 1]}" rel="prev"
                            aria-label="">&lsaquo;</a>
                    </li>
                `
            )
        }

        if (el.label == "Next &raquo;" && el.url != null) {
            $(".table-responsive .dataTable-pagination .dataTable-pagination-list").append(
                `
                    <li class="pager page-item">
                            <a class="page-link" href="${location.origin}/admin/titles/${title}/${el.url.split("/")[el.url.split("/").length - 1]}" rel="next"
                                aria-label="">&rsaquo;</a>
                    </li>
                `
            );
        }
    });
}

/**
 * Измененеи плашки с кол-вом записей в таблице
 */
function updateTableInfo(response) {
    $(".table-responsive .dataTable-info .fw-semibold").eq(0).text(response.data.meta.from);
    $(".table-responsive .dataTable-info .fw-semibold").eq(1).text(response.data.meta.to);
    $(".table-responsive .dataTable-info .fw-semibold").eq(2).text(response.data.meta.total);
}