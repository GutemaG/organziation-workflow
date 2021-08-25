import moment from "moment";
import * as lang from './language'
const building_fields = [
    {
        key: "id",
        label: lang.translate("ID"),
        sortable: true,
        sortDirection: "desc"
    },
    //TODO: migrate the table and uncomment this
    {
        key: "number",
        label: lang.translate("Building Number"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "number_of_offices",
        label: lang.translate("Number Of Office"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "name",
        label: lang.translate("Name"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "description",
        label: lang.translate("Description"),
        sortable: true,
        sortDirection: "desc"
    },
    { key: "actions", label: lang.translate("Actions") }
];

const request_fields = [
    { key: "#", label: "#" },
    {
        key: "name",
        label: lang.translate("Name"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "user.user_name",
        label: lang.translate("user"),
        sortable: true,
        class: "text-center"
    },
    {
        key: "description",
        label: lang.translate("Description"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "type",
        label: lang.translate("Type"),
        sortable: true,
    },
    {
        key: "created_at",
        label: lang.translate("Created At"),
        sortable: true,
        sortDirection: "desc"
    },

    {
        key: "procedures",
        label: lang.translate("Num of Procedures"),
        sortable: true
    },
    { key: "actions", label: lang.translate("Actions") }
];
const user_fields = [
    {
        key: "id",
        label: "#"
    },
    {
        key: "user_name",
        label: lang.translate("Username"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "first_name",
        label: lang.translate("First Name"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "last_name",
        label: lang.translate("Last Name"),
        sortable: true,
        sortDirection: "desc"
    },
    { key: "email", label: lang.translate("Email")},
    { key: "phone", label: lang.translate("Phone Number"), sortable: true, sortDirection: "desc" },
    {
        key: "type",
        label: lang.translate("Type"),
        formatter: (value, key, item) => {
            let newVal = "";
            if (value === "it_team_member") {
                newVal = lang.translate("IT Team");
            }
            if (value === "reception") {
                newVal = lang.translate("Reception");
            }
            if (value === "staff") {
                newVal = lang.translate("Staff");
            }
            return newVal;
        },
        sortable: true,
        sortByFormatted: true,
        filterByFormatted: true
    },
    { key: "actions", label: lang.translate("Actions") }
];
const procedure_fields = [
    {
        key: "id",
        label: "#"
    },
    {
        key: "name",
        label: lang.translate("Name"),
        sortable: true
    },
    {
        key: "description",
        label: lang.translate("Description"),
    },
    {
        key: "responsible_bureau_id",
        label: lang.translate("Responsible Bureau"),
    },
    {
        key: "step",
        label: lang.translate("Step"),
        sortable: true
    },
    {
        key: "created_at",
        label: lang.translate("Created At"),
        sortable: true
    },
    {
        key: "pre_requests",
        label: lang.translate("Num of Pre Requests"),
        sortable: true
    },
    {
        key: "actions",
        label: lang.translate("Action"),
    }
];
const procedure_pre_request_fields = [
    {
        key: "id",
        label: "#"
    },
    {
        key: "name",
        label: lang.translate("Name"),
    },
    {
        key: "description",
        label: lang.translate("Description"),
    },
    {
        key: "affair_id",
        label: lang.translate("Affair Name"),
    },
    {
        key: "created_at",
        label: lang.translate("Created At"),
    },
    {
        key: "actions",
        label: lang.translate("Actions"),
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
        label: lang.translate("User"),
        sortable: true
    },
    {
        key: "name",
        label: lang.translate("Name"),
        sortable: true
    },
    {
        key: "description",
        label: lang.translate("Description"),
    },
    {
        key: "type",
        label: lang.translate("Type"),
        sortable: true,
    },
    {
        key: "online_request_procedures",
        label: lang.translate("No Procedures"),
        sortable: true
    },
    {
        key: "created_at",
        label: lang.translate("Created At"),
        sortable: true,
        formatter: value => {
            let ago = moment(value).fromNow();
            let date = moment(value).format("MMM Do, YY");
            return `${date}, ${ago}`;
        }
    },
    {
        key: "actions",
        label: lang.translate("Actions"),
    }
];
const bureau_fields = [
    {
        key: "id",
        label: lang.translate("ID"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "name",
        label: lang.translate("Name"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "building_number",
        label: lang.translate("Building"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "office_number",
        label: lang.translate("Office Number"),
        sortable: true,
        sortDirection: "desc"
    },
    {
        key: "building_number",
        label: lang.translate("Building"),
        sortable: true,
        sortDirection: "desc"
    },
    /*{
        key: "location",
        label: lang.translate("Location"),
        sortable: true,
        formatter: (value, key, item) => {
            let location = JSON.parse(value);
            let newVal = `Lat: ${location.latitude}\t Long: ${location.longitude}`;
            return newVal;
        },
        sortDirection: "desc"
    },*/
    {
        key: "created_at",
        label: lang.translate("Created At"),
        sortable: true,
        formatter: value => {
            let ago = moment(value).fromNow(); // years or day ago
            let date = moment(value).format("MMM Do YY");
            return date + ", " + ago;
        }
    },
    {
        key: "description",
        label: lang.translate("Description"),
        sortable: true,
        sortDirection: "desc"
    },
    { key: "actions", label: lang.translate("Actions") }
];

const online_procedure_fields = [
    { key: "id", label: "#" },
    { key: "responsible_bureau_id", label: lang.translate("Responsible Bureau") },
    { key: "description", label: lang.translate("Description") },
    { key: "step_number", label: lang.translate("Step") },
    { key: "created_at", label: lang.translate("Created At") },
    { key: "users", label: ("User(Responsible)") }
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
