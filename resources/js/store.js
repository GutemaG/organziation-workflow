import Vue from "vue";

import Vuex from "vuex";
Vue.use(Vuex);
const axios = require("axios").default;

export default new Vuex.Store({
    state: {
        users: []
    },
    getters: {
        users: state => state.users
    },

    actions: {
        async fetchUsers({ commit }) {
            console.log("Fetching User.....");
            try {
                let response = await axios.get("api/users");
                commit("setUsers", response.data);
            } catch (error) {
                console.log(error);
            }
        },
        async removeUser({ commit }, id) {
            console.log("Deleting User.....");
            try {
                await axios.delete(`api/users/${id}`);
                commit("deleteUser", id);
            } catch (error) {
                Swal.fire("Failed!", data.message, "warning");
                // console.log(error);
            }
        },
        async updateUser({ commit }, data) {
			console.log(data)
            axios
                .put(`api/users/${data.id}`, {
                    ...data
                })
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    },

    mutations: {
        setUsers(state, data) {
            state.users = data.users;
        },
        deleteUser(state, id) {
            state.users = state.users.filter(user => user.id !== id);
        }
    }
});
