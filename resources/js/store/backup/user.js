export default {
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
                commit("SET_USERS", response.data);
            } catch (error) {
                Swal.fire("Failed!", data.message, "warning");
            }
        },
        async removeUser({ commit }, id) {
            try {
                await axios.delete(`api/users/${id}`);
                commit("DELETE_USER", id);
            } catch (error) {
                Swal.fire("Failed!", data.message, "warning");
            }
        },
        async updateUser({ commit }, data) {
            await axios
                .put(`api/users/${data.id}`, {
                    ...data
                })
                .then(function(resp) {
                    if (resp.data.status === 200 || resp.data.status === 201) {
                        Swal.fire("Success!", data.message, "success");
                        let user = resp.data.user;
                        commit("UPDATE_USER", user, data.id);
                    } else {
                        console.log(resp.data.error);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                    Swal.fire("Failed!", data.message, "warning");
                });
        },
        async addUser({ commit }, data) {
            axios
                .post("api/users", {
                    ...data
                })
                .then(function(resp) {
                    if (resp.data.status === 200 || resp.data.status === 201) {
                        Swal.fire("Success!", data.message, "success");
                        let user = resp.data.user;
                        commit("ADD_USER", user);
                    } else {
                        console.log(resp);
                    }
                })
                .catch(function(error) {
                    Swal.fire("Failed!", data.message, "warning");
                });
        }
    },

    mutations: {
        SET_USERS(state, data) {
            state.users = data.users;
        },
        DELETE_USER(state, id) {
            state.users = state.users.filter(user => user.id !== id);
        },
        ADD_USER(state, user) {
            state.users.unshift(user);
        },
        //TODO: update this
        UPDATE_USER(state, user, id) {
            const index = state.users.findIndex(user => user.id === id);
            if (index !== -1) {
                state.users.splice(index, 1, user);
            }
        }
    }
};
