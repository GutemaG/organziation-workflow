<template>
  <div class="mt-3">
    <!-- <b-tabs
      active-nav-item-class="font-weight-bold bg-info text-uppercase"
      v-model="tabIndex"
      card
    > -->
    <b-card class="">
      <b-card-header>
        <h1>List of Request procedures</h1>
      </b-card-header>
      <b-table :items="steps" :fields="fields" borderless stacked="xl">
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
            size="sm"
            @click="complete_request(row.item)"
            >Complete</b-button
          >
          <b-button
            v-if="!row.item.ended_at && !row.item.is_rejected==1"
            variant="danger"
            size="sm"
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
                size=""
                >Reject</b-button
              >
            </form>
          </b-modal>
          
          <b-button
            size="sm"
            @click="row.toggleDetails"
            >show detail</b-button>
        </template>
        <template #row-details="row">
          <b-card>
                <div class="">
                    
              <h5 class="mt-5 text-muted">Customer Information</h5>
              <ul class="list-unstyled">
                <li>
                  <span class="m-1" style="font-siz:1rem;">Full Name:</span>
                    <p style="display:inline;font-weight:bold" >{{row.item.client_data.full_name}}</p>
                  <div v-for="(data,index) in row.item.client_data" :key="index">
                    <span class="m-2" style="font-siz:1rem;">{{data.name}}</span>
                     <p style="display:inline; font-weight:bold">{{data.value}}</p>
                  </div>
                  <!-- {{requests.}} -->
                </li>
              </ul>
                </div>
          </b-card>
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
      submitForm(){
        axios.post('/api/sent-to-reception',{...this.henok}).then(resp=>{
            console.log(resp)
          })
      },
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
