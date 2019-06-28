/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuex  from 'vuex';
import store from './store/index';

// import 'babel-polyfill';

import 'nprogress/nprogress';


import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);

Vue.use(Vuex);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('progress-component', require('./components/app/ProgressComponent.vue').default);

Vue.component('image-component', require('./components/ImageComponent.vue').default);
Vue.component('group-member-component', require('./components/group/groupMemberComponent.vue').default);
Vue.component('group-component', require('./components/group/groupComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({

  store,

  el: '#wrapper'
});
