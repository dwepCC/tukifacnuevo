import Vue from 'vue';
import lodash from 'lodash';
import moment from 'moment';
import jquery from 'jquery';

window._ = lodash;
window.moment = moment;
window.$ = window.jQuery = jquery;

// try {
//     window.$ = window.jQuery = require('jquery');
//     require('bootstrap');
// } catch (e) {}

import axios from 'axios';
import xmljs from 'xml-js';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    window.headers_token = {
        'X-CSRF-TOKEN': token.content,
    }
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.prototype.$http = axios;

Vue.prototype.$setStorage =   function(name,obj){
    localStorage.setItem(name, JSON.stringify(obj));
};
Vue.prototype.$getStorage = function(name){
    return JSON.parse(localStorage.getItem(name));
};

import './vendor/perfect-scrollbar.jquery.min';
import './vendor/sidebarmenu';
import './vendor/waves';
import './vendor/custom';

window.parseXMLToJSON = function(source){
    try{
        return JSON.parse(xmljs.xml2json(source, {compact: true, spaces: 0}));
    }catch(e){
        return null;
    }
};

$(function () {
    const listElements = document.getElementsByClassName('nav-active');
    if (listElements.length > 0) {
        listElements[0].scrollIntoView();
    }
});


const mercadopago = window.Mercadopago;

if(mercadopago)
{
    mercadopago.setPublishableKey(window.token_mercado_pago);
    mercadopago.getIdentificationTypes();
}
