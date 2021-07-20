/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import "../sass/app.scss";
window.Vue = require("vue").default;

const axios = require("axios").default;

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

import VueProgressBar from "vue-progressbar";
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "3px"
});

import Swal from "sweetalert2";
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
window.Swal = Swal;
window.Toast = Toast;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i)
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "edit-user-modal",
    require("./components/user/EditModal.vue").default
);
Vue.component(
    "add-user-modal",
    require("./components/user/AddUserModal.vue").default
);
Vue.component("home", require("./components/Home.vue").default);
Vue.component(
    "add-bureau-modal",
    require("./components/bureau/AddBureauModal.vue").default
);
Vue.component(
    "edit-bureau-modal",
    require("./components/bureau/EditBureauModal.vue").default
);
Vue.component(
    "add-building-modal",
    require("./components/building/AddBuildingModal.vue").default
);
Vue.component(
    "edit-building-modal",
    require("./components/building/EditBuildingModal.vue").default
);
Vue.component("base-input", require("./components/Base/BaseInput.vue").default);
Vue.component("base-card", require("./components/Base/BaseCard.vue").default);
Vue.component(
    "base-pagination",
    require("./components/Base/BasePagination.vue").default
);
Vue.component(
    "add-procedure",
    require("./components/request/AddProcedure.vue").default
);
Vue.component(
    "add-pre-request",
    require("./components/request/AddPreRequest.vue").default
);
Vue.component("vue-login", require("./components/auth/Login.vue").default);
Vue.component(
    "vue-welcome",
    require("./components/welcome/Welcome.vue").default
);
Vue.component(
    "guest-welcome",
    require("./components/welcome/GuestWelcome.vue").default
);
Vue.component("nav-bar", require("./components/include/NavBar.vue").default);
Vue.component("side-bar", require("./components/include/SideBar.vue").default);

// import { FadeTransition } from "vue2-transitions";
// Vue.component('fade-transition', FadeTransition);

// element ui language configuration
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
locale.use(lang);

import { Button, Table, Pagination, Step, Steps, Card } from "element-ui";
Vue.use({ locale }, Table, Button, Pagination, Steps, Step, Card);

//Registering new component
//import components from './components'
//Vue.component(components);

// import Transitions from 'vue2-transitions'
// Vue.use(Transitions)

import store from "./store";
import Vue from "vue";

import BootstrapVue from "bootstrap-vue";
Vue.use(BootstrapVue);

import Vuelidate from "vuelidate";
Vue.use(Vuelidate);

import * as VeeValidate from "vee-validate";
Vue.use(VeeValidate);

import Vuex from "vuex";
Vue.use(Vuex);

import VueRouter from "vue-router";
Vue.use(VueRouter);

import routes from "./routes";
const router = new VueRouter({
    mode: "history",
    routes
});

const app = new Vue({
    el: "#app",
    router,
    store
});
