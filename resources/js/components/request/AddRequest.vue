<template>
  <div class="container">
    <b-form @submit="handleSubmit">
      <b-alert variant="danger" show v-if="missedStepNumber"
        >Please Fille the step number correctly</b-alert
      >
      <b-card class="m-2 mt-3" header="Creating Affair">
        <b-form-group
          label="Affair Name"
          label-for="affair-name-input"
          invalid-feedback="Required"
          description="Name for the affair or request that will be handled"
        >
          <b-form-input
            id="affair-name-input"
            placeholder="Enter Affair Name"
            v-model="$v.affair.name.$model"
            :state="validateState('name')"
            required
          >
          </b-form-input>
        </b-form-group>

        <b-form-group label="Affair Type" label-for="description-input">
          <b-form-select v-model="$v.affair.type.$model" id="affair-type-input">
            <b-form-select-option value=""
              >Select affair type
            </b-form-select-option>
            <b-form-select-option value="student">Student</b-form-select-option>
            <b-form-select-option value="staff">Staff</b-form-select-option>
            <b-form-select-option value="teacher">Teacher</b-form-select-option>
            <b-form-select-option value="other">Other</b-form-select-option>
          </b-form-select>
        </b-form-group>

        <b-form-group
          label="Description"
          label-for="procedure-description-input"
          description=""
        >
          <b-form-textarea
            rows="3"
            v-model="affair.description"
            id="affair-description-input"
            placeholder="description for current procedure(optional)"
          ></b-form-textarea>
        </b-form-group>

        <div class="mt-4 mb-4">
          <div
            v-for="(procedure, procedure_index) in affair.procedures"
            :key="procedure_index"
          >
            <b-card class="shadow-sm">
              <b-card-header
                header-bg-variant="secondary"
                class="text-center"
                style="border-radius: 2rem 2rem 0 0"
              >
                <span style="font-size: 1rem"
                  ><strong>Procedure - {{ procedure_index }}</strong></span
                >
                <b-button
                  v-if="procedureLength > 1"
                  @click="removeProcedure(procedure_index)"
                  class="float-right"
                  variant="danger"
                >
                  <i class="fa fa-trash"></i>
                </b-button>
              </b-card-header>

              <b-card-body style="border: 2px solid rgba(0, 0, 0, 0.251)">
                <b-row>
                  <b-col cols="12" md="6">
                    <b-form-group
                      label="Procedure Name"
                      :label-for="'procedure-' + procedure_index + 'step-input'"
                      invalid-feedback="Required"
                    >
                      <b-form-input
                        :id="'procedure-' + procedure_index + '-description'"
                        placeholder="Enter Procedure Name"
                        v-model="procedure.name"
                        required
                      >
                      </b-form-input>
                    </b-form-group>
                    <b-form-group
                      id="request-responsible-bureau"
                      label-for="request-responsible-bureau-input"
                      label="Responsible Bureau"
                      invalid-feedback="required"
                    >
                      <v-select
                        v-model="procedure.responsible_bureau_id"
                        label="text"
                        :options="bureau_ids"
                        :reduce="(bureau) => bureau.value"
                        placeholder="Select bureau"
                      >
                        <template #search="{ attributes, events }">
                          <input
                            class="vs__search"
                            :required="!procedure.responsible_bureau_id"
                            v-bind="attributes"
                            v-on="events"
                          />
                        </template>
                      </v-select>
                    </b-form-group>
                    <b-form-group
                      label="Description"
                      class="mb-1 mt-1"
                      :label-for="
                        'procedure-' + procedure_index + '-description-input'
                      "
                    >
                      <b-form-textarea
                        rows="3"
                        v-model="procedure.description"
                        :id="
                          'procedure-' + procedure_index + '-description-input'
                        "
                        placeholder="description for current procedure(optional)"
                      ></b-form-textarea>
                    </b-form-group>

                    <b-form-group
                      label="Step"
                      :label-for="'procedure-' + procedure_index + 'step-input'"
                      invalid-feedback="Required"
                    >
                      <b-form-input
                        :id="'procedure-' + procedure_index + '-step-input'"
                        placeholder="Enter Procedure Number"
                        v-model="procedure.step"
                        type="number"
                        required
                      >
                      </b-form-input>
                    </b-form-group>
                  </b-col>

                  <b-col>
                    <div
                      v-for="(pre_request, pre_index) in affair.procedures[
                        procedure_index
                      ].pre_requests"
                      :key="pre_index"
                    >
                      <b-card
                        class="shadow shadow-lg--hover"
                        border-variant="light"
                      >
                        <b-card-header
                          header-bg-variant="info"
                          header-text-variant="dark"
                          class="text-center"
                          style="border-radius: 2rem 2rem 0 0"
                        >
                          <span style="font-size: 1.3rem"
                            ><strong>Pre Request</strong></span
                          >
                          <b-button
                            @click="
                              removePreRequest(procedure_index, pre_index)
                            "
                            class="float-right"
                            variant="danger"
                          >
                            <i class="fa fa-trash"></i>
                          </b-button>
                        </b-card-header>

                        <b-card-body
                          body-border-variant="info"
                          style="
                            border-radius: 0 0 2rem 2rem;
                            border: 2px solid rgba(0, 0, 0, 0.151);
                          "
                        >
                          <b-form-group
                            label="Pre Request Name"
                            :label-for="
                              'pre_request-' +
                              procedure_index +
                              '-' +
                              pre_index +
                              'name-input'
                            "
                            invalid-feedback="Required"
                          >
                            <b-form-input
                              :id="
                                'pre_request-' +
                                procedure_index +
                                '-' +
                                pre_index +
                                '-name-input'
                              "
                              placeholder="Enter Pre request Name"
                              v-model="pre_request.name"
                              required
                            >
                            </b-form-input>
                          </b-form-group>

                          <b-form-group
                            label="Pre Request Description"
                            class="mb-1 mt-1"
                            :label-for="
                              'pre_request-' +
                              procedure_index +
                              '-' +
                              pre_index +
                              '-description'
                            "
                          >
                            <b-form-textarea
                              rows="3"
                              v-model="pre_request.description"
                              :id="
                                'pre_request-' +
                                procedure_index +
                                '-' +
                                pre_index +
                                '-description'
                              "
                              placeholder="description for current procedure(optional)"
                            ></b-form-textarea>
                          </b-form-group>
                          <b-form-group
                            id="pre-request-affair"
                            label="Select Affair"
                            label-for="pre-request-affair-input"
                          >
                            <b-form-select
                              v-model="pre_request.affair_id"
                              id="pre-request-affair-input"
                              :options="affair_ids"
                              v-bind:disabled="
                                pre_request.name.length !== 0 ||
                                pre_request.description.length !== 0
                              "
                            >
                              <!-- v-bind:selected="
                                    pre_request.name.length !== 0 ||
                                    pre_request.description.length !== 0
                                  " -->

                              <slot hidden>
                                <b-form-select-option value=""
                                  >Select Affair: if pre request is
                                  affair(optional)</b-form-select-option
                                >
                              </slot>
                            </b-form-select>
                          </b-form-group>
                        </b-card-body>
                      </b-card>
                    </div>
                    <b-button
                      pill
                      block
                      @click="addPreRequest(procedure_index)"
                      variant="primary"
                      class="mt-4 mb-4 shadow"
                    >
                      +Pre Request
                    </b-button>
                  </b-col>
                </b-row>
                <b-button
                  pill
                  @click="addProcedure"
                  class="form-control mt-3 mb-3"
                  variant="dark"
                >
                  +Procedure
                </b-button>
              </b-card-body>
            </b-card>
          </div>
        </div>
      </b-card>
      <b-button
        type="submit"
        pill
        class="form-control mt-4 mb-4 float-right"
        style="width: 8rem"
        variant="primary"
        :disabled="$v.$invalid || missedStepNumber"
      >
        Submit
      </b-button>
    </b-form>
    <!-- </b-container> -->
  </div>
