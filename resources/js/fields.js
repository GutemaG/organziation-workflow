var fields = [
    {
        key: "name",
        label: "Person full name",
        sortable: true,
        sortDirection: "desc"
    },
    { key: "age", label: "Person age", sortable: true, class: "text-center" },
    {
        key: "isActive",
        label: "Is Active",
        formatter: (value, key, item) => {
            return value ? "Yes" : "No";
        },
        sortable: true,
        sortByFormatted: true,
        filterByFormatted: true
    },
    { key: "actions", label: "Actions" }
];
export default { fields };
