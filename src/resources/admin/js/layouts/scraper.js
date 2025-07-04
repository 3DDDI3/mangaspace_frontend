import '../modules';

import Swiper from "swiper/bundle";
import "swiper/css/bundle";
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import bootstrapBundle from "bootstrap/dist/js/bootstrap.bundle";
window.bootstrap = bootstrapBundle;

// Toastify({
//     text: "This is toast in top left",
//     duration: 3000,
//     close: true,
//     gravity: "top",
//     position: "left",
//     backgroundColor: "#4fbe87",
// }).showToast()

function initSwiper() {
    Array.from($(".titles .swiper")).forEach((slider) => {
        let id = $(slider).data("swiper-id");

        new Swiper(slider, {
            // autoHeight: true,
            direction: 'horizontal',
            loop: false,

            pagination: {
                el: `.swiper-pagination_${id}`,
            },

            navigation: {
                nextEl: `.swiper-button-next_${id}`,
                prevEl: `.swiper-button-prev_${id}`,
            },

            scrollbar: {
                el: `.swiper-scrollbar_${id}`,
            },
        });
    });
}


axios.get(`${api_url}/v1.0/auth/check`,).then((response) => {
    Echo.private(`admin.${response.data.user.id}.scraper.logError`)
        .listen('WS\\Scraper\\GetErrorEvent', (e) => {
            $(".error-textarea").append(`
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span style="width: 80%;">${e.message}</span>
                    <span class="badge bg-danger badge-pill badge-round ms-1">
                        <i class="bi bi-exclamation-circle"></i>
                    </span>
                </li>`)
            // let toastLive = $("#liveToast");
            // $(toastLive).find(".toast-body").text(e.message);
            // const toast = new bootstrap.Toast(toastLive);
            // toast.show();
        });

    Echo.private(`admin.${response.data.user.id}.scraper.logInformation`)
        .listen('WS\\Scraper\\GetLogEvent', (e) => {
            $(".logs-textarea").append(`<p>${e.message}</p>`);

            // let toastLive = $("#liveToast");
            // $(toastLive).find(".toast-body").text(e.message);
            // const toast = new bootstrap.Toast(toastLive);
            // toast.show();
        });

    Echo.private(`admin.${response.data.user.id}.scraper.parseTitles`)
        .listen('WS\\Scraper\\ParseTitlesEvent', (e) => {

            $(".titles accordion").remove();

            if (e.content.chapterDTO[0].isFirst) {
                let covers = "";

                e.obj.covers.forEach(cover => {
                    covers += `
                        <div class="swiper-slide">
                            <img src="/media/titles/${e.obj.path}/covers/${cover.path}" alt="">
                        </div>`;
                });

                let html = `
                    <div class="accordion accordion-flush" id="accordionFlushTitle${e.obj_id}">
                           <div class="accordion-item">
                            <h2 class="accordion-header title-accordion-header" id="flush-heading${e.obj_id}">
                                <button class="accordion-button collapsed column-gap-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse${e.obj_id}" aria-expanded="false"
                                    aria-controls="flush-collapse${e.obj_id}">
                                    ${e.obj.name}
                                </button>
                                <div class="btn-group d-flex column-gap-2 d-none d-sm-flex" role="group" aria-label="Basic example">
                                    <a class="action-btn image-edit-btn btn icon btn-primary" href="/admin/titles/${e.content.url}"
                                        target="_blank">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </h2>
                            <div id="flush-collapse${e.obj_id}" class="accordion-collapse collapse"
                                aria-labelledby="flush-collapse${e.obj_id}" data-bs-parent="#accordionFlushTitle${e.obj_id}">
                                <div class="accordion-body px-0">
                                    <div class="swiper cover-swiper mx-0 mb-4" data-swiper-id="t${e.obj_id}">
                                        <div class="swiper-wrapper">
                                            ${covers}
                                        </div>
                                        <div class="swiper-pagination swiper-pagination_t${e.obj_id}"></div>
                                        <div class="swiper-button-prev swiper-button-prev_t${e.obj_id}"></div>
                                        <div class="swiper-button-next swiper-button-next_t${e.obj_id}"></div>
                                        <div class="swiper-scrollbar swiper-scrollbar_t${e.obj_id}"></div>
                                    </div>
                                    <p><b>Русское название:</b> ${e.obj.name}</p>
                                    <p><b>Английское название:</b> ${e.obj.altName ?? ""}</p>
                                    <p><b>Другие названия:</b> ${e.obj.otherNames ?? ""}</p>
                                    <p><b>Категория:</b> ${e.obj.type}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                $(".tab-pane.active.show .titles .col-lg-8").eq(0).append(html);
            }
            else {
                let elems = "";

                e.obj.images.forEach(el => {
                    elems += ` 
                        <div class="swiper-slide">
                           <img src="/media/${el}" alt="">
                        </div>
                        `;
                });

                let html = `
                    <div class="accordion-item position-relative">
                        <h2 class="accordion-header chapter-accordion-header" id="flush-heading_${e.obj.number}_${e.obj.translator.slug.replace(/\s/, "")}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_${e.obj.number}_${e.obj.translator.slug.replace(/\s/, "")}" aria-expanded="false" aria-controls="flush-collapse_${e.obj.number}_${e.obj.translator.slug.replace(/\s/, "")}">
                                Глава ${e.obj.number} (переводчик ${e.obj.translator.name})
                            </button>
                            <div class="btn-group d-flex column-gap-2 d-none d-sm-flex" role="group" aria-label="Basic example">
                                <a class="action-btn image-edit-btn btn icon btn-primary" href="/admin/titles/${e.content.url}/chapters/${e.obj.number}?translator=${e.obj.translator.slug.replace(/\s/, "")}" target="_blank">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </h2>
                        <div id="flush-collapse_${e.obj.number}_${e.obj.translator.slug.replace(/\s/, "")}" class="accordion-collapse accordion-collapse-chapter collapse" aria-labelledby="flush-collapse_${e.obj.number}_${e.obj.translator.slug.replace(/\s/, "")}">
                            <div class="accordion-body accordion-chapter px-0 pt-0">
                                <div class="swiper w-100" data-swiper-id="c${e.obj.number}">
                                    <div class="swiper-wrapper">
                                        ${elems}
                                    </div>
                                </div>
                                <div class="swiper-button-prev swiper-button-prev_c${e.obj.number}"></div>
                                <div class="swiper-button-next swiper-button-next_c${e.obj.number}"></div>
                                <div class="swiper-scrollbar swiper-scrollbar_c${e.obj.number}"></div>
                            </div>
                        </div>
                    </div>
                    `;

                $(`.tab-pane.active.show .titles #flush-collapse${e.obj_id} .accordion-body`).eq(0).append(html);
            }

            initSwiper();
        });

    Echo.private(`admin.${response.data.user.id}.scraper.getChapters`)
        .listen('WS\\Scraper\\GetChaptersEvent', (e) => {
            if (e.isLast)
                $(".chapters .loader-layer").fadeOut(800);

            if (e.isLast) {
                $(".tab-pane.fade.active a[name='getChapters']").removeClass("disabled btn-progress");
                $(".tab-pane.fade.active input[name='pathname']").prop("disabled", false);
            }

            $(".tab-pane.active.show").find(".chapters .list-group").append(e.content);
        });

    Echo.private(`admin.${response.data.user.id}.scraper.parseChapters`)
        .listen('WS\\Scraper\\ParseChaptersEvent', (e) => {
            $(".titles accordion").remove();

            if (e.object.isFirst) {
                $(".tab-pane.active.show .titles div").eq(0).html(e.content);
                initSwiper();
            }
            else {

                console.log(e);

                let elems = ""

                e.obj.images.forEach(el => {
                    elems += ` 
                        <div class="swiper-slide">
                            <img src="/media/${el}" alt="">
                        </div>`;
                });

                let html = `
                <div class="accordion-item">
                    <h2 class="accordion-header chapter-accordion-header" id="flush-heading_${e.obj.translator.id}${e.obj.number}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse_${e.obj.translator.id}${e.obj.number}" aria-expanded="false"
                            aria-controls="flush-collapse_${e.obj.translator.id}${e.obj.number}">
                            Том ${e.obj.volume}. Глава ${e.obj.number}
                        </button>
                        <div class="btn-group d-flex column-gap-2 d-none d-sm-flex" role="group" aria-label="Basic example">
                            <a class="action-btn image-edit-btn btn icon btn-primary"
                                href="/admin/titles/${e.object.url}" target="_blank">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </h2>
                    <div id="flush-collapse_${e.obj.translator.id}${e.obj.number}" class="accordion-collapse collapse accordion-collapse-chapter" aria-labelledby="flush-collapse_${e.obj.translator.id}${e.obj.number}" data-bs-parent="#accordionFlushExample1">
                        <div class="accordion-body accordion-chapter px-0 pt-0">
                            <div class="swiper w-100" data-swiper-id="${e.obj.translator.id}${e.obj.number}">
                                <div class="swiper-wrapper">
                                    ${elems}
                                </div>
                                <div class="swiper-pagination swiper-pagination_${e.obj.translator.id}${e.obj.number}"></div>
                                <div class="swiper-scrollbar swiper-scrollbar_${e.obj.translator.id}${e.obj.number}"></div>
                            </div>
                            <div class="swiper-button-prev swiper-button-prev_${e.obj.translator.id}${e.obj.number}"></div>
                            <div class="swiper-button-next swiper-button-next_${e.obj.translator.id}${e.obj.number}"></div>
                        </div>
                    </div>
                </div>
                `;
                $(".tab-pane.active.show .titles .accordion").eq(1).append(html);
            }

            if (e.object.isLast) {
                $(".tab-pane.fade.active a[name='parseChapters']").removeClass("btn-progress disabled");
                $(".tab-pane.fade.active a[name='selectAllChapters']").removeClass("btn-progress disabled");
                $(".tab-pane.fade.active a[name='removeSelectedChapters']").removeClass("btn-progress disabled");
                $(".tab-pane.fade.active a[name='getChapters']").removeClass("btn-progress disabled");
                $(".tab-pane.fade.active a[name='parseTitle']").removeClass("btn-progress disabled");
                $(".tab-pane.fade.active input[name='pathname']").attr("disabled", false);
                $(".tab-pane.fade.active input[name='pages']").attr("disabled", false);
            }

            initSwiper();
        });

});


