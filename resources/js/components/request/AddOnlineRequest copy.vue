
<template>
  <div>
    <h1>Add Online Request</h1>
    <b-form @submit.stop.prevent="handleSubmit">
      <b-card no-body :class="[{ 'card-lift--hover': false },{'shadow':true}]">
        <b-card-body>
        <!-- input for request name and desc -->
        <div>
          <b-form-group
            id="online-request-name"
            label="Name"
            label-for="online-request-name-input"
          >
            <b-form-input
              id="online-request-name-input"
              v-model.trim="affair.name"
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
              v-model="affair.description"
            ></b-form-textarea>
          </b-form-group>
        </div>
        <!-- end input for request name and desc -->

        <hr />
        <div class="m-2">
          <!-- div forloop for procedures-->
          <div
            v-for="(
              procedure, procedure_index
            ) in affair.online_request_procedures"
            :key="procedure_index"
          >
            <div>
              <!-- !card for prorcedure bureau, user, step, desc-->
              <b-card>
                <b-row>
                  <b-col cols="12" md="6">
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
                        :options="user_ids"
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
                  <hr />
                </b-row>
              </b-card>
              <!-- /**end card for prorcedure bureau, user, step, desc */-->
            </div>
          </div>
          <!-- end div for loop for procedures -->
          <b-col>
            <!-- div forloop for prerequisite -->
            <div
              v-for="(label, pre_index) in affair.prerequisite_labels"
              :key="pre_index"
            >
              <b-card class="m-1">
                <b-card-header>
                  <b-row>
                    <b-col cols="8"> Pre Request </b-col>
                    <b-col cols="4">
                      <b-button variant="outline-danger">
                        <i class="fa fa-trash"></i>
                      </b-button>
                    </b-col>
                  </b-row>
                </b-card-header>
                <b-form-group
                  id="online-prerequisite-procedures-input"
                  label="Label"
                  label-for="online-prerequisite-label-input"
                >
                  <b-form-input
                    placeholder="Enter Procedure step"
                    id="online-prerequisite-label-input"
                    v-model="label.label"
                    type="number"
                  >
                  </b-form-input>
                </b-form-group>
              </b-card>
            </div>
            <!-- end forloop for prerequsite -->
            <b-button variant="primary" class="m-1"> +Pre Request </b-button>
          </b-col>
          <b-button class="form-control" variant="dark"> +Procedure </b-button>
        </div>

        <b-button type="submit" class="form-control" variant="outline-primary"
          >Submit</b-button
        >
        </b-card-body>
      </b-card>
    </b-form>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      affair: {
        name: "",
        description: "",
        online_request_procedures: [
          {
            responsible_bureau_id: "",
            description: "",
            step_number: "",
            responsible_user_id: "",
          },
          {
            responsible_bureau_id: "",
            description: "",
            step_number: "",
            responsible_user_id: "",
          },
        ],
        prerequisite_labels: [
          {
            label: "",
          },
          {
            label: "",
          },
        ],
      },
      responsible_bureau_options: [
        { value: "nothin", text: "What the fuck" },
        { value: "nothin", text: "What the fuck" },
        { value: "nothin", text: "What the fuck" },
        { value: "nothin", text: "What the fuck" },
      ],
    };
  },
  computed: {
    ...mapGetters(["bureau_ids", "user_ids"]),
  },
  methods: {
    ...mapActions(["addOnlineRequest"]),
    handleSubmit() {
      this.addOnlineRequest(this.affair);
      console.log(JSON.stringify(this.affair));
    },
  },
};
</script>