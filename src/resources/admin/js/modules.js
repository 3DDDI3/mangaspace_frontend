import $ from 'jquery';
import axios from 'axios';
import Cookies from 'js-cookie';

import '../../js/echo';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.headers.common['Authorization'] = `Bearer ${Cookies.get("_token")}`;

window.$ = $;
window.axios = axios;
window.Pusher = Pusher;
window.Echo = Echo;
window.api_url = import.meta.env.VITE_APP_API_URL;