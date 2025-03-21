import Sortable from 'sortablejs';

import Swiper from "swiper/bundle";
import "swiper/css/bundle";

import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHRUpload from '@uppy/xhr-upload';
import ImageEditor from '@uppy/image-editor';
import ru from '@uppy/locales/lib/ru_RU';

// import Choices from 'choices.js';

// Импортируем стили Uppy
import '@uppy/core/dist/style.css';
import '@uppy/dashboard/dist/style.css';
import '@uppy/image-editor/dist/style.css';

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
    },
    on: {
        'click': function (e) {
            let newBlock = $($(".modal .list-group a")[0]).clone();
            $(newBlock).attr("href", $(e.slides[0]).find("img").attr("src"));
            $(".modal .list-group").append(newBlock);
        },
    }
});

$("tbody td").on("click", function () {
    $(this).find("img").fadeIn();
});

let FILE = null;


// Инициализация Uppy
document.addEventListener('DOMContentLoaded', function () {
    const uppy = new Uppy({
        debug: true, // Включить режим отладки
        autoProceed: false, // Не начинать загрузку автоматически
        restrictions: {
            maxNumberOfFiles: 1, // Ограничение на 1 файл
            allowedFileTypes: ['image/*'], // Разрешенные типы файлов (опционально)
        },
        locale: ru
    });

    // Добавляем плагин Dashboard
    // uppy.use(Dashboard, {
    //     inline: true, // Встроенный интерфейс
    //     target: '#uppy-dashboard', // Элемент для отображения интерфейса
    //     width: 300, // Ширина интерфейса
    //     height: 300, // Высота интерфейса
    //     showProgressDetails: true, // Показывать детали прогресса
    // });

    // document.getElementById('clickable-image').addEventListener('click', function () {
    //     const fileId = uppy.addFile({
    //         name: 'image.jpg', // Имя файла
    //         type: 'image/jpeg', // Тип файла
    //         data: this.src, // Используем текущий src изображения
    //     });

    // });

    // // Добавляем плагин Image Editor с маской
    // uppy.use(ImageEditor, {
    //     target: Dashboard, // Интеграция с Dashboard
    //     cropperOptions: {
    //         aspectRatio: NaN, // Соотношение сторон (16:9)
    //         viewMode: 1, // Режим просмотра
    //         guides: true, // Показывать направляющие
    //         // autoCropArea: 1, // Автоматически выделять область обрезки
    //         mask: true, // Включить маску
    //         maskColor: 'rgba(0, 0, 0, 0.5)', // Цвет маски
    //         maskOpacity: 0.5, // Прозрачность маски
    //         maskShape: 'rect', // Форма маски (прямоугольник)
    //         // minCropBoxHeight: 300,
    //         // minCropBoxWidth: 300,
    //         minCanvasHeight: 100,
    //         minContainerHeight: 100
    //     },
    // });

    // // Добавляем плагин XHRUpload для загрузки файлов на сервер
    // uppy.use(XHRUpload, {
    //     endpoint: 'https://example.com/upload', // URL для загрузки файлов
    //     method: 'POST', // Метод HTTP
    //     formData: true, // Использовать FormData для загрузки
    //     fieldName: 'file', // Имя поля для файла
    // });

    // Обработчик завершения загрузки
    // uppy.on('complete', (result) => {
    //     console.log('Загрузка завершена:', result);
    //     if (result.successful) {
    //         alert('Файлы успешно загружены!');
    //     } else {
    //         alert('Ошибка при загрузке файлов.');
    //     }
    // });

    // uppy.on('dashboard:file-added', () => {
    //     const fileList = document.querySelector('.uppy-Dashboard-files div div');
    //     if (fileList) {
    //         new Sortable(fileList, {
    //             animation: 150, // Анимация перетаскивания
    //             onEnd: function (evt) {
    //                 // Обновляем порядок файлов в Uppy
    //                 const files = uppy.getFiles();
    //                 const movedFile = files[evt.oldIndex];
    //                 files.splice(evt.oldIndex, 1); // Удаляем файл из старой позиции
    //                 files.splice(evt.newIndex, 0, movedFile); // Вставляем файл в новую позицию

    //                 // Обновляем состояние Uppy
    //                 uppy.setState({
    //                     files: files.reduce((acc, file) => {
    //                         acc[file.id] = file;
    //                         return acc;
    //                     }, {}),
    //                 });
    //             },
    //         });
    //     }
    // });


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

    // Добавление плагина для загрузки файлов (например, XHRUpload)
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

    // // Обработчик клика по изображению
    // document.getElementById('clickable-image').addEventListener('click', function () {
    //     // Добавляем изображение в Uppy
    //     fetch(this.src) // Получаем изображение по URL
    //         .then(response => response.blob()) // Преобразуем в Blob
    //         .then(blob => {
    //             const file = {
    //                 name: 'image.jpg', // Имя файла
    //                 type: blob.type, // Тип файла
    //                 data: blob, // Данные файла
    //             };

    //             // Добавляем файл в Uppy
    //             uppy.addFile(file);
    //         })
    //         .catch(error => console.error('Ошибка при загрузке изображения:', error));
    // });

    $("a.image-edit-btn").on("click", function () {
        let src = $(this).parents(".accordion-item").find(".accordion-body img").attr("src");

        let name = src.split("/")[src.split("/").length - 1];
        let id = $(this).parents(".accordion-item").find(".accordion-collapse").attr("id").match(/flush-collapse-(\d+)/)[1];

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

});

$(function () {

    let sortable = new Sortable($('.accordion')[0], {
        handle: ".icon"
    });
});
