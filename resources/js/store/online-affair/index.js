import onlineAffairGetters from "./getters";
import onlineAffairActions from "./actions";
import onlineAffairMutations from "./mutations";

export default {
    state: {
        online_requests: [],
        staff_all_accepted_request: [],
        pending_requests:[],
    },
    getters: onlineAffairGetters,
    actions: onlineAffairActions,
    mutations: onlineAffairMutations
};
