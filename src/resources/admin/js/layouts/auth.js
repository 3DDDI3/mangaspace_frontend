import '../bootstrap';

$(function () {
    $("#login").on("submit", function (e) {
        e.preventDefault();

        axios.get(`${api_url}/auth/csrf-cookie`).then(response => {
            let data = {
                name: $(this).find("input[name='login']").val(),
                password: $(this).find("input[name='password']").val(),
            };
            axios.post(`${api_url}/v1.0/auth/login`, data).then(() => {
                window.location.href = "/admin/scraper";
            });
        });
    });
});