$(function () {
    initSwiper();

    $("a[name='getChapters']").on("click", function () {
        let url = $(this).parents(".card-body").find("div.tab-pane.fade.active.show").find("span[name='url']").text();
        let pathname = $(this).parents(".card-body").find("div.tab-pane.fade.active.show").find("input[name='pathname']").val();

        const params = {
            url: `${url}${pathname}`,
            engine: $("a.nav-link.active").data("engine"),
            action: "getChapters",
        };

        $(this).removeClass("btn-progress disabled");
        $(".tab-pane.fade.active input[name='pathname']").prop("disabled", true);

        axios.get(`${api_url}/v1.0/scraper/chapters`, { params })
            .then((response) => {
            })
            .catch((error) => {
                // console.log(error);
            });
    });

    $("a[name='parseChapters']").on("click", function () {
        let chapters = [];
        Array.from($(this).parents(".chapters").find("input[type='checkbox']:checked")).forEach(el => {
            chapters.push($(el).attr("data-url"));
        });

        $(this).addClass("btn-progress disabled");
        $(".tab-pane.fade.active input[name='pathname']").attr("disabled", true);
        $(".tab-pane.fade.active input[name='pages']").attr("disabled", true);
        $(".tab-pane.fade.active a[name='selectAllChapters']").addClass("btn-progress disabled");
        $(".tab-pane.fade.active a[name='removeSelectedChapters']").addClass("btn-progress disabled");
        $(".tab-pane.fade.active a[name='getChapters']").addClass("btn-progress disabled");
        $(".tab-pane.fade.active a[name='parseTitle']").addClass("btn-progress disabled");
        $(".tab-pane.fade.active a[name='removeSelectedChapters']").addClass("btn-progress disabled");

        const params = {
            chapters: chapters,
            engine: $("a.nav-link.active").data("engine"),
            action: "parseChapters",
        };

        $(".logs-textarea p").remove();
        $(".error-textarea li").remove();

        axios.post(`${api_url}/v1.0/scraper/chapters`, { params })
            .then((response) => {
            })
            .catch((error) => {
            });

    });

    $("a[name='parseTitle']").on("click", function () {
        $(".logs-textarea p").remove();
        $(".error-textarea li").remove();

        let pages = $(this).parents(".card.mt-4.mb-4").find("input[name='pages']").val();

        const params = {
            pages: pages,
            engine: $("a.nav-link.active").data("engine"),
            action: "parseTitles",
        };

        axios.post(`${api_url}/v1.0/scraper/titles`, { params })
            .then((response) => {
            })
            .catch((error) => {
                // console.log(error);
            });

    })

    $("a[name='selectAllChapters']").on("click", function () {
        $(this).parents(".chapters").find(".list-group li input[type='checkbox']").prop("checked", true);
    });

    $("a[name='removeSelectedChapters']").on("click", function () {
        $(this).parents(".chapters").find(".list-group li input[type='checkbox']").prop("checked", false);
    });

    var myCollapsible = document.getElementById('mangalibChapters')
    myCollapsible.addEventListener('shown.bs.collapse', function (e) {
        $(this).removeAttr("id");
    });

});

