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
            console.log(resp);
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
            console.log(resp);
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
    }
};
