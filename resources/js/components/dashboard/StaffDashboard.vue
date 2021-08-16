<template>
  <div class="mt-3">
    <!-- <b-tabs
      active-nav-item-class="font-weight-bold bg-info text-uppercase"
      v-model="tabIndex"
      card
    > -->
    <b-card class="shadow">
      <b-table :items="steps" :fields="fields" borderless stacked="md">
        <template #cell(id)="row">
          {{ row.index + 1 }}
        </template>
        <template #cell(actions)="row">
          <!-- <b-button
            v-if="!row.item.started_at"
            variant="success"
            @click="acceptRequest(item)"
            >Accept</b-button
          > -->
          <b-button
            v-if="!row.item.ended_at"
            variant="primary"
            @click="complete_request(row.item)"
            >Complete</b-button
          >
          <b-button
            v-if="!row.item.ended_at && !row.item.is_rejected==1"
            variant="danger"
            v-b-modal="'reject-reason-modal-' + row.item.id"
            >Reject</b-button
          >
          <span
            v-if="row.item.is_rejected == 1"
            variant="danger"
            disabled
            style="display: block; color:red"
            >Rejected <i class="fas fa-times red"></i
          ></span>
          <!-- this.$root.$emit("bv::show::modal", "add-user-modal"); -->
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
            <form ref="form" @submit.stop.prevent="reject_request(row.item)">
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
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      tabIndex: 0,
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
          key: "online_request.type",
          label: "Type",
          sortable: true,
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
    ...mapGetters(["staff_all_accepted_request"]),
    steps() {
      return this.staff_all_accepted_request;
    },
    isRejectReasonEmpty() {
      return this.reject_reason.length == 0;
    },
  },
  methods: {
    ...mapActions([
      "fetchAllAcceptedRequest",
      "completeRequest",
      "rejectRequest",
    ]),
    DateFormatter(value) {
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
    reject_request(request) {
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
          // console.log(request.id, request);
          // let data = {...request, this.reject_reason}
          let reason = this.reject_reason;
          let data = {...request, reason}
          this.rejectRequest(data);
          // Swal.fire("Deleted!", "User is removed", "success");
          this.$bvModal.hide("reject-reason-modal-" + request.id);
        }
      });
    },
    complete_request(request) {
      this.completeRequest(request);
      // console.log("complete request: ", request);
    },
    acceptRequest(item) {
      console.log("accepting: ", item);
    },
  },
  mounted() {
    this.fetchAllAcceptedRequest();
  },
};
</script>