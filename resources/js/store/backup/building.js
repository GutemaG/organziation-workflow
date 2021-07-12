
/*{ id: 1, name: 'Registeral', building_number:"B-361",number_of_offices:"2",description:'This is bureau of something', },
{ id: 2, name: 'Unknown', building_number:"B-333",number_of_offices:"3",description:'some office ',},
{ id: 3, name: 'Dormitory', building_number:"B-372",number_of_offices:"9",description:'Dormitory of stuent', },
{ id: 4, name: 'ICT-Center', building_number:"B-529",number_of_offices:"12",description:'ICT center', },
*/
export default {
    state: {
      buildings:[],
    },
    getters: {
        buildings: state => state.buildings,
        building_numbers: state => state.buildings.map((building) =>{
            // return {"value":building.id, "text":building.number}
            // return parseInt(building.number)
            return building.number
        })
    },

    actions: {
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
    },

    mutations: {
        SET_BUILDING(state, data) {
            state.buildings = data.buildings;
        },
        DELETE_BUILDING(state, id) {
            state.buildings = state.buildings.filter(building => building.id !== id);
        },
        ADD_BUILDING(state, building) {
            state.buildings.unshift(building);
        },
        UPDATE_BUILDING(state, building, id) {
            const index = state.buildings.findIndex(building => building.id === id);
            if (index !== -1) {
                state.buildings.splice(index, 1, building);
            }
        }
    }
};
