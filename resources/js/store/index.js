import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

import userModule from './user';

export default new Vuex.Store({
    modules: {
     user: userModule
    }
});
