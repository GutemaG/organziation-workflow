<template>
  <div class="container">
    <b-alert v-if="error" show variant="danger">{{ error }}</b-alert>
    <p>{{ error }}</p>
    <base-card :shadow="true">
      <b-row align-v="center" slot="header">
        <b-col cols="8"> Edit Online Request </b-col>
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
            label="Affair Type"
            class="mb-1 mt-1"
            label-for="description-input"
          >
            <b-form-select
              v-model="$v.selectedRequest.type.$model"
              id="online-request-type-input"
            >
              <b-form-select-option value=""
                >Selecte affair type
              </b-form-select-option>
              <b-form-select-option value="student"
                >Student</b-form-select-option
              >
              <b-form-select-option value="staff">Staff</b-form-select-option>
              <b-form-select-option value="teacher"
                >Teacher</b-form-select-option
              >
              <b-form-select-option value="other">Other</b-form-select-option>
            </b-form-select>
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
          <b-button hidden
            class="m-1"
            variant="primary"
            >add pre-request</b-button
          >
          <base-card >
            <div class="m-2" v-if="selectedRequest.online_request_prerequisite_inputs">
              <h4>Notes</h4>
              <div v-for="(note, index) in selectedRequest.online_request_prerequisite_notes" :key="index">
                <span>{{index + 1}}</span>
                <input type="text" v-model="note.note" class="form-control m-1" style="width:90%;display:inline">
                <span> 
                      <b-button
                        @click="removePrerequisiteNote(index)"
                        variant="danger"
                        size="sm"
                      >
                        <i class="fa fa-minus"></i>
                      </b-button>
                </span>
              </div>
              <b-button
                        @click="addPrerequisiteNote"
                        variant="primary"
                        size="sm"
                      >
                        <i class="fa fa-plus"></i>Add note
                      </b-button>
            </div>
            <hr>
            <div v-if="selectedRequest.online_request_prerequisite_inputs">
              <h4>Inputs</h4>
              <div v-for="(input, index) in selectedRequest.online_request_prerequisite_inputs" :key="index">
                <!-- {{input}} -->
              <div class="row">
                    <div class="col-3">
                      {{ index + 1 }} <label>Name</label>
                      <input
                        v-model="input.name"
                        type="text"
                        class="form-control"
                        placeholder="enter prerequisite name"
                      />
                    </div>
                    <div class="col-3">
                      <label>type</label>
                      <b-select
                        v-model="input.type"
                        :options="['text', 'description', 'number']"
                      >
                      </b-select>
                      <!-- <input v-model="input.type" type="text" class="form-control"> -->
                    </div>
                    <div class="col-3">
                      <label>Description</label>
                      <textarea
                        v-model="input.description"
                        class="form-control"
                        rows="2"
                        placeholder="Enter description for prerequisite"
                      ></textarea>
                    </div>
                    <div class="col-1">
                      <b-button
                        @click="removePrerequisiteLabel(index)"
                        variant="danger"
                        size="sm"
                      >
                        <i class="fa fa-minus"></i>
                      </b-button>
                    </div>
                  </div>
              </div>
                  <b-button
                        @click="addPrerequisiteInput"
                        variant="primary"
                        size="sm"
                      >
                        <i class="fa fa-plus"></i>Add input
                      </b-button>
            </div>
            <b-row align-v="center" slot="header">
              <b-col cols="8">
                <!-- <span v-if="prerequisiteLength != 0">Request Labels</span> -->
                <span >List of Prerequisite</span>
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
  name:'edit-online-request',
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
      "fetchOnlineRequests",
      "updateOnlineRequest",
    ]),
    validateState(value) {
      const { $dirty, $error } = this.$v.selectedRequest[value];
      return $dirty ? !$error : null;
    },
    async handleSubmit() {
        let data = {
            id: this.selectedRequest.id,
            name: this.selectedRequest.name,
            description: this.selectedRequest.description,
            type: this.selectedRequest.type,
            online_request_procedures: this.selectedRequest.online_request_procedures,
            prerequisites:{
                notes: this.selectedRequest.online_request_prerequisite_notes,
                inputs: this.selectedRequest.online_request_prerequisite_inputs,
            }
        }
        if(this.selectedRequest.online_request_prerequisite_notes.length==0){
            delete data["prerequisites"]['notes'];
        }
        if(this.selectedRequest.online_request_prerequisite_inputs.length==0){
            delete data["prerequisites"]['inputs'];
        }
      try {
        // if (this.selectedRequest.prerequisite_labels.length == 0) {
        //   delete this.selectedRequest["prerequisite_labels"];
        // }
        await this.updateOnlineRequest(data);
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
   
    addPrerequisiteInput(){
      this.selectedRequest.online_request_prerequisite_inputs.push({
            input_id:(Math.random() + 1).toString(36).substring(7),
            name:"",
            online_request_id:this.selectedRequest.id,
            type:"text",
            required:true
      })
    },
    addPrerequisiteNote(){
      this.selectedRequest.online_request_prerequisite_notes.push({
            note:"",
      })
    },
    removePrerequisiteNote(index) {
      this.selectedRequest.online_request_prerequisite_notes.splice(index, 1);
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
          } else {
            console.log("errrro");
          }
        });
    },

    removePrerequisiteLabel(index) {
      this.selectedRequest.online_request_prerequisite_inputs.splice(index,1)
      // this.affair.prerequisites.inputs.splice(index, 1);
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
      this.selectedRequest = this.$route.params.request;
      /*
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
      */
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
      type:{
        required
      }
    },
  },
};
</script>