import affairActions from './actions'
import affairGetters from './getters'
import affairMutations from './mutations'
export default {
    state: {
        affairs: []
    },
    getters: affairGetters,
    actions:affairActions,
    mutations: affairMutations 
};
