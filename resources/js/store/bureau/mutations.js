export default {
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
    },
};
