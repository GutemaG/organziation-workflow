export default [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/bureaus', component: require('./components/Bureau.vue').default },
    { path: '/requests', component: require('./components/Request.vue').default },
    { path: '/buildings', component: require('./components/Building.vue').default },
];
