
<template>
  <div class="container mt-2">
    <h1>Add Online Request</h1>
    <p>
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero ut et ad explicabo tenetur recusandae alias molestias 
      distinctio inventore repellat ducimus aliquid nulla debitis veritatis obcaecati reiciendis cumque, error officiis.
      Iure explicabo saepe quia sed provident commodi nam eum enim totam atque laborum autem labore aspernatur, accusamus, 
      cupiditate tempore corporis voluptates odio? Fugiat, accusantium. Incidunt nihil eaque quae est voluptatibus!
    </p>
    <b-alert variant="danger" show v-if="missedStepNumbers"
      >Please Fille the step number correctly</b-alert
    >
    <base-card :shadow="true">
      <b-row align-v="center" slot="header">
        <b-col cols="8"> Add Online Reqeust </b-col>
        <b-col cols="4"> Edit </b-col>
      </b-row>
      <b-form @submit.stop.prevent="handleSubmit">
        <div>
          <b-form-group
            id="online-request-name"
            label="Name"
            label-for="online-request-name-input"
            :invalid-feedback="
              !$v.affair.name.isUnique ? 'Already exist' : 'Name is required'
            "
          >
            <b-form-input
              id="online-request-name-input"
              v-model.trim="$v.affair.name.$model"
              :state="validateState('name')"
              required
            >
            </b-form-input>
          </b-form-group>
          <b-form-group
            label="Request Type"
            label-for="description-input"
          >
            <b-form-select
              v-model="$v.affair.type.$model"
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
            invalid-feedback="Required"
          >
            <b-form-textarea
              id="online-request-description-input"
              v-model="$v.affair.description.$model"
              :state="validateState('description')"
              required
            ></b-form-textarea>
          </b-form-group>
        </div>
        
        <div>
          <b-card class="shadow">
            <b-card-header header-text-variant="white" class="text-center" style="background-color:#8e5727 !important; border-radius: 2rem 2rem 0 0;">
              <span style="font-size: 1.3rem"><strong>Add Procedures</strong></span>
            </b-card-header>
            <b-card-body
              style="border-color: #8e5727 !important; border: 1px solid;"
            >
              
              <div 
              v-for="(
                procedure, procedure_index
              ) in affair.online_request_procedures"
              :key="procedure_index">
                <!-- !card for prorcedure bureau, user, step, desc-->
                <div class="card" style="border: none; box-shadow: none;">
                  <b-card-header header-bg-variant="secondary" class="text-center" style="border-radius: 2rem 2rem 0 0;">
                    <span style="font-size: 1.3rem"><strong>Procedure - {{ procedure_index }}</strong></span>
                    <b-button 
                    v-if="affair.online_request_procedures.length > 1"
                    @click="removeProcedure(procedure_index)" 
                    class="float-right" 
                    variant="danger">
                      <i class="fa fa-trash"></i>
                    </b-button>
                  </b-card-header>
                  <b-card-body style="border: 2px solid rgba(0, 0, 0, 0.251);">
                    <b-form-group
                      id="online-request-bureau"
                      label-for="online-request-bureau-input"
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
                    <!--TODO: from here I remove bureau from  -->
                    <b-form-group
                      invalid-feedback="required"
                      id="online-request-user"
                      label-for="online-request-user-input"
                      label="Responsible User"
                    >
                      <v-select
                        v-model="procedure.responsible_user_id"
                        label="text"
                        :options="staff_ids"
                        :reduce="(staff) => staff.value"
                        placeholder="Select Responsible User"
                        multiple
                        :close-on-select="false"
                      >
                        <template #search="{ attributes, events }">
                          <input
                            class="vs__search"
                            :required="!procedure.responsible_user_id"
                            v-bind="attributes"
                            v-on="events"
                          />
                        </template>
                      </v-select>
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
                        required
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
                  </b-card-body>
                </div>
                <!-- /**end card for prorcedure bureau, user, step, desc */-->
              </div>
              <b-button pill block class="form-control" variant="dark" @click="addProcedure">
                + Procedure
              </b-button>
            </b-card-body>
          </b-card>
        </div>
        <b-button
          v-if="!prerequisite"
          @click="prerequisite = true"
          variant="primary"
          >
            Add Pre-request
          </b-button>
        <b-card v-if="prerequisite" style="width: 70%;">
          <b-card-header header-bg-variant="secondary" class="text-left" style="border-radius: 2rem 0 0 0;">
            <span style="font-size: 1.3rem;"><strong>Add Pre Request Labels</strong></span>
            <b-button variant="danger" @click="removeLabel()" class="float-right">
              <i class="fa fa-trash"></i>
            </b-button>
          </b-card-header>
          <b-card-body style="border: 2px solid rgba(0, 0, 0, 0.251);">
            <b-form-group label="Pre-request names: ">
              <b-form-tags
                v-model="affair.prerequisite_labels"
                no-outer-focus
                style="border:0px"
              >
                <template
                  v-slot="{ tags, inputAttrs, inputHandlers, addTag, removeTag }"
                >
                  <b-input-group class="">
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
                  <b-container>
                    <ul v-if="tags.length > 0" style="width: 90%">
                      <li
                        v-for="tag in tags"
                        :key="tag"
                        :title="`Tag: ${tag}`"
                        class="mt-1"
                      >
                        <b-button variant="none" block class="d-flex align-items-center text-left" style="justify-content:space-between">
                          <span>{{ tag }}</span>
                          <b-button
                            size="sm"
                            variant="danger"
                            class="float-right"
                            @click="removeTag(tag)"
                          >
                            Remove label
                          </b-button>
                        </b-button>
                      </li>
                    </ul>
                  </b-container>
                </template>
              </b-form-tags>
            </b-form-group>
          </b-card-body>
        </b-card>
        <b-button
          type="submit"
          pill
          class="form-control mt-4 mb-4 float-right" style="width: 8rem;" 
          variant="primary"
          :disabled="$v.$invalid || missedStepNumbers"
        >
          Submit</b-button
        >
      </b-form>
    </base-card>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import { required } from "vuelidate/lib/validators";
