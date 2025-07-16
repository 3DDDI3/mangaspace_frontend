import '../modules';
import '../helper/parsley';
import Swal from 'sweetalert2';
import Cookies from 'js-cookie';
import axios from 'axios';


$(function () {
    $("#login").parsley();
    $("#signin").parsley();
    $("#reset-password").parsley();

    $("#login").on("submit", function (e) {
        e.preventDefault();

        $(".progress-block").css("display", "block");

        // axios.get(`${api_url}/auth/csrf-cookie`).then(response => {

        let _token = Cookies.get("_token");

        if (_token) {
            axios.get(`${api_url}/v1.0/auth/check`).then((response) => {
                console.log(response);
                // return;

                location.href = "/admin/scraper";
            }).catch((error) => {
                Swal.fire({
                    icon: "error",
                    title: error.response.data.message,
                    showCancelButton: false,
                    confirmButtonText: "Ok",
                });
            });
        }

        let data = {
            name: $(this).find("input[name='login']").val(),
            password: $(this).find("input[name='password']").val(),
        };

        axios.post(`${api_url}/v1.0/auth/login`, data).then((response) => {
            console.log(response);

            Cookies.set("_token", response.data.access_token, {
                expires: 365,
                domain: ".mangaspace.ru",
                sameSite: 'lax',
                // secure: true
            });

            return;
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
        // });
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