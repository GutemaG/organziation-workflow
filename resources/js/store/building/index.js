import buildingActions from "./actions";
import buildingGetters from "./getters";
import buildingMutations from "./mutations";

export default {
    state: {
        buildings: []
    },
    getters: buildingGetters,

    actions: buildingActions,

    mutations: buildingMutations
};
