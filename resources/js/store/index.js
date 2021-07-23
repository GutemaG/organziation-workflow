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
        loggingUserError: ""
    },
    getters: {
        currentUser: state => state.loggedInUser,
        loggingUserErrorMessage: state => state.loggingUserError
    },
    actions: {
        async login({ commit }, data) {
            try {
                await axios.post("/login", {
                    ...data
                });
                window.location.replace("/dashboard");
                $("#login-modal-form").modal("hide");
                commit("SET_ERROR", "");
            } catch (error) {
                let error_msg = "These credentials do not match our records";
                commit("SET_ERROR", error_msg);
            }
        }
    },
    mutations: {
        SET_ERROR(state, data) {
            state.loggingUserError = data;
        }
    }
});
