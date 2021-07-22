export default {
    bureaus: state => state.bureaus,
    bureau_ids: state =>
        state.bureaus.map(bureau => {
            return {
                text: bureau.name,
                value: bureau.id
            };
        })
};
