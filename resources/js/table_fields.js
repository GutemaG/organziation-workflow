import moment from "moment";
const building_fields = [
    {
        key: "id",
        label: "ID",
        sortable: true,
        sortDirection: "desc"
    },
    //TODO: migrate the table and uncomment this
    {
        key: "number",
        label: "Building Number",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "number_of_offices",
        label: "Number Of Office",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "name",
        label: "Name",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "description",
        label: "Description",
        sortable: true,
        sortDirection: "desc"
    },
    { key: "actions", label: "Actions" }
];

const request_fields = [
    { key: "#", label: "#" },
    {
        key: "name",
        label: "Name",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "user.user_name",
        label: "user",
        sortable: true,
        class: "text-center"
    },
    {
        key: "description",
        label: "Description",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "created_at",
        label: "Created At",
        sortable: true,
        sortDirection: "desc"
    },

    {
        key: "procedures",
        label: "Num of Procedures",
        sortable: true
    },
    { key: "actions", label: "Actions" }
];
const user_fields = [
    {
        key: "id",
        label: "#"
    },
    {
        key: "user_name",
        label: "Username",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "first_name",
        label: "First Name",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "last_name",
        label: "Last Name",
        sortable: true,
        sortDirection: "desc"
    },
    { key: "email", label: "email" },
    { key: "phone", label: "Phone", sortable: true, sortDirection: "desc" },
    {
        key: "type",
        label: "Type",
        formatter: (value, key, item) => {
            let newVal = "";
            if (value === "it_team_member") {
                newVal = "IT Team";
            }
            if (value === "reception") {
                newVal = "Reception";
            }
            if (value === "staff") {
                newVal = "Staff";
            }
            return newVal;
        },
        sortable: true,
        sortByFormatted: true,
        filterByFormatted: true
    },
    { key: "actions", label: "Actions" }
];
const procedure_fields = [
    {
        key: "id",
        label: "#"
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
        key: "step",
        label: "Step",
        sortable: true
    },
    {
        key: "created_at",
        label: "Created At",
        sortable: true
    },
    {
        key: "pre_requests",
        label: "Num of Pre Requests",
        sortable: true
    },
    {
        key: "actions",
        label: "Action"
    }
];
const procedure_pre_request_fields = [
    {
        key: "id",
        label: "#"
    },
    {
        key: "name",
        label: "Name"
    },
    {
        key: "description",
        label: "Description"
    },
    {
        key: "affair_id",
        label: "Affair Name"
    },
    {
        key: "created_at",
        label: "Created At"
    },
    {
        key: "actions",
        label: "Actions"
    }
];
const online_request_fields = [
    {
        key: "id",
        label: "#",
        sortable: true
    },
    {
        key: "user_id",
        label: "User",
        sortable: true
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
const bureau_fields = [
    {
        key: "id",
        label: "ID",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "name",
        label: "Name",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "building_number",
        label: "Building",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "office_number",
        label: "Office Number",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "building_number",
        label: "Building",
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "location",
        label: "Location",
        sortable: true,
        formatter: (value, key, item) => {
            let location = JSON.parse(value);
            let newVal = `Lat: ${location.latitude}\t Long: ${location.longitude}`;
            return newVal;
        },
        sortDirection: "desc"
    },
    {
        key: "created_at",
        label: "Created At",
        sortable: true,
        formatter: value => {
            let ago = moment(value).fromNow(); // years or day ago
            let date = moment(value).format("MMM Do YY");
            return date + ", " + ago;
        }
    },
    {
        key: "description",
        label: "Description",
        sortable: true,
        sortDirection: "desc"
    },
    { key: "actions", label: "Actions" }
];

const online_procedure_fields = [
    { key: "id", label: "#" },
    { key: "responsible_bureau_id", label: "Responsible Bureau" },
    { key: "description", label: "Description" },
    { key: "step_number", label: "Step" },
    { key: "created_at", label: "Created At" },
    { key: "users", label: "User(Responsible)" }
];
export {
    building_fields,
    request_fields,
    user_fields,
    bureau_fields,
    online_request_fields,
    procedure_fields,
    procedure_pre_request_fields
};
// online_procedure_fields,
