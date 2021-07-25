<template>
  <div class="container-fluid">
    <div v-if="currentUser">
      <side-bar></side-bar>
      <nav-bar></nav-bar>
    </div>
    <div class="wrapper" style="margin-top: 5rem">
      <router-view name="dashboard"></router-view>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name:'Dashboard',
  data() {
    return {};
  },
  methods:{
    // ...mapActions(['fetchUsers', 'fetchAffairs', 'fetchBureaus', 'fetchBuildings'])
  },
  computed: {
    ...mapGetters(["currentUser", 'users','affairs','bureaus', 'buildings', 'findUser']),
  },
  created(){
    // this.fetchUsers()
    // this.fetchAffairs()
    // this.fetchBureaus();
    // this.fetchBuildings()
    // console.log('created')

  }
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
