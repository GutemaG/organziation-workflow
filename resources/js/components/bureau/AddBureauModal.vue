<template>
  <div>
    <b-modal
      id="add-bureau-modal"
      ref="modal"
      title="Add New Bureau"
      @show="resetModal"
      ok-only
      ok-title="Cancel"
      ok-variant="danger"
    >
      <!-- TODO: Validate the input before sending -->
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group label="Name" label-for="bureau-name-input">
          <b-form-input
            id="bureau-name-input"
            v-model="form.name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="building" label="Building" label-for="building">
          <b-form-select
            v-model="form.building"
            :options="buildings"
            id="input-building"
          >
            <b-form-select-option value="" disabled
              >Selecte Bureau Building Number</b-form-select-option
            >
          </b-form-select>
        </b-form-group>
        <b-form-group
          id="office-number"
          label="Office Number"
          label-for="input-office-number"
        >
          <b-form-select
            v-model="form.office_number"
            :options="office_numbers"
            id="input-office-number"
          >
            <b-form-select-option value="" disabled
              >Selecte Bureau Office Number</b-form-select-option
            >
          </b-form-select>
        </b-form-group>
        <b-form-group
          id="description"
          label="Description"
          label-for="bureau-description"
        >
          <b-form-textarea v-model="form.description" id="input-description">
          </b-form-textarea>
        </b-form-group>
        <b-button class="form-control" type="submit" variant="primary"
          >Add</b-button
        >
      </form>
    </b-modal>
  </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      form: {
        name: "",
        building: "",
        office_number: "",
        description: "",
      },
      submitEnabled: true,
      buildings: [
        { value: "B-100", text: "B-100" },
        { value: "B-361", text: "B-361" },
        { value: "B-529", text: "B-529" },
      ],
      office_numbers: [
        { value: "1", text: "1" },
        { value: "2", text: "2" },
        { value: "4", text: "4" },
      ],
    };
  },
  methods: {
    ...mapActions(["addBureau"]),
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      (this.form.name = ""),
        (this.form.building = ""),
        (this.form.office_number = ""),
        (this.form.description = "");
    },
    handleOk() {
      // bvModalEvt.close();
      // Trigger submit handler
      // this.resetModal();
    },
    handleSubmit() {
      const data = {
        ...this.form,
      };
      this.addBureau(data);
      this.$bvModal.hide("add-bureau-modal");
    },
  },
};
/*
        permission_options: [
                { text: "Delete FAQ", value: "delete_FAQ" },
                { text: "Update FAQ", value: "update_FAQ" },
                { text: "Reply Request", value: "reply_request" },
                { text: "Add request to FAQ", value: "add_request_to_FAQ" },
                { text: "Delete Request", value: "delete_request" },
                { text: "Create Bureau", value: "create_bureau" },
                { text: "Update Bureau", value: "update_bureau" },
                { text: "Delete Bureau", value: "delete_bureau" },
                { text: "Create Affair", value: "create_affair" },
                { text: "Update Affair", value: "update_affair" },
                { text: "Delete Affair", value: "delete_affair" },

            ],
            perm: ['delete_FAQ', 'update_FAQ', 'reply_request', 'add_request_to_FAQ', 'delete_request', 'create_bureau', 'update_bureau', 'delete_bureau', 'create_affair', 'update_affair', 'delete_affair'],
*/
</script>