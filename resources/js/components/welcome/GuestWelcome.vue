<template>
  <div>
    <guest-nav-bar></guest-nav-bar>
    <div style="margin-top: 4rem">
      <router-view name="welcome"></router-view>
    </div>
    <!-- <vue-login></vue-login> -->
  </div>
</template>
<script>
// import VueLogin from "./../auth/Login.vue";
import { mapGetters } from "vuex";
import GuestNavBar from "../include/GuestNavBar.vue";
export default {
  components: { GuestNavBar },
  computed: {
    ...mapGetters(["currentUser"]),
  },
};
</script>