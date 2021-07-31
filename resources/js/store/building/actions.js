export default {
    async fetchBuildings({ commit }) {
        try {
            let response = await axios.get("api/buildings");
            commit("SET_BUILDING", response.data);
        } catch (error) {
            Swal.fire("Failed!", error.message, "warning");
        }
    },
    async addBuilding({ commit }, data) {
        axios
            .post("api/buildings", {
                ...data
            })
            .then(function(resp) {
                if (resp.data.status === 200 || resp.data.status === 201) {
                    Swal.fire("Success!", data.message, "success");
                    let building = resp.data.building;
                    commit("ADD_BUILDING", building);
                } else {
                    console.log(resp);
                }
            })
            .catch(function(error) {
                Swal.fire("Failed!", error.message, "warning");
            });
    },
    async updateBuilding({ commit }, data) {
        // console.log(data)
        await axios
            .put(`api/buildings/${data.id}`, {
                ...data
            })
            .then(function(resp) {
                if (resp.data.status === 200 || resp.data.status === 201) {
                    Swal.fire("Success!", data.message, "success");
                    let building = resp.data.buildings;
                    commit("UPDATE_BUILDING", building, data.id);
                } else {
                    console.log(resp.data.error);
                }
            })
            .catch(function(error) {
                console.log(error);
                Swal.fire("Failed!", data.message, "warning");
            });
    }
};
