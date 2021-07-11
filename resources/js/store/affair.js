import axios from "axios";

export default {
    state: {
        affairs: []
    },
    getters: {
        affairs: state => state.affairs,
    },
    actions: {
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
        async addAffair({commit}, data){
            // console.log(data);
            axios
                .post("api/affairs", {
                    ...data
                })
                .then(function(resp) {
                    if (resp.data.status === 200 || resp.data.status === 201) {
                        console.log(resp)
                        Swal.fire("Success!", data.message, "success");
                        let affair = resp.data.affair;
                        commit("ADD_AFFAIR", affair);
                    } else {
                        console.log(resp);
                    }
                })
                .catch(function(error) {
                    console.log(error)
                    Swal.fire("Failed!", data.message, "warning");
                });
        },
        async removeAffair({ commit }, id){
            try {
                let response = await axios.delete(`api/affairs/${id}`);
                if(response.data.status ===200){
                    Swal.fire("Success!","deleted", "success");
                    commit('DELETE_AFFAIR', id)
                }else{
                    Swal.fire("Failed!",response.data.error, "error");
                }
                // commit("DELETE_USER", id);
            } catch (error) {
                Swal.fire("Failed!", error.message, "warning");
            }
        }
    },
    mutations: {
        SET_AFFAIRS(state, data) {
            state.affairs = data;
        },
        ADD_AFFAIR(state, data) {
            state.affairs.unshift(data)
        },
        DELETE_AFFAIR(state, id){
            state.affairs = state.affairs.filter(affair => affair.id !== id);
        },
        UPDATE_AFFAIR(state, affair, id) {
            const index = state.affairs.findIndex(affair => affair.id === id);
            if (index !== -1) {
                state.affairs.splice(index, 1, affair);
            }
        }
    }
};
