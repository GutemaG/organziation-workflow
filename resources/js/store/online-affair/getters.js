export default {
    online_requests: state => state.online_requests,
    findRequest: state => name => {
        return state.online_requests.find(req => req.name == name);
    },
    staff_all_accepted_request: state => state.staff_all_accepted_request,
    pending_requests: state => state.pending_requests
};
//  getTodoById: (state) => (id) => {
//     return state.todos.find(todo => todo.id === id)
//   }
// }
