// import Dashboard from './components/Dashboard.vue';
import store from "./store";
let currentUser = store.getters.currentUser;

let dashboardType = "ItTeamDashboard";

if (currentUser) {
    if (currentUser.type == "admin") {
        dashboardType = "AdminDashboard";
    } else if (currentUser.type == "it-team") {
        dashboardType = "ItTeamDashboard";
    } else if (currentUser.type === "staff") dashboardType = "StaffDashboard";
    else if (currentUser.type === "reception")
        dashboardType = "ReceptionDashboard";
}

export default [
    {
        path: "/",
        component: require("./components/welcome/GuestWelcome.vue").default,
        meta: { requiresAuth: false },
        children: [
            {
                path: "/",
                components: {
                    welcome: require("./components/welcome/Home.vue").default
                }
            },
            {
                path: "/search",
                components: {
                    welcome: require("./components/welcome/Search.vue").default
                }
            },
            {
                path:"/info",
                components:{
                    welcome: require("./components/welcome/info/InfoHome.vue").default
                }
            },
            {
                path:"/online",
                components:{
                    welcome: require("./components/welcome/online/OnlineHome.vue").default
                }
            },
            }
        ]
    },
    {
        path: "/dashboard",
        component: require("./components/Dashboard.vue").default,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: "/",
                components: {
                    dashboard: require(`./components/dashboard/${dashboardType}.vue`)
                        .default
                }
            },
            {
                path: "/users",
                components: {
                    dashboard: require("./components/Users.vue").default
                }
            },
            {
                path: "/profile",
                components: {
                    dashboard: require("./components/Profile.vue").default
                }
            },
            // { path: "/users", component: require("./components/Users.vue").default },
            {
                path: "/bureaus",
                components: {
                    dashboard: require("./components/Bureau.vue").default
                }
            },
            {
                path: "/requests",
                components: {
                    dashboard: require("./components/Request.vue").default
                }
            },
            {
                path: "/buildings",
                components: {
                    dashboard: require("./components/Building.vue").default
                }
            },
            {
                path: "/add-request",
                components: {
                    dashboard: require("./components/request/AddRequest.vue")
                        .default
                }
            },
            {
                path: "/request/edit/:id",
                props: true,
                components: {
                    dashboard: require("./components/request/EditRequest.vue")
                        .default
                }
            },
            {
                path: "/online-requests",
                props: true,
                components: {
                    dashboard: require("./components/OnlineRequest.vue").default
                }
            },
            {
                path: "/add-online-request",
                props: true,
                components: {
                    dashboard: require("./components/request/online/AddOnlineRequest.vue")
                        .default
                }
            },
            {
                path: "/online-request/edit/:id",
                props: true,
                components: {
                    dashboard: require("./components/request/online/EditOnlineRequest.vue")
                        .default
                }
            }
        ]
    },
    {
        path: "/home",
        redirect: "/"
    },
    {
        path: "/:notFound(.*)",
        component: require("./components/404.vue").default
    }
];

/**
 * ! You can use alias to redirect from /home to /, alias '/home'
 * ! also you can use path: '/home', redirect:'/'
 */
