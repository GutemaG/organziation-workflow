export default [
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
        key: "procedures.length",
        label: "Procedures",
        sortable: true
    },
    { key: "actions", label: "Actions" }
];
