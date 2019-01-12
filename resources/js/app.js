
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.CKEditor = require('@ckeditor/ckeditor5-build-classic');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('modify-users', require('./components/AdminModifyUsersComponent.vue'));
Vue.component('subscribe-button', require('./components/SubscribeButtonComponent.vue'));
Vue.component('report-topic-button', require('./components/ReportTopicComponent.vue'));
Vue.component('report-post-button', require('./components/ReportPostComponent.vue'));
Vue.component('delete-report', require('./components/ModeratorDeleteReportButtonComponent.vue'));
Vue.component('messaging-component', require('./components/UserMessagingComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



const app = new Vue({
    el: '#app'
});
