import userActions from './actions'
import userGetters from './getters'
import userMutations from './mutations'
export default {
    state: {
        users: []
    },
    getters: userGetters,

    actions: userActions,

    mutations: userMutations
};