<template>
  <div class="container">
    <b-alert v-if="error" show variant="danger">{{ error }}</b-alert>
    <p>{{ error }}</p>
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
            :invalid-feedback="
              !$v.selectedRequest.name.isUnique
                ? 'Already exist'
                : 'Name is required'
            "
          >
            <b-form-input
              id="online-request-name-input"
              v-model.lazy="$v.selectedRequest.name.$model"
              trim
              required
              :state="validateState('name')"
            >
            </b-form-input>
          </b-form-group>
          <b-form-group
            id="online-request-description"
            label="Description"
            label-for="online-request-description-input"
            invalid-feedback="Description is required"
          >
            <b-form-textarea
              id="online-request-description-input"
              v-model="$v.selectedRequest.description.$model"
              :state="validateState('description')"
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
                      v-if="
                        selectedRequest.online_request_procedures.length > 1
                      "
                    >
                      <b-button
                        @click="removeProcedure(procedure.id, procedure_index)"
                        variant="danger"
                      >
                        <i class="fa fa-trash"></i
                      ></b-button>
                    </b-col>
                  </b-row>
                  <b-col cols="12">
                    <b-form-group
                      id="online-request-bureau"
                      label-for="online-request-bureau-input"
                      label="Responsible Bureau"
                      invalid-feedback="required"
                    >
                      <b-form-select
                        :id="'online-request-bureau-input-' + procedure_index"
                        v-model="procedure.responsible_bureau_id"
                        :options="bureau_ids"
                        required
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
                      invalid-feedback="Require at least one Staff"
                    >
                      <b-form-select
                        :id="'online-request-user-input-' + procedure_index"
                        v-model="procedure.responsible_user_id"
                        :options="staff_ids"
                        multiple
                        style="height: 10rem"
                        required
                      >
                        <template #first>
                          <b-form-select-option selected disabled value="">
                            Select Responsible User
                          </b-form-select-option>
                        </template>
                      </b-form-select>
                    </b-form-group>
                    <b-form-group
                      id="online-request-procedures-step"
                      label="Step"
                      label-for="online-request-procedure-step-input"
                    >
                      <b-form-input
                        placeholder="Enter Procedure step"
                        :id="
                          'online-request-procedure-step-input-' +
                          procedure_index
                        "
                        v-model="procedure.step_number"
                        type="number"
                      >
                      </b-form-input>
                    </b-form-group>
                    <b-form-group
                      label="Procedures Description"
                      :id="
                        'online-request-procedures-description-' +
                        procedure_index
                      "
                    >
                      <b-form-textarea
                        v-model="procedure.description"
                        placeholder="Enter Description for Procedure"
                        :id="
                          'online-request-procedures-description-input-' +
                          procedure_index
                        "
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
          <!-- @click="prerequisite = true" -->
          <!-- v-if="prerequisiteLength == 0" -->
          <b-button
            class="m-1"
            v-b-modal.add-pre-request-label
            variant="primary"
            >add pre-request</b-button
          >
          <base-card>
            <b-row align-v="center" slot="header">
              <b-col cols="8">
                <span v-if="prerequisiteLength != 0">Request Labels</span>
                <span v-else>No Pre request</span>
              </b-col>
            </b-row>
            <div>
              <b-modal
                id="add-pre-request-label"
                title="Add Label"
                @ok="addLabel(selectedRequest.id)"
              >
                <b-form-group label="Label">
                  <b-form-input
                    v-model="newLabel"
                    placeholder="Enter Label Name"
                  ></b-form-input>
                </b-form-group>
              </b-modal>
              <b-list-group
                v-for="(label, index) in selectedRequest.prerequisite_labels"
                :key="index"
              >
                <b-row>
                  <b-col class="cols-8 m-1">
                    <b-form-input v-model="label.label" disabled>
                    </b-form-input>
                  </b-col>
                  <b-col class="cols-4" md="4">
                    <b-row>
                      <b-button
                        size="sm"
                        class="m-1"
                        variant="primary"
                        @click="emitEditPrerequesiteModel(label.id)"
                      >
                        Edit
                      </b-button>
                      <b-button
                        size="sm"
                        class="m-1"
                        variant="danger"
                        @click="deleteOnlineRequestLabel(label.id)"
                      >
                        Delete
                      </b-button>
                      <b-modal
                        :id="'edit-online-request-label-' + label.id"
                        title="editing label"
                        @ok="updateLabel(label.id)"
                      >
                        <b-form-input v-model="newUpdateLabel.label">
                        </b-form-input>
                      </b-modal>
                    </b-row>
                  </b-col>
                </b-row>
              </b-list-group>
            </div>
          </base-card>
        </div>
        <b-button
          type="submit"
          class="form-control"
          variant="primary"
          :disabled="$v.$invalid"
        >
          Submit</b-button
        >
      </b-form>
    </base-card>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { required } from "vuelidate/lib/validators";
