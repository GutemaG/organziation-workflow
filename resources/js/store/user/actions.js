export default {
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
        try {
            let resp = await axios.post("api/users", {
                ...data
            });
            if (resp.data.status === 200 || resp.data.status === 201) {
                Swal.fire("Success!", data.message, "success");
                let user = resp.data.user;
                commit("ADD_USER", user);
            }
            if (resp.data.status === 400) {
                let error = resp.data.error;
                console.log(resp.data.error);
            }
        } catch (error) {
            Swal.fire("Failed!", "Your Server is Down", "warning");
        }
    }
};

//   this.$bvModal.hide("add-user-modal");
// $("#add-user-modal").modal("hide");
/*
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
            */
