
import onlineAffairGetters from './getters'
import onlineAffairActions from './actions'
import onlineAffairMutations from './mutations'

export default {
    state:{
        online_requests:[],
    },
    getters: onlineAffairGetters,
    actions: onlineAffairActions,
    mutations: onlineAffairMutations
}