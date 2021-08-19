import moment from "moment";
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
    COMPLETE_REQUEST(state, request) {
        console.log("mutation: ", request);
        let index = state.staff_all_accepted_request.findIndex(
            req =>
                req.notification_tracker_id == request.notification_tracker_id
        );
        if (index != -1) {
            request["ended_at"] = moment.now();
            request["is_completed"] = 1;
            request["is_rejected"] = 0;
            state.staff_all_accepted_request.splice(index, 1, request);
        }
    },
    REJECT_REQUEST(state, request) {
        let index = state.staff_all_accepted_request.findIndex(
            req =>
                req.notification_tracker_id == request.notification_tracker_id
        );
        if (index != -1) {
            state.staff_all_accepted_request.splice(index, 1, request);
        }
    }
};
