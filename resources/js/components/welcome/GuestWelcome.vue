<template>
  <div>
    <guest-nav-bar></guest-nav-bar>
    <router-view name="welcome"></router-view>
    <vue-login></vue-login>
  </div>
</template>
<script>
import VueLogin from "./../auth/Login.vue";
import { mapGetters } from "vuex";
import GuestNavBar from './GuestNavBar.vue';
export default {
  components: { "vue-login": VueLogin, GuestNavBar },
  computed: {
    ...mapGetters(["currentUser"]),
  },
};
</script>