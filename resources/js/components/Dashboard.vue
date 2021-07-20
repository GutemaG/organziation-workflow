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
import { mapGetters } from "vuex";
import AddRequest from "./request/AddRequest.vue";
export default {
  components: { AddRequest },
  data() {
    return {};
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

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["currentUser"]),
  },
};
</script>