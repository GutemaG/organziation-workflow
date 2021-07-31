import bureauGetters from './getters'
import bureauActions from './actions'
import bureauMutations from './mutations'

export default {
    state: {
      bureaus:[],
    },
    getters: bureauGetters,

    actions: bureauActions,

    mutations: bureauMutations 
};
