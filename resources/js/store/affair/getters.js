export default {
    affairs: state => state.affairs,
    affair_ids: state =>
        state.affairs.map(affair => {
            return {
                text: affair.name,
                value: affair.id
            };
        }),
    findAffair: state=>(id)=>{
        let aff = state.affairs.filter(affair => affair.id == id)[0]
        return aff
        return 'id: ' + id
    }
};
