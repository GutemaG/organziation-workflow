export default {
    SET_AFFAIRS(state, data) {
        state.affairs = data;
    },
    ADD_AFFAIR(state, data) {
        state.affairs.unshift(data);
    },
    DELETE_AFFAIR(state, id) {
        state.affairs = state.affairs.filter(affair => affair.id !== id);
    },
    UPDATE_AFFAIR(state, affair, id) {
        const index = state.affairs.findIndex(affair => affair.id === id);
        if (index !== -1) {
            state.affairs.splice(index, 1, affair);
        }
    },
    ADD_PROCEDURE(state, data) {
        let affair_id = data.affair_id;
        console.log('mut ', affair_id, data)
        const index = state.affairs.findIndex(
            affair => affair.id == data.affair_id
        );
        console.log('index: ', index)
        if (index !== -1) {
            state.affairs[index].procedures.push(data);
        }
    },
    ADD_PRE_REQUEST(state, data) {
        console.log("mutation: ", data);
        const index = state.affairs.findIndex(
            affair => affair.id === data.selected_affair_id
        );
        if (index !== -1) {
            let affair_procedure = state.affairs[index].procedures;
            const procedure_index = affair_procedure.findIndex(
                procedure => procedure.id === data.pre_request.procedure_id
            );
            if (procedure_index !== -1) {
                let procedure =
                    state.affairs[index].procedures[procedure_index]
                        .pre_requests;
                procedure.push(data.pre_request);
            }
        }
    }
};
