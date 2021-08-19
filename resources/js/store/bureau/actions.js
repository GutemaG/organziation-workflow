export default {
    async fetchBureaus({ commit }) {
        try {
            let response = await axios.get("/api/bureaus");
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
            .then(resp => {
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
            .then(resp => {
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
        console.log("updating ", data);
    },
    resetBureau({ commit }, selectedBureau) {
        commit("UPDATE_BUREAU", selectedBureau, selectedBureau.id);
    },

    removeBureau({ commit }, id) {
        axios
            .delete(`/api/bureaus/${id}`)
            .then(resp=>{
                if (resp.status === 200) {
                    Swal.fire("Success!","Deleted","success");
                    commit("DELETE_BUREAU", id);
                } else {
                    console.log('remove bureau status errror');
                }
            })
            .catch(function(error) {
                console.log(error);
                Swal.fire("Failed!", data.message, "warning");
            });
    }
};
