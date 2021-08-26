<template>
  <div class="container-fluid mt-3">
    <div>
      <div>
        <h3>Requests</h3>
        <p>Below is a table with the list of Requests.</p>
        <b-table :items="affairs.slice(0,6)" :fields="['name',{label:'Users',key:'user.user_name'},'created_at']" hover bordered responsive thead-class="text-white bg-dark"></b-table>
        <router-link to="/requests">More..</router-link>
        <h3>Online-Requests</h3>
        <p>Below is a table with the list of Online-Requests.</p>
        <b-table :items="online_requests.slice(0,6)" :fields="['name','type','created_at']" hover bordered responsive thead-class="text-white bg-dark"></b-table>
        <router-link to="/online-requests">More..</router-link>
        <h3>Bureau</h3>
        <p>Below is a table with the list of Bureau.</p>
        <b-table :items="bureaus.slice(0,6)" :fields="['name','office_number','building_number','created_at']" hover bordered responsive thead-class="text-white bg-dark"></b-table>
        <router-link to="/bureaus">More..</router-link>
        <h3>Buildings</h3>
        <p>Below is a table with the list of Buildings.</p>
        <b-table :items="buildings.slice(0,6)" :fields="['name',{label:'Building number',key:'number'},'number_of_offices','created_at']" hover bordered responsive thead-class="text-white bg-dark"></b-table>
        <router-link to="/buildings">More..</router-link>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
    export default {
    data() {
      return {
        // Note 'isActive' is left out and will not appear in the rendered table
      }
    },
    computed: {
      ...mapGetters(['affairs','online_requests','bureaus','buildings']),
      fetchlimit(){
        return this.users.slice(0, 6);
      },

    },
    methods: {
      ...mapActions([ 'fetchAffairs', 'fetchOnlineRequests', 'fetchBureaus', 'fetchBuildings']),
      usersList() {
        axios.get("/api/users")
        .then((resp) => {
          let user = resp.data.users;
          this.users = user;
        })
      }
    },
    created(){
      this.fetchAffairs();
      this.fetchOnlineRequests();
      this.fetchBureaus();
      this.fetchBuildings();
    }
  }
</script>

<style scoped>
.bg-dark {
  background-color: rgb(0, 0, 0) ;
  color: rgb(255, 255, 255) ;
}
</style>
