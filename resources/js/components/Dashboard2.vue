<template>
  <div class="container-fluid">
    <div v-if="currentUser">
      <side-bar></side-bar>
      <nav-bar></nav-bar>
    </div>
    <div class="wrapper" style="margin-top: 5rem">
      <router-view name="dashboard" :key="$route.fullPath"></router-view>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import NavBar from "./include/NavBar.vue";
import SideBar from "./include/SideBar.vue";
export default {
  components: { "nav-bar": NavBar, "side-bar": SideBar },
  name: "Dashboard",
  data() {
    return {};
  },
  methods: {
    // ...mapActions(['fetchUsers', 'fetchAffairs', 'fetchBureaus', 'fetchBuildings'])
  },
  computed: {
    ...mapGetters([
      "currentUser",
      "users",
      "affairs",
      "bureaus",
      "buildings",
      "findUser",
    ]),
  },
  created() {
    // this.fetchUsers()
    // this.fetchAffairs()
    // this.fetchBureaus();
    // this.fetchBuildings()
    // console.log('created')
  },
};
</script>
<style scoped>
.leftside,
.rightside {
  width: 100%;
}
.bg-dark {
  background-color: rgb(0, 0, 0);
  color: rgb(255, 255, 255);
}
</style>
