
<template>
  <div class="container">
    <h1>Add Online Request</h1>
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
              v-model.trim="affair.name"
              required
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
              required
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
              ) in affair.online_request_procedures"
              :key="procedure_index"
            >
              <div>
                <!-- !card for prorcedure bureau, user, step, desc-->
                <base-card>
                  <b-row align-v="center" slot="header">
                    <b-col cols="8"> Procedure - {{ procedure_index }}</b-col>
                    <b-col
                      cols="4"
                      v-if="affair.online_request_procedures.length > 1"
                    >
                      <b-button @click="removeProcedure(procedure_index)">
                        <i class="fa fa-trash"></i
                      ></b-button>
                    </b-col>
                  </b-row>
                  <b-row>
                    <b-col cols="12">
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
                          style="height: 10rem"
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
                        label-for="online-request-proceudre-step-number-input"
                      >
                        <b-form-input
                          placeholder="Enter Procedure step"
                          id="online-request-proceudre-step-number-input"
                          v-model="procedure.step_number"
                          type="number"
                        >
                        </b-form-input>
                      </b-form-group>
                      <b-form-group
                        label="Procedures Description"
                        id="online-request-procedures-description"
                        label-for="online-request-procedures-description-input"
                      >
                        <b-form-textarea
                          v-model="procedure.description"
                          placeholder="Enter Description for Procedure"
                          id="online-request-procedures-description-input"
                        >
                        </b-form-textarea>
                      </b-form-group>
                    </b-col>
                    <hr />
                  </b-row>
                </base-card>
                <!-- /**end card for prorcedure bureau, user, step, desc */-->
              </div>
            </div>
            <b-button class="form-control" variant="dark" @click="addProcedure"
              >+ Procedure</b-button
            >
          </base-card>
        </div>
        <b-button
          v-if="!prerequisite"
          @click="prerequisite = true"
          variant="primary"
          >add pre-request</b-button
        >
        <base-card v-if="prerequisite">
          <b-row align-v="center" slot="header">
            <b-col cols="8">Add Pre Request Labels</b-col>
            <b-col cols="4"
              ><b-button variant="danger" @click="removeLabel()"
                ><i class="fa fa-trash"></i></b-button
            ></b-col>
          </b-row>
          <b-form-group label="Label">
            <b-form-tags
              v-model="affair.prerequisite_labels"
              no-outer-focus
              class="mb-2"
            >
              <template
                v-slot="{ tags, inputAttrs, inputHandlers, addTag, removeTag }"
              >
                <b-input-group class="mb-2">
                  <b-form-input
                    id="pre-request-lable-input"
                    v-bind="inputAttrs"
                    v-on="inputHandlers"
                    placeholder="Enter pre request Label, use enter or click add button"
                    class="form-control"
                  ></b-form-input>
                  <b-input-group-append>
                    <b-button @click="addTag()" variant="primary">Add</b-button>
                  </b-input-group-append>
                </b-input-group>
                <ul v-if="tags.length > 0" class="mb-0">
                  <li
                    v-for="tag in tags"
                    :key="tag"
                    :title="`Tag: ${tag}`"
                    class="mt-2"
                  >
                    <span class="d-flex align-items-center">
                      <span class="mr-2">{{ tag }}</span>
                      <b-button
                        size="sm"
                        variant="outline-danger"
                        @click="removeTag(tag)"
                      >
                        remove label
                      </b-button>
                    </span>
                  </li>
                </ul>
              </template>
            </b-form-tags>
          </b-form-group>
        </base-card>
        <hr class="my-5" />
        <b-button type="submit" class="form-control" variant="primary">
          Submit</b-button
        >
      </b-form>
    </base-card>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import { required } from "vuelidate/lib/validators";
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
            responsible_user_id: [],
          },
        ],
        prerequisite_labels: [],
      },
      prerequisite: false,
    };
  },
  computed: {
    ...mapGetters(["bureau_ids", "staff_ids"]),
  },
  methods: {
    ...mapActions(["addOnlineRequest"]),
    validateState(value) {
      const { $dirty, $error } = this.$v.selectedRequest[value];
      return $dirty ? !$error : null;
    },
    handleSubmit() {
      this.addOnlineRequest(this.affair);
      this.$router.go(-1);
      // this.$router.push('/online-requests')
      console.log(JSON.stringify(this.affair));
    },
    addProcedure() {
      this.affair.online_request_procedures.push({
        responsible_bureau_id: "",
        description: "",
        step_number: "",
        responsible_user_id: [],
      });
    },
    addLabel() {
      this.affair.prerequisite_labels.push({
        label: "",
      });
      console.log("Adding Label");
    },
    removeProcedure(index) {
      let procedures = this.affair.online_request_procedures;
      procedures.splice(index, 1);
    },
    removeLabel(index) {
      this.affair.prerequisite_labels = [];
      this.prerequisite = false;
    },
  },
  validations: {
    selectedRequest: {
      name: {
        required,
        isUnique(value) {
          let index = this.online_requests.filter(
            (req) => req.name !== value
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