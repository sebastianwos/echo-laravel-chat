
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

import EchoLibrary  from "laravel-echo"

window.Echo = new EchoLibrary({
    broadcaster: 'pusher',
    key: 'fb0de519317bca54e90e'
});

Vue.component('public-chat', require('./components/PublicChat.vue'));

const app = new Vue({
    el: 'body'
});
