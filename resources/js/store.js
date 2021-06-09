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
            try {
                let response = await axios.get("api/users");
                commit("setUsers", response.data);
            } catch (error) {
                Swal.fire("Failed!", data.message, "warning");
            }
        },
        async removeUser({ commit }, id) {
            try {
                await axios.delete(`api/users/${id}`);
                commit("deleteUser", id);
            } catch (error) {
                Swal.fire("Failed!", data.message, "warning");
            }
        },
        async updateUser({ commit }, data) {
            await axios
                .put(`api/users/${data.id}`, {
                    ...data
                })
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    Swal.fire("Failed!", data.message, "warning");
                });
        },
        async addUser({ commit }, data){
            axios.post('api/users', {
                ...data
            }).then(function(resp){
                let user = resp.data.user
                commit("addUser", user);
            }).catch(function(error){
                Swal.fire("Failed!", data.message, "warning");
            })
        }
    },

    mutations: {
        setUsers(state, data) {
            state.users = data.users;
        },
        deleteUser(state, id) {
            state.users = state.users.filter(user => user.id !== id);
        },
        addUser(state, user){
            state.users.unshift(user);
        }
    }
});
