<template>
  <div class="container-fluid">
    <div v-if="currentUser">
      <side-bar></side-bar>
      <nav-bar></nav-bar>
    </div>
    <div class="wrapper" style="margin-top: 5rem">
      <fade-transition>
        <router-view name="dashboard"></router-view>
      </fade-transition>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import AddRequest from "./request/AddRequest.vue";
import { FadeTransition, ZoomCenterTransition } from "vue2-transitions";
export default {
  components: { AddRequest, FadeTransition, ZoomCenterTransition },
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