import axios from "axios";
export default {
  props: ["id"],
  data() {
    return {
      request_id: this.$route.params.id,
      selectedRequest: {},
      prerequisite: false,
      error: null,
      newLabel: null,
      newUpdateLabel: {},
    };
  },

  computed: {
    ...mapGetters(["online_requests", "staff_ids", "bureau_ids"]),
    prerequisiteLength() {
      if (this.selectedRequest.prerequisite_labels)
        return this.selectedRequest.prerequisite_labels.length;
      return 0;
    },
  },
  methods: {
    ...mapActions([
      "addOnlineRequest",
      "fetchOnlinRequests",
      "updateOnlineRequest",
    ]),
    validateState(value) {
      const { $dirty, $error } = this.$v.selectedRequest[value];
      return $dirty ? !$error : null;
    },
    async handleSubmit() {
      try {
        if (this.selectedRequest.prerequisite_labels.length == 0) {
          delete this.selectedRequest["prerequisite_labels"];
        }
        await this.updateOnlineRequest(this.selectedRequest);
        this.$router.push("/online-requests");
      } catch (err) {
        console.error(err);
        this.error = "Fill the form Correctly";
      }
      // // console.log(this.selectedRequest);
    },
    removeProcedure(id, index) {
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
          axios
            .delete(`/api/online-procedures/${id}`)
            .then((resp) => {
              if (resp.status == 200) {
                this.selectedRequest.online_request_procedures =
                  this.selectedRequest.online_request_procedures.filter(
                    (procedure) => procedure.id != id
                  );
              }
            })
            .catch((err) => console.log(err));
        }
      });

      console.log("removing procedure: ", id, index);
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
          axios
            .delete(`/api/online-prerequisites/${id}`)
            .then((resp) => {
              if (resp.status == 200) {
                this.selectedRequest.prerequisite_labels =
                  this.selectedRequest.prerequisite_labels.filter(
                    (label) => label.id != id
                  );
              } else {
                Swal.fire(
                  "Failed",
                  "Something is wrong, please try again",
                  "warning"
                );
              }
            })
            .catch((err) => {
              Swal.fire(
                "Failed",
                "Something is wrong, please try again",
                "warning"
              );
            });
        }
      });
    },
    emitEditPrerequesiteModel(label_id) {
      this.newUpdateLabel = this.selectedRequest.prerequisite_labels.filter(
        (pre) => pre.id == label_id
      )[0];
      this.$root.$emit(
        "bv::show::modal",
        `edit-online-request-label-${label_id}`
      );
    },

    updateLabel(label_id) {
      axios
        .put(`/api/online-prerequisites/${label_id}`, {
          label: this.newUpdateLabel.label,
        })
        .then((resp) => {
          if (resp.data.status == 200) {
            let data = resp.data.prerequisite;
            let index = this.selectedRequest.prerequisite_labels.findIndex(
              (pre) => pre.id == data.id
            );
            this.selectedRequest.prerequisite_labels.splice(index, 1, data);
          }
          else{console.log('errrro')}
        });
    },

    addLabel(request_id) {
      console.log(request_id);
      axios
        .post("/api/online-prerequisite", {
          online_request_id: request_id,
          label: this.newLabel,
        })
        .then((resp) => {
          this.selectedRequest.prerequisite_labels.push(resp.data.prerequisite);
        })
        .catch((err) => console.log(err));

      // this.selectedRequest.prerequisite_labels.push({ label: this.newLabel });
    },
  },

  created() {
    if (this.online_requests.length == 0) {
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
  validations: {
    selectedRequest: {
      name: {
        required,
        isUnique(value) {
          let excludeSelectedRequest = this.online_requests.filter(
            (req) => req.id !== this.selectedRequest.id
          );
          let index = excludeSelectedRequest.findIndex(
            (request) => request.name == value
          );
          if (index === -1) return true;
          return false;
        },
      },
      description: {
        required,
      },
    },
  },
};
</script>