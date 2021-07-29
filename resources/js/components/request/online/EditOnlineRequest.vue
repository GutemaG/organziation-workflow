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
                      <b-button @click="removeProcedure(procedure_index)">
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
export default {
  props: ["id"],
  data() {
    return {
      request_id: this.$route.params.id,
      selectedRequest: {},
      prerequisite: false,
      error: null,
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
        await this.updateOnlineRequest(this.selectedRequest);
        this.$router.push("/online-requests");
      } catch (err) {
        console.error(err);
        this.error = "Fill the form Correctly";
      }
      // // console.log(this.selectedRequest);
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