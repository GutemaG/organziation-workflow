<template>
  <div class="container">
    <b-card>
      <!-- <p>{{ requests }}</p> -->
      <div v-if="requests">
        <b-table :items="requests" :fields="fields" stacked>
          <template #cell(actions)="row">
            <b-button variant="success" @click="acceptRequest(row.item)">
              Accept</b-button
            >
            <b-button
              variant="danger"
              v-b-modal="'reject-reason-modal-' + row.item.id"
              >Reject</b-button
            >
            <b-modal
              :id="'reject-reason-modal-' + row.item.id"
              title="Reject Request"
              ok-title="Cancel"
              ok-variant="danger"
              ok-only
              @ok="handleOk"
              @hidden="handleOk"
            >
              <form ref="form" @submit.stop.prevent="rejectRequest(row.item)">
                <b-form-group
                  label="Reason"
                  invalid-feedback="Required"
                  label-for="reject-reason-input"
                >
                  <b-form-textarea
                    id="reject-reason-input"
                    placeholder="Enter Your Reason"
                    :state="!isRejectReasonEmpty"
                    required
                    v-model="reject_reason"
                  >
                  </b-form-textarea>
                </b-form-group>
                <b-button
                  :disabled="isRejectReasonEmpty"
                  class="form-control"
                  type="submit"
                  >Reject</b-button
                >
              </form>
            </b-modal>
          </template>
        </b-table>
      </div>
      <div v-else>
        <h1>NO Request found</h1>
      </div>
    </b-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      requests: this.$route.params.request,
      reject_reason: "",
      fields: [
        {
          key: "created_at",
          label: "Created At",
        },
        {
          key: "request.name",
          label: "Request Name",
        },
        {
          key: "request.description",
          label: "Request Description",
        },
        {
          key: "actions",
          label: "Actions",
        },
      ],
    };
  },
  computed: {
    isRejectReasonEmpty() {
      return this.reject_reason.length == 0;
    },
  },
  methods: {
    acceptRequest(request) {
      console.log("accepting: ", request);
    },
    rejectRequest(request) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          console.log("rejecting: ", request);
          // Swal.fire("Deleted!", "User is removed", "success");
          this.$bvModal.hide("reject-reason-modal-" + request.id);
        }
      });
    },
    handleOk() {
      this.reject_reason = "";
    },
  },
  mounted() {
    console.log(this.$route);
  },
};
</script>