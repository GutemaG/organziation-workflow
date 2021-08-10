import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

import userModule from "./user";
import bureauModule from "./bureau";
import buildingModule from "./building";
import affairModule from "./affair";
import onlineAffairModule from "./online-affair";

export default new Vuex.Store({
    modules: {
        user: userModule,
        bureau: bureauModule,
        building: buildingModule,
        affair: affairModule,
        online: onlineAffairModule
    },
    state: {
        loggedInUser: window.user,
        loggingUserError: "",
        customerToken:""
    },
    getters: {
        currentUser: state => state.loggedInUser,
        loggingUserErrorMessage: state => state.loggingUserError,
        customerToken: state => state.customerToken
    },
    actions: {
        async login({ commit }, data) {
            try {
                let resp = await axios.post("/login", {
                    ...data
                });
                // console.log(resp);
                // return;
                // window.location.replace("/dashboard");
                // $("#login-modal-form").modal("hide");
                // commit("SET_ERROR", "");
            } catch (err) {
                let error_msg =
                    "These credentials do not match our records, please try again";
                const error = new Error(error_msg);
                throw error;
                // commit("SET_ERROR", error_msg);
            }
        },
        setToken({commit}, token){
           commit("SET_TOKEN", token) 
        },
        removeToken({commit}){
            commit('REMOVE_TOKEN')
        }
    },
    mutations: {
        SET_ERROR(state, data) {
            state.loggingUserError = data;
        },
        SET_TOKEN(state, token){
            state.customerToken = token
        },
        REMOVE_TOKEN(state){
            state.customerToken = ""
        }
    }
});
