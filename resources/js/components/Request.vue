<template>
  <div class="container">
    <router-link to="/add-request" class="nav-link">
      <b-button size="sm" class="mr-1" variant="primary">
        + Add
      </b-button>
    </router-link>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
export default {
  data() {
    return {
      username: "",
    };
  },
  methods:{
    ...mapActions(['fetchAffairs']),
  },
  created(){
    this.fetchAffairs();
  }
};
</script>
