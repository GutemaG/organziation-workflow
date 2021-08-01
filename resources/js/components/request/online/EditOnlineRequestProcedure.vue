<template>
  <b-modal
    :id="'edit-online-procedure-' + procedure.id"
    title="Editing Procedure"
    ok-only
    ok-title="Cancel"
    ok-variant="danger"
  >
    <b-form @submit.prevent="updateProcedure">
      <b-form-group
        id="online-request-procedure-bureau"
        label-for="online-request-procedure-bureau-input"
        label="Responsible Bureau"
      >
        <b-form-select
          id="online-request-procedure-bureau-input"
          v-model="editProcedureData.responsible_bureau_id"
          :options="bureau_ids"
          class="select-element"
        >
          <template #first>
            <b-form-select-option selected disabled value="">
              Select Responsible Bureau
            </b-form-select-option>
          </template>
        </b-form-select>
      </b-form-group>
      <b-form-group
        invalid-feedback="required"
        id="online-request-user"
        label-for="online-request-user-input"
        label="Responsible User"
      >
        <v-select
          v-model="editProcedureData.responsible_user_id"
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
              :required="!editProcedureData.responsible_user_id"
              v-bind="attributes"
              v-on="events"
            />
          </template>
        </v-select>
      </b-form-group>
      <b-form-group
        id="online-request-procedures-step-input"
        label="Step"
        label-for="online-request-proceudre-step-number-input"
      >
        <b-form-input
          placeholder="Enter Procedure step"
          id="online-request-proceudre-step-number-input"
          v-model="editProcedureData.step_number"
          type="number"
          required
        >
        </b-form-input>
      </b-form-group>
      <b-form-group
        label="Description"
        label-for="online-request-procedure-description-input"
      >
        <!-- :value="procedure_row.item.description" -->
        <b-form-textarea
          id="online-request-procedure-description-input"
          v-model="editProcedureData.description"
          lazy
          required
        ></b-form-textarea>
      </b-form-group>
      <b-button type="submit" variant="primary" class="form-control"
        >Submit</b-button
      >
      <!-- {{ procedure }} -->
    </b-form>
  </b-modal>
</template>
<script>
import { mapGetters } from "vuex";
import Vselect from "vue-select";
export default {
  components: { "v-select": Vselect },
  props: ["procedure"],
  data() {
    return {
      editProcedureData: {
        id: null,
        online_request_id: null,
        description: null,
        responsible_bureau_id: null,
        step_number: null,
        responsible_user_id: null,
      },
    };
  },
  computed: {
    ...mapGetters(["bureau_ids", "staff_ids"]),
    procedure2() {
      return this.procedure;
    },
  },
  methods: {
    updateProcedure() {
      console.log(this.editProcedureData);
      // return
      axios
        .put(
          `/api/online-procedures/${this.editProcedureData.id}`,
          this.editProcedureData
        )
        .then((resp) => {
          // this.procedure = resp.data.procedure
          console.log(resp);
        })
        .catch((err) => console.log(err));
    },
  },
  created() {
    this.editProcedureData.id = this.procedure.id;
    this.editProcedureData.online_request_id = this.procedure.online_request_id;
    this.editProcedureData.description = this.procedure.description;
    this.editProcedureData.responsible_bureau_id =
      this.procedure.responsible_bureau_id;
    this.editProcedureData.step_number = this.procedure.step_number;
    this.editProcedureData.responsible_user_id = this.procedure.users.map(
      (user) => user.id
    );
  },
};
</script>