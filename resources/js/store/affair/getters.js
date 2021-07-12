export default {
    affairs: state => state.affairs,
    affair_ids: state =>
        state.affairs.map(affair => {
            return {
                text: affair.name,
                value: affair.id
            };
        })
};
