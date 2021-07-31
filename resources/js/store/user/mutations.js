export default {
    SET_USERS(state, data) {
        state.users = data.users;
    },
    DELETE_USER(state, id) {
        state.users = state.users.filter(user => user.id !== id);
    },
    ADD_USER(state, user) {
        state.users.unshift(user);
    },
    //TODO: update this
    UPDATE_USER(state, user, id) {
        const index = state.users.findIndex(user => user.id === id);
        if (index !== -1) {
            state.users.splice(index, 1, user);
        }
    }
};
