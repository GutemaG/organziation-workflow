export default {
    async fetchAffairs({ commit }) {
        try {
            let response = await axios.get("api/affairs");

            let affairs = response.data.affairs;
            commit("SET_AFFAIRS", affairs);
            // console.log(response)
        } catch (error) {
            console.log(error);
        }
    },
    async updateAffair({ commit }, data) {
        await axios
            .put(`/api/affairs/${data.affair.id}`, {
                ...data
            })
            .then(function(resp) {
                if (resp.data.status === 200 || resp.data.status === 201) {
                    Swal.fire("Success!", data.message, "success");
                    let affair = resp.data.affair;
                    commit("UPDATE_AFFAIR", affair, data.affair.id);
                } else {
                    console.log(resp.data.error);
                }
            })
            .catch(function(error) {
                console.log(error);
                Swal.fire("Failed!", data.message, "warning");
            });
    },
    async addAffair({ commit }, data) {
        // console.log(data);
        axios
            .post("api/affairs", {
                ...data
            })
            .then(function(resp) {
                if (resp.data.status === 200 || resp.data.status === 201) {
                    console.log(resp);
                    Swal.fire("Success!", data.message, "success");
                    let affair = resp.data.affair;
                    commit("ADD_AFFAIR", affair);
                } else {
                    console.log(resp);
                }
            })
            .catch(function(error) {
                console.log(error);
                Swal.fire("Failed!", data.message, "warning");
            });
    },
    async removeAffair({ commit }, id) {
        try {
            let response = await axios.delete(`api/affairs/${id}`);
            if (response.data.status === 200) {
                Swal.fire("Success!", "deleted", "success");
                commit("DELETE_AFFAIR", id);
            } else {
                Swal.fire("Failed!", response.data.error, "error");
            }
            // commit("DELETE_USER", id);
        } catch (error) {
            Swal.fire("Failed!", error.message, "warning");
        }
    },
    async removeProcedure({ commit }, ids) {
        try {
            let response = await axios.delete(
                `/api/delete-procedure/${ids.procedure_id}/${ids.affair_id}`
            );
            if (response.data.status === 200) {
                Swal.fire("Success!", "deleted", "success");
                // commit('DELETE_AFFAIR', id)
            } else {
                Swal.fire("Failed!", response.data.error, "error");
            }
            // commit("DELETE_USER", id);
        } catch (error) {
            Swal.fire("Failed!", error.message, "warning");
        }
    },
    // Todo: delete procedure and delete pre-request
    async removePreRequest({ commit }, ids) {
        try {
            let response = await axios.delete(
                `/api/delete-pre-request/${ids.pre_request_id}/${ids.procedure_id}`
            );
            if (response.data.status === 200) {
                Swal.fire("Success!", "deleted", "success");
                // commit('DELETE_AFFAIR', id)
            } else {
                Swal.fire("Failed!", response.data.error, "error");
            }
            // commit("DELETE_USER", id);
        } catch (error) {
            Swal.fire("Failed!", error.message, "warning");
        }
    }
};
