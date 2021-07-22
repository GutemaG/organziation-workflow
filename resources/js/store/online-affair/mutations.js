export default{
    SET_ONLINE_REQUESTS(state, data){
        state.online_requests = data
    },
    ADD_ONLINE_REQUEST(state, data){
        state.online_requests.unshift(data);
    },
    DELETE_ONLINE_REQUEST(state, id){
        let index = state.online_requests.findIndex(request => request.id == id)
        if(index !== -1){
            state.online_requests.splice(index, 1)
        }
    }
}