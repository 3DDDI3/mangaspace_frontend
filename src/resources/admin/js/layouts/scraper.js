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
    });
}


axios.get(`${api_url}/v1.0/auth/check`,).then((response) => {
    Echo.private(`admin.${response.data.user.id}.scraper.logError`)
        .listen('WS\\Scraper\\GetErrorEvent', (e) => {
            console.log(e);

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
            $(".logs-textarea p").remove();

            if (typeof e.content != 'object')
                $(".tab-pane.active.show .titles .col-lg-8").eq(0).append(e.content);
            else {
                let elems = ""
                console.log($(".tab-pane.active.show .titles .accordion-button"));
                e.obj.images.forEach(el => {
                    elems += ` 
                        <div class="swiper-slide">
                           <img src="/media/${el}" alt="">
                        </div>
                        `;
                });

                let html = `
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-heading_${e.obj.number}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_${e.obj.number}" aria-expanded="false" aria-controls="flush-collapse_${e.obj.number}">
                            Глава ${e.obj.number}
                        </button>
                    </h2>
                    <div id="flush-collapse_${e.obj.number}" class="accordion-collapse collapse" aria-labelledby="flush-collapse_${e.obj.number}" data-bs-parent="#accordionFlushExample1" style="">
                        <div class="accordion-body">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    ${elems}
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-scrollbar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                Array.from($(".tab-pane.active.show .titles .accordion-button")).forEach(el => {
                    if ($(el).text().replaceAll(/\s{2,}/g, "") == e.content.name)
                        $(el).parents(".accordion-item").find(".accordion").append(html);
                });
            }
            initSwiper();
        });

    Echo.private(`admin.${response.data.user.id}.scraper.getChapters`)
        .listen('WS\\Scraper\\GetChaptersEvent', (e) => {
            if (e.isLast)
                $(".chapters .loader-layer").fadeOut(800);

            $(".tab-pane.active.show").find(".chapters .list-group").append(e.content);
        });

    Echo.private(`admin.${response.data.user.id}.scraper.parseChapters`)
        .listen('WS\\Scraper\\ParseChaptersEvent', (e) => {
            if (e.object.isFirst)
                $(".tab-pane.active.show .titles").html(e.content);
            else {
                let elems = ""

                e.obj.images.forEach(el => {
                    elems += ` 
                        <li>
                            <img src="/media/${el}" alt="">
                        </li>`;
                });

                let html = `
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-heading_${e.object.number}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_${e.object.number}" aria-expanded="false" aria-controls="flush-collapse_${e.object.number}">
                            Глава ${e.object.number}
                        </button>
                    </h2>
                    <div id="flush-collapse_${e.object.number}" class="accordion-collapse collapse" aria-labelledby="flush-collapse_${e.object.number}" data-bs-parent="#accordionFlushExample1" style="">
                        <div class="accordion-body">
                            <ul>
                               ${elems}
                            </ul>
                        </div>
                    </div>
                </div>
                `;
                $(".tab-pane.active.show .titles .accordion").eq(1).append(html);
            }
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

        axios.get(`${api_url}/v1.0/scraper/chapters`, { params })
            .then((response) => {
                console.log(response);
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

        const params = {
            chapters: chapters,
            engine: $("a.nav-link.active").data("engine"),
            action: "parseChapters",
        };

        axios.post(`${api_url}/v1.0/scraper/chapters`, { params })
            .then((response) => {
                console.log(JSON.parse(response));
            })
            .catch((error) => {
                // console.log(error);
            });

    });

    $("a[name='parseTitle']").on("click", function () {
        let pages = $(this).parents(".card.mt-4.mb-4").find("input[name='pages']").val();

        const params = {
            pages: pages,
            engine: $("a.nav-link.active").data("engine"),
            action: "parseTitles",
        };

        axios.post(`${api_url}/v1.0/scraper/titles`, { params })
            .then((response) => {
                console.log(JSON.parse(response));
            })
            .catch((error) => {
                // console.log(error);
            });

    })

    $("a[name='selectAllChapters']").on("click", function () {

    });

    $("a[name='removeSelectedChapters']").on("click", function () {

    });

});

