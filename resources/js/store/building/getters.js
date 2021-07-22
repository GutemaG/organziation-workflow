export default {
    buildings: state => state.buildings,
    building_numbers: state =>
        state.buildings.map(building => {
            // return {"value":building.id, "text":building.number}
            // return parseInt(building.number)
            return building.number;
        })
};
