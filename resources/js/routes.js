export default [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/bureaus', component: require('./components/Bureau.vue').default },
    { path: '/requests', component: require('./components/Request.vue').default },
    { path: '/buildings', component: require('./components/Building.vue').default },
    { path: '/add-request', component: require('./components/request/AddRequest.vue').default },
    { path: '/request/edit/:id',props:true, component: require('./components/request/EditRequest.vue').default },
];