import Vselect from "vue-select";
import Multiselect from "vue-multiselect";
export default {
  components: { Multiselect, "v-select": Vselect },
  data() {
    return {
      affair: {
        name: "",
        description: "",
        type:"",
        online_request_procedures: [
          {
            responsible_bureau_id: "",
            description: "",
            step_number: 1,
            responsible_user_id: [],
          },
        ],
        prerequisite_labels: [],
      },
      prerequisite: false,
    };
  },
  computed: {
    ...mapGetters(["bureau_ids", "staff_ids", "online_requests"]),
    staff_id_only() {
      let ids = this.staff_ids.map((staff) => staff.value);
      let labels = this.staff_ids.map((staff) => staff.text);
      return ids;
    },
    missedStepNumbers() {
      let step = [];
      let procedure = this.affair.online_request_procedures;
      let missed_step = [];
      for (let i = 0; i < procedure.length; i++) {
        step.push(procedure[i].step_number);
      }
      step = step.sort();
      if (step[0] != 1) {
        missed_step.push(1);
      }
      if (step.length > 1) {
        for (let i = 1; i < step.length; i++) {
          if (step[i] - step[i - 1] != 1) {
            missed_step.push(step[i]);
          }
        }
      }
      return missed_step.length !== 0; //?false;
    },
  },
  methods: {
    ...mapActions(["addOnlineRequest"]),
    validateState(value) {
      const { $dirty, $error } = this.$v.affair[value];
      return $dirty ? !$error : null;
    },
    handleSubmit() {
      let tempo = this.affair;
      if (tempo.prerequisite_labels.length == 0) {
        delete tempo["prerequisite_labels"];
      }
      this.addOnlineRequest(tempo);
      // this.$router.go(-1);
      this.$router.push('/online-requests')
      // console.log(JSON.stringify(tempo));
    },

    addProcedure() {
      let totalStep = this.affair.online_request_procedures.length;
      this.affair.online_request_procedures.push({
        responsible_bureau_id: "",
        description: "",
        step_number: totalStep + 1,
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
    affair: {
      name: {
        required,
        isUnique(value) {
          let index = this.online_requests.findIndex(
            (req) => req.name == value
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
<style src='vue-select/dist/vue-select.css'></style>
<style scoped>
.select-element {
  line-height: normal;
  white-space: normal;
  top: 50%;
  display: flex;
  flex-wrap: wrap;
}
</style>
