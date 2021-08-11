<template>
  <div>
    <b-card>
      <p>{{ $route.params.request.OnlineRequestStep }}</p>
      <h3>Request Name: {{ request.message }}</h3>
      <b-button variant="success">Accept</b-button>
      <b-button variant="danger">Reject</b-button>
    </b-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      request: this.$route.params.request,
    };
  },
  mounted() {
    console.log(this.$route);
  },
};
</script>