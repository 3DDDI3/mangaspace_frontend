import $ from 'jquery';
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

window.$ = $;
window.axios = axios;
window.api_url = import.meta.env.VITE_APP_API_URL;