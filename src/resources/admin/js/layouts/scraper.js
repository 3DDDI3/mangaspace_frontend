import '../modules';

axios.get(`${api_url}/v1.0/auth/check`,).then((response) => {
    Echo.private(`admin.scraper.${response.data.user.id}.request`)
        .listen('WS\\Scraper\\RequestSent', (e) => {
            console.log(e);
        });

    Echo.private(`admin.scraper.${response.data.user.id}.response`)
        .listen('WS\\Scraper\\ResponseReceived', (e) => {
            console.log(e);
        });
});


$(function () {
    $(".tab-pane.fade.active.show a[name='parse']").on("click", function () {

        axios.post(`${api_url}/v1.0/scraper/parse`, { pages: $(this).parents(".row").find(".input-group input[type='text']").val() })
            .then((response) => {
                console.log(response);
            });
    });

    $(".tab-pane.fade.active.show a[name='getChapters']").on("click", function () {
        axios.post(`${api_url}/v1.0/scraper/get-chapters`, { url: $(this).parents(".row").find("input[type='text']").val() })
            .then((response) => {
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            });
    });


});

