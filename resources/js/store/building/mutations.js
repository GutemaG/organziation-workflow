export default {
    SET_BUILDING(state, data) {
        state.buildings = data.buildings;
    },
    DELETE_BUILDING(state, id) {
        state.buildings = state.buildings.filter(
            building => building.id !== id
        );
    },
    ADD_BUILDING(state, building) {
        state.buildings.unshift(building);
    },
    UPDATE_BUILDING(state, building, id) {
        const index = state.buildings.findIndex(building => building.id === id);
        if (index !== -1) {
            state.buildings.splice(index, 1, building);
        }
    },
    DELETE_BUILDING(state, id) {
        state.buildings = state.buildings.filter(building => building.id !== id);
    }
};
