import axios from "axios";

export default {
    async fetchOnlineRequests({ commit }) {
        try {
            let resp = await axios.get("/api/online-requests");
            if (resp.status === 200) {
                console.log(resp.data.online_requests);
                commit("SET_ONLINE_REQUESTS", resp.data.online_requests);
            }
        } catch (error) {
            console.log(error);
        }
    },
    async addOnlineRequest({ commit }, data) {
        try {
            let resp = await axios.post("/api/online-requests", {...data});
            if (resp.status === 200 || resp.status ===201) {
                commit("ADD_ONLINE_REQUEST", resp.data.online_requests);
            }
            console.log(resp)
        } catch (error) {
            console.log(error);
        }
    },
    async removeOnlineRequest({commit}, id){
        try{
            let resp = await axios.delete(`/api/online-requests/${id}`)
            if(resp.status===200){
                commit('DELETE_ONLINE_REQUEST', id)
            }
            console.log(resp);
        }
        catch(error){
            console.log(error)
        }
    }
};
