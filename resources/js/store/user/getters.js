export default {
    users: state => state.users,
    user_ids: state =>
        state.users.map(user=> {
            return {
                text: user.user_name,
                value: user.id
            };
        }),
    staff_ids: state => state.users.filter((user => user.type === 'staff')).map(staff =>{
        return {
            text: staff.user_name,
            value: staff.id
        };
    })
};
