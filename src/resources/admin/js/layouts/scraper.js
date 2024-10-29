import '../modules';

Echo.private(`admin.scraper.1`)
    .listen('WS\\Scraper\\ParseEvent', (e) => {
        alert(e.message);
    });

$(function () {
    $(".tab-pane.fade.active.show a[name='parse']").on("click", function () {
        axios.post(`${api_url}/v1.0/scraper/parse`, { pages: $(this).parent(".row").find("input [type='text']") })
            .then((response) => {
                console.log(response);
            });
    });

    $(".tab-pane.fade.active.show a[name='getChapters']").on("click", function () {
        // axios.post(`${api_url}/v1.0/scraper/get-chapters`, { url: $(this).parents(".row").find("input[type='text']").val() })
        //     .then((response) => {
        //         console.log(response);
        //     })
        //     .catch((error) => {
        //         console.log(error);
        //     });
    });


});

