import '../modules';

axios.get(`${api_url}/v1.0/auth/check`,).then((response) => {
    Echo.private(`admin.${response.data.user.id}.scraper.parseTitle`)
        .listen('WS\\Scraper\\ChapterResponseReceived', (e) => {

        });

    Echo.private(`admin.${response.data.user.id}.scraper.getChapter`)
        .listen('WS\\Scraper\\GetChapterResponseReceived', (e) => {
            console.log(e);
            // $(".accordion.accordion-flush").append(e.title);
            if (e.isLast)
                $(".chapters .loader-layer").fadeOut(800);

            $(".chapters .list-group").append(e.content);
        });

    Echo.private(`admin.${response.data.user.id}.scraper.parseChapter`)
        .listen('WS\\Scraper\\ChapterRequestSent', (e) => {
            console.log(e);
        });
});


$(function () {
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
        Array.from($(this).parents("#remangaChapters").find("input[type='checkbox']:checked")).forEach(el => {
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

