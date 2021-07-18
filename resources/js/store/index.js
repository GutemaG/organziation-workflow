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
        loggedInUser: window.user
    },
    getters: {
        currentUser: state => state.loggedInUser
    },
    actions: {
        login({ commit }, data) {
            axios
                .post("/login", {
                    ...data
                })
                .then(resp => {
                    window.location.replace("/dashboard");
                    $("#login-modal-form").modal("hide");
                    console.log(resp);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
});
