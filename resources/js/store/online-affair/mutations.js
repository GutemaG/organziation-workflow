export default {
    SET_ONLINE_REQUESTS(state, data) {
        state.online_requests = data;
    },
    ADD_ONLINE_REQUEST(state, data) {
        state.online_requests.unshift(data);
    },
    DELETE_ONLINE_REQUEST(state, id) {
        let index = state.online_requests.findIndex(
            request => request.id == id
        );
        if (index !== -1) {
            state.online_requests.splice(index, 1);
        }
    },
    /** *!
     * *For Staff Notification and Dashboard
     */
    FETCH_ONLINE_REQUEST_STEPS(state, steps) {
        state.staff_all_accepted_request = steps;
    },
    PENDING_ONLINE_REQUEST_STEPS(state, pending_requests) {
        state.pending_requests = pending_requests;
    },
    DELETE_PENDING_REQUEST(state, id) {
        let index = state.pending_requests.findIndex(
            req => req.notification_tracker_id == id
        );
        if (index !== -1) {
            state.pending_requests.splice(index, 1);
        }
    },
    COMPLETE_REQUEST(state, id){
        console.log(state)
    }
};
