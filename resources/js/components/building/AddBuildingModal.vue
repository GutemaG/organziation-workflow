
<template>
  <div>
    <b-modal
      id="add-building-modal"
      ref="modal"
      title="Add New Building"
      @show="resetModal"
      ok-only
      ok-title="Cancel"
      ok-variant="danger"
    >
      <!-- TODO: Validate the input before sending -->
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group label="Name" label-for="building-name-input">
          <b-form-input
            id="building-name-input"
            v-model="form.name"
            placeholder="You can leave it"
          ></b-form-input>
        </b-form-group>

        <b-form-group label="Building Number" label-for="building-number-input">
          <b-form-input
            id="building-number-input"
            v-model="form.building_number"
            required
            placeholder="Building number 529, B-529"
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="number_of_offices"
          label="Number of Offices"
          label-for="input-number-of-offices"
        >
          <b-form-input
            type="number"
            v-model="form.number_of_offices"
            id="input-number-of-offices"
          >
          </b-form-input>
        </b-form-group>

        <b-form-group
          id="description"
          label="Description"
          label-for="Building-description"
        >
          <b-form-textarea v-model="form.description" id="input-description" placeholder="You can leave it">
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
        building_number: "",
        number_of_offices: "",
        description: "",
      },
      submitEnabled: true,
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
        (this.form.building_number= ""),
        (this.form.number_of_offices = ""),
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
    //   this.addBureau(data)
    console.log(data)
      this.$bvModal.hide("add-building-modal");
    },
  },
};
</script>