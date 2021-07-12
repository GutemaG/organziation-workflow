export default {
    SET_AFFAIRS(state, data) {
        state.affairs = data;
    },
    ADD_AFFAIR(state, data) {
        state.affairs.unshift(data);
    },
    DELETE_AFFAIR(state, id) {
        state.affairs = state.affairs.filter(affair => affair.id !== id);
    },
    UPDATE_AFFAIR(state, affair, id) {
        const index = state.affairs.findIndex(affair => affair.id === id);
        if (index !== -1) {
            state.affairs.splice(index, 1, affair);
        }
    }
};
