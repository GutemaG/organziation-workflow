import axios from "axios";
export default {
    async fetchOnlineRequests({ commit }) {
        try {
            let resp = await axios.get("/api/online-requests");
            if (resp.status === 200) {
                // console.log(resp.data.online_requests);
                commit("SET_ONLINE_REQUESTS", resp.data.online_requests);
            }
        } catch (error) {
            console.log(error);
        }
    },
    async addOnlineRequest({ commit }, data) {
        try {
            let resp = await axios.post("/api/online-requests", { ...data });
            if (resp.status === 200 || resp.status === 201) {
                commit("ADD_ONLINE_REQUEST", resp.data.online_requests);
            }
            // console.log(resp);
        } catch (error) {
            console.log(error);
        }
    },
    async removeOnlineRequest({ commit }, id) {
        try {
            let resp = await axios.delete(`/api/online-requests/${id}`);
            if (resp.status === 200) {
                commit("DELETE_ONLINE_REQUEST", id);
            }
            // console.log(resp);
        } catch (error) {
            console.log(error);
        }
    },
    async updateOnlineRequest({ commit }, data) {
        let data2 = {
            id: data.id,
            name: data.name,
            description: data.description,
            type: data.type,
            online_request_procedures: data.online_request_procedures,
            prerequisite_labels: data.prerequisite_labels
        };
        try {
            let resp = await axios.put(
                `/api/online-requests/${data2.id}`,
                data2
            );
            if (resp.data.status == 200 || resp.data.status == 201) {
                console.log("success");
            } else {
                throw new Error("Fill the form correctly");
            }
        } catch (error) {
            throw new Error(error);
        }
    },
    /** *!
     * *For Staff Notification
     */
    fetchAllAcceptedRequest({ commit }) {
        axios
            .get("/api/online-request-steps")
            .then(resp => {
                if (resp.data.status == 200) {
                    let steps = resp.data.online_request_steps;
                    commit("FETCH_ONLINE_REQUEST_STEPS", steps);
                    // console.log(this.steps);
                }
            })
            .catch(err => console.log(err));
        // Route::get('/online-request-steps', [\App\Http\Controllers\OnlineRequestStepController::class, 'index']);
    },
    fetchPendingRequests({ commit }) {
        axios
            .get("/api/online-request-applied")
            .then(resp => {
                // console.log(resp)
                if (resp.data.status == 200) {
                    let datas = resp.data.online_request_steps;
                    let pending = [];
                    datas.forEach(data => {
                        pending.push(data);
                    });
                    // console.log(pending)
                    commit("PENDING_ONLINE_REQUEST_STEPS", pending);
                }
            })
            .catch(err => console.log(err));
    },
    acceptPendingRequest({ commit }, data) {
        axios
            .get(
                `/api/online-request-applied/accept/${data.notification_tracker_id}`
            )
            .then(resp => {
                let response = resp.data;
                if (response.status == 200) {
                    commit(
                        "DELETE_PENDING_REQUEST",
                        data.notification_tracker_id
                    );
                    // this.notifications = this.notifications.filter(
                    //   (notification) =>
                    //     notification.notification_tracker_id !=
                    //     request.notification_tracker_id
                    // );
                    // this.fetchAllPendingRequest();
                }
            });
    },
    completeRequest({ commit }, data) {
        // Route::get('/online-request-applied/complete/{notification_tracker}', [\App\Http\Controllers\NotificationTrackerController::class, 'onlineRequestCompleted']);
        axios
            .get(
                `/api/online-request-applied/complete/${data.notification_tracker_id}`
            )
            .then(resp => {
                let response = resp.data;
                if (response.status == 200) {
                    commit("COMPLETE_REQUEST", data);
                }
            })
            .catch(err => console.log(err));
    }
};
