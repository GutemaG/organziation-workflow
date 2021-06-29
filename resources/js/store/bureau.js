
export default {
    state: {
      bureaus:[
          { id: 1, name: 'Registeral', building:"B-361",office_number:"2",description:'This is bureau of something', },
          { id: 2, name: 'Unknown', building:"B-333",office_number:"3",description:'some office ',},
          { id: 3, name: 'Dormitory', building:"B-372",office_number:"9",description:'Dormitory of stuent', },
          { id: 4, name: 'ICT-Center', building:"B-529",office_number:"12",description:'ICT center', },
      ],
    },
    getters: {
        bureaus: state => state.bureaus
    },

    actions: {
        async addBureau({ commit }, data) {
            console.log('adding ', data);
            commit('ADD_BUREAU', data)
        },
        async updateBureau({ commit }, data) {
            console.log('updating ',data);
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
