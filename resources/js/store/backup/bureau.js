export default {
    state: {
      bureaus:[],
    },
    getters: {
        bureaus: state => state.bureaus
    },

    actions: {
        async fetchBureaus({ commit }) {
            try {
                let response = await axios.get("api/bureaus");
                commit("SET_BUREAUS", response.data);
            } catch (error) {
                Swal.fire("Failed!", error.message, "warning");
            }
        },
        async addBureau({ commit }, data) {
            axios
                .post("api/bureaus", {
                    ...data
                })
                .then((resp) =>{
                    if (resp.data.status === 200 || resp.data.status === 201) {
                        Swal.fire("Success!", data.message, "success");
                        let bureau = resp.data.bureau;
                        commit("ADD_BUREAU", bureau);
                    } else {
                        console.log(resp);
                    }
                })
                .catch(function(error) {
                    Swal.fire("Failed!", error.message, "warning");
                });
        },
        async updateBureau({ commit }, data) {
            await axios
                .put(`api/bureaus/${data.id}`, {
                    ...data
                })
                .then((resp) => {
                    if (resp.data.status === 200 || resp.data.status === 201) {
                        Swal.fire("Success!", data.message, "success");
                        let bureau = resp.data.bureau;
                        commit("UPDATE_BUREAU", bureau, data.id);
                    } else {
                        console.log(resp.data.error);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                    Swal.fire("Failed!", error.message, "warning");
                });
            console.log('updating ',data);
        },
        resetBureau({commit}, selectedBureau){
            commit("UPDATE_BUREAU", selectedBureau, selectedBureau.id)
        }
    },

    mutations: {
        SET_BUREAUS(state, data) {
            state.bureaus = data.bureaus;
        },
        DELETE_BUREAU(state, id) {
            state.bureaus = state.bureaus.filter(bureaus => bureaus.id !== id);
        },
        ADD_BUREAU(state, bureau) {
            state.bureaus.unshift(bureau);
        },
        UPDATE_BUREAU(state, bureau, id) {
            const index = state.bureaus.findIndex(bureau => bureau.id === id);
            if (index !== -1) {
                state.bureaus.splice(index, 1, bureau);
            }
        }
    }
};
