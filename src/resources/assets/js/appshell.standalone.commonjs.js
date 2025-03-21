import Alpine from 'alpinejs'
import * as bootstrap from 'bootstrap'
import axios from "axios";

window.Alpine = Alpine
window.bootstrap = bootstrap

/** AXIOS */
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Alpine.start();

require('./appshell');

import NiceSelect from "./nice-select2";

window.addEventListener('load',()=>{
  document.querySelectorAll("select[multiple]").forEach(
    function (el) {
      new NiceSelect(el, { searchable: el.getAttribute('searchable') });
    }
  );
});
