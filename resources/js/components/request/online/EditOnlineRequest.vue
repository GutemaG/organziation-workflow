<template>
  <base-card :shadow="true">
    <b-row align-v="center" slot="header">
      <b-col cols="8"> Add Online Reqeust </b-col>
      <b-col cols="4"> Edit </b-col>
    </b-row>
    <b-form @submit.stop.prevent="handleSubmit">
      <div class="pl-lg-4">
        <b-form-group
          id="online-request-name"
          label="Name"
          label-for="online-request-name-input"
        >
          <b-form-input
            id="online-request-name-input"
            v-model.trim="selectedRequest.name"
          >
          </b-form-input>
        </b-form-group>
        <b-form-group
          id="online-request-description"
          label="Description"
          label-for="online-request-description-input"
        >
          <b-form-textarea
            id="online-request-description-input"
            v-model="selectedRequest.description"
          ></b-form-textarea>
        </b-form-group>
        <hr class="my-4" />
      </div>
      <div>
        <base-card>
          <b-col cols="8" slot="header"> Add Procedures</b-col>
          <div
            v-for="(
              procedure, procedure_index
            ) in selectedRequest.online_request_procedures"
            :key="procedure_index"
          >
            <div>
              <!-- !card for prorcedure bureau, user, step, desc-->
              <base-card>
                <b-row align-v="center" slot="header">
                  <b-col cols="8"> Procedure - {{ procedure_index }}</b-col>
                  <b-col
                    cols="4"
                    v-if="selectedRequest.online_request_procedures.length > 1"
                  >
                    <b-button @click="removeProcedure(procedure_index)">
                      <i class="fa fa-trash"></i
                    ></b-button>
                  </b-col>
                </b-row>
                <b-col cols="12" >
                  <b-form-group
                    id="online-request-bureau"
                    label-for="online-request-bureau-input"
                    label="Responsible Bureau"
                  >
                    <b-form-select
                      id="online-request-bureau-input"
                      v-model="procedure.responsible_bureau_id"
                      :options="bureau_ids"
                    >
                      <template #first>
                        <b-form-select-option selected disabled value="">
                          Select Responsible Bureau
                        </b-form-select-option>
                      </template>
                    </b-form-select>
                  </b-form-group>
                  <b-form-group
                    id="online-request-user"
                    label-for="online-request-user-input"
                    label="Responsible User"
                    description="use Ctrl key to select many user"
                  >
                    <b-form-select
                      id="online-request-user-input"
                      v-model="procedure.responsible_user_id"
                      :options="staff_ids"
                      multiple
                      style="height:10rem;"
                    >
                      <template #first>
                        <b-form-select-option selected disabled value="">
                          Select Responsible User
                        </b-form-select-option>
                      </template>
                    </b-form-select>
                  </b-form-group>
                  <b-form-group
                    id="online-request-procedures-input"
                    label="Step"
                    label-for="online-request-name-input"
                  >
                    <b-form-input
                      placeholder="Enter Procedure step"
                      id="online-request-name-input"
                      v-model="procedure.step_number"
                      type="number"
                    >
                    </b-form-input>
                  </b-form-group>
                  <b-form-group
                    label="Procedures Description"
                    id="online-request-procedures-description"
                  >
                    <b-form-textarea
                      v-model="procedure.description"
                      placeholder="Enter Description for Procedure"
                      id="online-request-procedures-description"
                    >
                    </b-form-textarea>
                  </b-form-group>
                </b-col>
              </base-card>
              <!-- /**end card for prorcedure bureau, user, step, desc */-->
            </div>
          </div>
          <b-button class="form-control" variant="dark">+ Procedure</b-button>
        </base-card>
        <b-button
          v-if="prerequisiteLength == 0"
          @click="prerequisite = true"
          variant="primary"
          >add pre-request</b-button
        >
        <base-card v-if="prerequisiteLength != 0">
          <b-row align-v="center" slot="header">
            <b-col cols="8">Request Labels</b-col>
          </b-row>
          <div>
            <b-list-group
              v-for="(label, index) in selectedRequest.prerequisite_labels"
              :key="index"
            >
              <b-row>
                <b-col class="cols-8">
                  <b-list-group-item class="m-1">
                    {{ label.label }}
                  </b-list-group-item>
                </b-col>
                <b-col class="cols-4" md="4">
                  <b-row>
                    <router-link :to="'#'" class="">
                      <b-button size="sm" class="m-1" variant="primary">
                        Edit
                      </b-button>
                    </router-link>
                    <b-button
                      size="sm"
                      class="m-1"
                      variant="danger"
                      @click="deleteOnlineRequestLabel(label.id)"
                    >
                      Delete
                    </b-button>
                  </b-row>
                </b-col>
              </b-row>
            </b-list-group>
          </div>
        </base-card>
      </div>
        <b-button type="submit" class="form-control" variant="primary">
          Submit</b-button
        >
    </b-form>
  </base-card>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["id"],
  data() {
    return {
      request_id: this.$route.params.id,
      selectedRequest: {},
      prerequisite: false,
    };
  },

  computed: {
    ...mapGetters(["online_requests", "staff_ids", "bureau_ids"]),
    prerequisiteLength() {
      return this.selectedRequest.prerequisite_labels.length;
    },
  },
  methods: {
    ...mapActions([
      "addOnlineRequest",
      "fetchOnlinRequests",
      "updateOnlineRequest",
    ]),
    handleSubmit() {
      console.log(this.selectedRequest);
    },
    removeProcedure(index) {
      console.log("removing procedure: ");
    },
    deleteOnlineRequestLabel(id) {
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
          console.log("deleting label ", id);
        }
      });
    },
  },

  created() {
    if (this.online_requests.length === 0) {
      this.$router.push("/online-requests");
    } else {
      if (this.selectedRequest) {
        let request = this.online_requests.filter(
          (req) => req.id == this.request_id
        )[0];
        // console.log(request.online_request_procedures)
        // return
        let procedures = request.online_request_procedures;
        let responsible_user_id = [];
        for (let j = 0; j < procedures.length; j++) {
          let users = procedures[j].users;
          for (let i = 0; i < users.length; i++) {
            responsible_user_id.push(users[i].id);
          }
          request.online_request_procedures[j].responsible_user_id =
            responsible_user_id;
        }
        this.selectedRequest = request;
      }
    }
  },
};
</script>