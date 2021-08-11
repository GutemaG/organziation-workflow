<template>
  <div class="mt-3">
    <!-- <b-tabs
      active-nav-item-class="font-weight-bold bg-info text-uppercase"
      v-model="tabIndex"
      card
    > -->
    <b-card class="shadow">
      <b-table :items="steps" :fields="fields" borderless>
        <template #cell(id)="row">
          {{ row.index + 1 }}
        </template>
        <template #cell(actions)="row">
          <b-button
            v-if="!row.item.started_at"
            variant="success"
            @click="acceptRequest(item)"
            >Accept</b-button
          >
          <b-button
            v-if="!row.item.ended_at"
            variant="danger"
            v-b-modal="'reject-reason-modal-' + row.item.id"
            >Reject</b-button
          >
          <!-- this.$root.$emit("bv::show::modal", "add-user-modal"); -->
          <b-button
            v-if="!row.item.ended_at"
            variant="primary"
            @click="completeRequest(row.item)"
            >Complet</b-button
          >
          <span
            v-if="row.item.is_completed == 1"
            variant="success"
            disabled
            style="display: block"
            >Completed <i class="fas fa-check green"></i
          ></span>
          <b-modal
            :id="'reject-reason-modal-' + row.item.id"
            title="Reject Request"
            ok-title="Cancel"
            ok-variant="danger"
            ok-only
            @ok="handleOk"
            @hidden="handleOk"
          >
            <form ref="form" @submit.stop.prevent="rejectRequest(row.item.id)">
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
    </b-card>

    <!-- <b-tab title="Pending" lazy><h1>List of pending</h1></b-tab>
      <b-tab title="Rejected" lazy>
        <h1>List of Rejected</h1>
      </b-tab>
    </b-tabs> -->
  </div>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      tabIndex: 0,
      steps: [],
      fields: [
        {
          key: "id",
          label: "#",
        },
        {
          key: "online_request.name",
          sortable: true,
          label: "Request Name",
        },
        {
          key: "created_at",
          label: "Created At",
          sortable: true,
          formatter: (value) => {
            if (value) {
              // let ago = moment(value).fromNow();
              let date = moment(value).format("MMM Do, YY");
              return `${date}`;
            } else {
              return "-----";
            }
          },
        },
        {
          key: "started_at",
          label: "Started At",
          sortable: true,
          formatter: (value) => {
            if (value) {
              // let ago = moment(value).fromNow();
              let date = moment(value).format("MMM Do, YY");
              return `${date}`;
            } else {
              return "-----";
            }
          },
        },
        {
          key: "ended_at",
          label: "Ended At",
          sortable: true,
          formatter: (value) => {
            if (value) {
              // let ago = moment(value).fromNow();
              let date = moment(value).format("MMM Do, YY");
              return `${date}`;
            } else {
              return "-----";
            }
          },
        },
        {
          key: "is_completed",
          label: "Completed",
          sortable: true,
          formatter: (value) => {
            if (value == 1) {
              return "Yes";
            }
            return "No";
          },
        },
        {
          key: "is_rejected",
          label: "Rejected",
          sortable: true,
          formatter: (value) => {
            if (value == 1) {
              return "Yes";
            }
            return "No";
          },
        },
        {
          key: "actions",
          label: "Actions",
        },
      ],
      reject_reason: "",
    };
  },
  computed: {
    isRejectReasonEmpty() {
      return this.reject_reason.length == 0;
    },
  },
  methods: {
    DateFormater(value) {
      if (value) {
        let ago = moment(value).fromNow();
        let date = moment(value).format("MMM Do, YY");
        return `${date}, ${ago}`;
      } else {
        return "-----";
      }
    },
    handleOk() {
      this.reject_reason = "";
    },
    rejectRequest(request_id) {
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
          console.log(request_id, this.reject_reason);
          // Swal.fire("Deleted!", "User is removed", "success");
          this.$bvModal.hide("reject-reason-modal-" + request_id);
        }
      });
    },
    completeRequest(item) {
      console.log("complete request: ", item);
    },
    acceptRequest(item) {
      console.log("accepting: ", item);
    },
  },
  mounted() {
    axios
      .get("/api/online-request-steps")
      .then((resp) => {
        if (resp.data.status == 200) {
          this.steps = resp.data.online_request_steps;
          console.log(this.steps);
        }
      })
      .catch((err) => console.log(err));
    // Route::get('/online-request-steps', [\App\Http\Controllers\OnlineRequestStepController::class, 'index']);
  },
};
</script>