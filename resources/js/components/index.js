/**
 * //  //,?,//, todo, *
 *  ?These component are globals. We can use them in any component
 * ? I remove other component they must not registered globally because
 *      ? use them in one or two component so they must be registered locally
 * */
import Vue from "vue";

import BaseInput from "./Base/BaseInput.vue";
import BaseCard from "./Base/BaseCard.vue";
import BasePagination from "./Base/BasePagination.vue";
Vue.component("base-input", BaseInput);
Vue.component("base-card", BaseCard);
Vue.component("base-pagination", BasePagination);
// import SideBar from "./include/SideBar.vue";
// Vue.component("side-bar", SideBar);

/**
 * * For Reference only
 */
// import EditModal from "./user/EditModal.vue";
// import AddUserModal from "./user/AddUserModal.vue";
// import AddBureauModal from "./bureau/AddBureauModal.vue";
// import EditBureauModal from "./bureau/EditBureauModal.vue";
// import AddBuildingModal from "./building/AddBuildingModal.vue";
// import EditBuildingModal from "./building/EditBuildingModal.vue";
// import AddProcedure from "./request/AddProcedure.vue";
// import AddPreRequest from "./request/AddPreRequest.vue";
// import OnlineRequestProcedureTable from "./request/online/OnlineRequestProcedureTable.vue";
// import VueLogin from "./auth/Login.vue";

// import Home from "./Home.vue";
// import Welcome from "./welcome/Welcome.vue";
// import GuestWelcome from "./welcome/GuestWelcome.vue";
// import NavBar from "./include/NavBar.vue";
// import SideBar from "./include/SideBar.vue";

// Vue.component("edit-user-modal", EditModal);
// Vue.component("add-user-modal", AddUserModal);
// Vue.component("add-bureau-modal", AddBureauModal);
// Vue.component("edit-bureau-modal", EditBureauModal);
// Vue.component("add-building-modal", AddBuildingModal);
// Vue.component("edit-building-modal", EditBuildingModal);
// Vue.component("add-pre-request", AddPreRequest);
// Vue.component("add-procedure", AddProcedure);
// Vue.component("vue-login", VueLogin);
// Vue.component("home", Home);

// Vue.component("welcome", Welcome);
// Vue.component("guest-welcome", GuestWelcome);
// Vue.component("nav-bar", NavBar);
// Vue.component("side-bar", SideBar);
// Vue.component("online-request-procedure-table", OnlineRequestProcedureTable);

/*
Vue.component(
    "edit-user-modal",
    require("./components/user/EditModal.vue").default
);
Vue.component(
    "add-user-modal",
    require("./components/user/AddUserModal.vue").default
);
Vue.component("home", require("./components/Home.vue").default);
Vue.component(
    "add-bureau-modal",
    require("./components/bureau/AddBureauModal.vue").default
);
Vue.component(
    "edit-bureau-modal",
    require("./components/bureau/EditBureauModal.vue").default
);
Vue.component(
    "add-building-modal",
    require("./components/building/AddBuildingModal.vue").default
);
Vue.component(
    "edit-building-modal",
    require("./components/building/EditBuildingModal.vue").default
);
Vue.component("base-input", require("./components/Base/BaseInput.vue").default);
Vue.component("base-card", require("./components/Base/BaseCard.vue").default);
Vue.component(
    "base-pagination",
    require("./components/Base/BasePagination.vue").default
);
Vue.component(
    "add-procedure",
    require("./components/request/AddProcedure.vue").default
);
Vue.component(
    "add-pre-request",
    require("./components/request/AddPreRequest.vue").default
);
Vue.component("vue-login", require("./components/auth/Login.vue").default);
Vue.component(
    "vue-welcome",
    require("./components/welcome/Welcome.vue").default
);
Vue.component(
    "guest-welcome",
    require("./components/welcome/GuestWelcome.vue").default
);
Vue.component("nav-bar", require("./components/include/NavBar.vue").default);
Vue.component("side-bar", require("./components/include/SideBar.vue").default);
Vue.component(
    "online-request-procedure-table",
    require("./components/request/online/OnlineRequestProcedureTable.vue").default
);*/
