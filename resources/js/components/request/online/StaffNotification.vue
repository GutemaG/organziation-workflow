<template>
  <div class="container">
    <b-card>
      <!-- <p>{{ requests }}</p> -->
      <div v-if="requests && requests.length > 1">
        <b-table :items="requests" :fields="fields" stacked>
          <template #cell(action)="row">
            <b-button variant="success" @click="acceptRequest(row.item)">
              Accept</b-button
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
            </b-modal>
          </template>
        </b-table>
      </div>
      <div v-else-if="(requests.length = 1)">
        <!-- <span>{{ requests }}</span> -->
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                <div class="col-12">
                  <h4 class="text-primary">Request Detail</h4>
                </div>
                <div>
                  <span class="title text-muted"> Name </span>
                  <h5>{{ requests.online_request.name }}</h5>
                  <span class="title text-muted"> Request Date</span>
                  <p>{{ requests.created_at }}</p>
                  <span class="title text-muted"> Catagory</span>
                  <p>{{ requests.online_request.type }}</p>
                  <span class="title text-muted"> Description</span>
                  <p>{{ requests.online_request.description }}</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
              <h3 class="text-primary">
                <i class="fas fa-paint-brush"></i>Pre Requests
              </h3>

              <br />

              <h5 class="mt-5 text-muted">Project files</h5>
              <ul class="list-unstyled">
                <li>
                  <a href="" class="btn-link text-secondary"
                    ><i class="far fa-fw fa-file-word"></i> Something</a
                  >
                  {{requests.client_data}}
                </li>
                <li>
                  <a href="" class="btn-link text-secondary"
                    ><i class="far fa-fw fa-file-pdf"></i> Grade 12
                    transcript</a
                  >
                </li>
              </ul>
              <div class="text-center mt-5 mb-3">
                <a href="#" class="btn btn-sm btn-primary" role="button" @click="acceptRequest(requests)">Accept</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <h1>NO Request found</h1>
      </div>
    </b-card>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
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
          key: "online_request.name",
          label: "Request Name",
        },
        {
          key: "online_request.description",
          label: "Request Description",
        },
        {
          key: "online_request.type",
          label: "Category",
        },
        {
          key: "action",
          label: "Action",
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
    ...mapActions(['acceptPendingRequest']),
    // acceptPendingRequest({ commit }, data) {
    acceptRequest(request) {
      this.acceptPendingRequest(request)
      this.$router.go(-1)
      // console.log("accepting: ", request);
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
<style scoped>
.title{
  font-weight: bold;
  font-style: italic;
}
</style>