<template>
  <div class="container">
    <b-tabs
      active-nav-item-class="font-weight-bold bg-info text-uppercase"
      v-model="tabIndex"
      card
    >
      <b-tab title="All Request" lazy>
        <h1>List Of All Request comes to this User</h1>
      </b-tab>
      <b-tab title="Accepted" lazy>
        <h1>List Of accepted by this user</h1>
      </b-tab>
      <b-tab title="Pending" lazy><h1>List of pending</h1></b-tab>
      <b-tab title="Rejected" lazy>
        <h1>List of Rejected</h1>
      </b-tab>
    </b-tabs>
  </div>
</template>
<script>
export default {
  data() {
    return {
      tabIndex: 0,
    };
  },
  mounted() {
    axios
      .get("/api/online-request-steps")
      .then((resp) => console.log(resp.data))
      .catch((err) => console.log(err));
    // Route::get('/online-request-steps', [\App\Http\Controllers\OnlineRequestStepController::class, 'index']);
  },
};
</script>