import moment from 'moment'
const online_request_fields = [
    {
        key: "id",
        label: "#",
        sortable: true
    },
    {
        key: "user_id",
        label: "User",
        sortable: true,
    },
    {
        key: "name",
        label: "Name",
        sortable: true
    },
    {
        key: "description",
        label: "Description"
    },
    {
        key: "online_request_procedures",
        label: "No Procedures",
        sortable: true
    },
    {
        key: "created_at",
        label: "Created At",
        sortable: true,
        formatter: value => {
            let ago = moment(value).fromNow();
            let date = moment(value).format("MMM Do, YY");
            return `${date}, ${ago}`;
        }
    },
    {
        key: "actions",
        label: "Actions"
    }
];
const online_request_procedure_fields = [
    { key: "id", label: "#" },
    // { key: "online_request_id", label: "Online Request" },
    { key: "responsible_bureau_id", label: "Responsible Bureau" },
    { key: "description", label: "Description" },
    { key: "step_number", label: "Step" },
    { key: "created_at", label: "Created At" },
    { key: "users", label: "User(Responsible)" }
];

export {online_request_fields, online_request_procedure_fields}