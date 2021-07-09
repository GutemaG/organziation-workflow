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
                console.log(affairs.length);
                commit("SET_AFFAIRS", affairs);
                // console.log(response)
            } catch (error) {
                console.log(error);
            }
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
                        // Swal.fire("Success!", data.message, "success");
                        // let affair = resp.data.affair;
                        // commit("ADD_AFFAIR", affair);
                    } else {
                        console.log(resp);
                    }
                })
                .catch(function(error) {
                    console.log(error)
                    // Swal.fire("Failed!", data.message, "warning");
                });
        }
    },
    mutations: {
        SET_AFFAIRS(state, data) {
            state.affairs = data;
        },
        ADD_AFFAIR(state, data) {
            state.affairs.unshift(data)
        },
    }
};
