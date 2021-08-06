export default {
    online_requests: state => state.online_requests,
    findRequest: (state) => (name) => {
        return state.online_requests.find(req => req.name == name);
    }
};
//  getTodoById: (state) => (id) => {
//     return state.todos.find(todo => todo.id === id)
//   }
// }