
export default {
    state: {
      buildings:[
          { id: 1, name: 'Registeral', building_number:"B-361",number_of_offices:"2",description:'This is bureau of something', },
          { id: 2, name: 'Unknown', building_number:"B-333",number_of_offices:"3",description:'some office ',},
          { id: 3, name: 'Dormitory', building_number:"B-372",number_of_offices:"9",description:'Dormitory of stuent', },
          { id: 4, name: 'ICT-Center', building_number:"B-529",number_of_offices:"12",description:'ICT center', },
      ],
    },
    getters: {
        buildings: state => state.buildings,
        building_numbers: state => state.buildings.map((building) =>{
            return building.building_number
        })
    },

    actions: {
        async addBuilding({ commit }, data) {
            console.log('adding ', data);
            commit('ADD_BUREAU', data)
        },
        async updateBuilding({ commit }, data) {
            console.log('updating ',data);
        }
    },

    mutations: {
        SET_BUILDING(state, data) {
            state.bureaus = data.bureaus;
        },
        DELETE_BUILDING(state, id) {
            state.bureaus = state.bureaus.filter(bureaus => bureaus.id !== id);
        },
        ADD_BUILDING(state, bureau) {
            state.bureaus.unshift(bureau);
        },
        UPDATE_BUILDING(state, bureau, id) {
            const index = state.bureaus.findIndex(bureau => bureau.id === id);
            if (index !== -1) {
                state.bureaus.splice(index, 1, bureau);
            }
        }
    }
};
