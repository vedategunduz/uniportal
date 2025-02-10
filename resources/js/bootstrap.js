// import axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import fetchData from './fetch';
import * as alert from './alert';
import './echo';

const ApiService = {
    fetchData,
    alert,
}

window.ApiService = ApiService;
