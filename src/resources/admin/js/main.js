import axios from "axios";

$(function () {
    $("#signin").on("submit", function (e) {
        e.preventDefault();
        axios.get('http://api.mangaspace.ru:83/v1.0/auth/login').then(

        );
        console.log(1);
    });
});