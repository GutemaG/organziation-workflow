<template class="sidebar-mini">
  <div class="wrapper">
    <div v-if="currentUser">
      <NavBar />
      <SideBar />
      <!-- <div v-if="currentUser.type == 'admin'">
      </div> -->

      <div class="content-wrapper" style="min-height: 253px">
        <!-- Content Header (Page header) -->
        <!-- <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Starter Page update</h1>
              </div>
            </div>
          </div>
        </div> -->

        <div class="content">
          <div class="container-fluid">
            <router-view name="dashboard" :key="$route.fullPath"></router-view>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "./include/adminlte/NavBar.vue";
import SideBar from "./include/adminlte/SideBar.vue";
import { mapActions, mapGetters } from "vuex";
export default {
  components: { NavBar, SideBar },
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
    // Echo.private('online-request-applied')
    //     .listen('OnlineRequestEvent', (e) => {
    //         console.log("from pusher: ", e);
    //     });
    // this.fetchUsers()
    // this.fetchAffairs()
    // this.fetchBureaus();
    // this.fetchBuildings()
    // console.log('created')
  },
};
</script>

<style>

</style>