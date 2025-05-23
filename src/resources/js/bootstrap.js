import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';

$("input[name='login']").on("click", function (e) {
    e.preventDefault();
    window.axios.get('http://api.mangaspace.ru:83/auth/csrf-cookie',).then(response => {
        const data = {
            name: 'admin',
            password: '1234',
        };
        window.axios.post('http://api.mangaspace.ru:83/v1.0/auth/login', data);
    });
});

$("input[name='check']").on("click", function () {
    window.axios.get('http://api.mangaspace.ru:83/v1.0/auth/check').then(response => {
        console.log(response);
    });
});

window.axios.get(`http://api.mangaspace.ru:83/v1.0/auth/check`)
    .then(response => {
        window.Echo.private(`admin.scraper.1`)
            .listen('WS\\Scraper\\ParseEvent', (e) => {
                alert(e.message);
            });
    });

$("input[name='parse']").on("click", function () {
    window.axios.get(`http://api.mangaspace.ru:83/v1.0/scraper/parse`)
        .then(response => {

        });
});

$("input[name='logout']").on("click", function (e) {
    e.preventDefault();
    window.axios.post('http://api.mangaspace.ru:83/v1.0/auth/logout').then(response => {
        console.log(response);
    });
});

window.Echo.channel('test-channel').listen('NewEvent', (e) => {
    console.log(e);
});
