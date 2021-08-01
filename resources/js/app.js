/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import "../sass/app.scss";
window.Vue = require("vue").default;

const axios = require("axios").default;

// import Gate from "./Gate";
// Vue.prototype.$gate = new Gate(window.user);

import VueProgressBar from "vue-progressbar";
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "5px",
    thickness: "5px"
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

import "./components";
// import { FadeTransition } from "vue2-transitions";
// Vue.component('fade-transition', FadeTransition);

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

router.beforeEach((to, _, next) => {
    let current = window.user;
    if (to.meta.requiresAuth) {
        if (!current) {
            next("/login");
        } else {
            if (current && to.name == "login") {
                next("/");
            } else {
                next();
            }
        }
    } else if (current && to.name == "login") {
        next("/");
    } else {
        next();
    }
});

const app = new Vue({
    el: "#app",
    router,
    store
});