</template>
<script>
import Vselect from "vue-select";
import { mapActions, mapGetters } from "vuex";
import { required } from "vuelidate/lib/validators";
export default {
  name: "add-request",
  components: { "v-select": Vselect },
  data() {
    return {
      affair: {
        name: "",
        description: "",
        type: "",
        procedures: [
          {
            name: "",
            description: "",
            step: 1,
            pre_requests: [],
            responsible_bureau_id: null,
          },
        ],
      },
    };
  },
  computed: {
    ...mapGetters(["affair_ids", "bureau_ids"]),
    procedureLength() {
      return this.affair.procedures.length;
    },
    missedStepNumber() {
      let steps = [];
      let procedures = this.affair.procedures;
      let missed_steps = [];
      for (let i = 0; i < procedures.length; i++) {
        steps.push(procedures[i].step);
      }
      steps = steps.sort();
      if (steps[0] != 1) {
        missed_steps.push(1);
      }
      if (steps.length > 1) {
        for (let i = 1; i < steps.length; i++) {
          if (steps[i] - steps[i - 1] != 1) {
            missed_steps.push(steps[i]);
          }
        }
      }
      if (missed_steps.length !== 0) {
        this.$bvToast.toast("Please check there are missed step numbers", {
          title: "Please Fill the form Correctly",
          variant: "danger",
          solid: true,
        });
      }
      return missed_steps.length !== 0;
    },
  },
  methods: {
    ...mapActions(["addAffair", "fetchBureaus"]),
    validateState(name) {
      const { $dirty, $error } = this.$v.affair[name];
      return $dirty ? !$error : null;
    },
    addUser() {
      this.users.push({
        username: "",
        first_name: "",
        last_name: "",
      });
    },
    addProcedure() {
      this.affair.procedures.push({
        name: "",
        description: "",
        step: this.procedureLength + 1,
        pre_requests: [],
        responsible_bureau_id: null,
      });
      console.log("add Procedure");
    },
    addPreRequest(preocdure_index) {
      // console.log(`add preReqeust for ${index}`);
      let pre_request = this.affair.procedures[preocdure_index].pre_requests;
      pre_request.push({
        name: "",
        description: "",
        affair_id: "",
      });
      console.log(pre_request);
    },
    removePreRequest(procedure_index, pre_index) {
      let procedure = this.affair.procedures[procedure_index].pre_requests;
      procedure.splice(pre_index, 1);
      console.log(`removed ${pre_index}`);
    },
    removeProcedure(procedure_index) {
      let procedure = this.affair.procedures;
      if (procedure.length > 1) {
        procedure.splice(procedure_index, 1);
      }
    },
    handleSubmit(event) {
      event.preventDefault();
      let data = {
        affair: this.affair,
      };
      this.addAffair(data);
      console.log(JSON.stringify(this.affair));
      this.$router.push("/requests");
    },
  },
  validations: {
    affair: {
      name: {
        required,
      },
      type: {
        required,
      },
      procedures: {
        name: required,
      },
    },
  },
  mounted() {
    this.fetchBureaus();
  },
};
</script>
