import '../modules';
import '../helper/parsley';
import Swal from 'sweetalert2';


$(function () {
    $("#login").parsley();
    $("#signin").parsley();
    $("#reset-password").parsley();

    $("#login").on("submit", function (e) {
        e.preventDefault();

        $(".progress-block").css("display", "block");

        axios.get(`${api_url}/auth/csrf-cookie`).then(response => {
            let data = {
                name: $(this).find("input[name='login']").val(),
                password: $(this).find("input[name='password']").val(),
            };
            axios.post(`${api_url}/v1.0/auth/login`, data).then(() => {
                window.location.href = "/admin/scraper";
            }).catch((error) => {
                $(".progress-block").css("display", "none");
                Swal.fire({
                    icon: "error",
                    title: error.response.data.message,
                    showCancelButton: false,
                    confirmButtonText: "Ok",
                });
            });
        });
    });

    // $("#signin").on("submit", function (e) {
    //     e.preventDefault();

    //     let data = {
    //         name: $(this).find("input[name='name']").val(),
    //         email: $(this).find("input[name='email']").val(),
    //         password: $(this).find("input[name='password']").val(),
    //     };

    //     axios.post(`${api_url}/v1.0/auth/signup`, data).then(() => {
    //         // window.location.href = "/admin/scraper";
    //     }).catch((error) => {
    //         Swal.fire({
    //             icon: "error",
    //             title: error.response.data.message,
    //             showCancelButton: false,
    //             confirmButtonText: "Ok",
    //         });
    //     });
    // });
});