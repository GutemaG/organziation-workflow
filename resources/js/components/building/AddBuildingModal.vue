
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

        <b-form-group
          label="Building Number"
          label-for="building-number-input"
          :invalid-feedback="
            !$v.form.number.isUnique
              ? 'Building already registered'
              : 'Building number is required'
          "
        >
          <b-form-input
            id="building-number-input"
            v-model="$v.form.number.$model"
            :state="validateState('number')"
            required
            placeholder="Building number 529, B-529"
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="number_of_offices"
          label="Number of Offices"
          label-for="input-number-of-offices"
          invalid-feedback="Number of office is required"
        >
          <b-form-input
            type="number"
            v-model="$v.form.number_of_offices.$model"
            id="input-number-of-offices"
            :state="validateState('number_of_offices')"
            required
          >
          </b-form-input>
        </b-form-group>

        <b-form-group
          id="description"
          label="Description"
          label-for="Building-description"
        >
          <b-form-textarea
            v-model="form.description"
            id="input-description"
            placeholder="You can leave it"
          >
          </b-form-textarea>
        </b-form-group>
        <b-button class="form-control" type="submit" variant="primary"
        :disabled="$v.$invalid"
          >Add</b-button
        >
      </form>
    </b-modal>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import { required } from "vuelidate/lib/validators";
export default {
  data() {
    return {
      form: {
        name: "",
        number: "",
        number_of_offices: "",
        description: "",
      },
      submitEnabled: true,
    };
  },
  computed: {
    ...mapGetters(["buildings"]),
  },
  methods: {
    ...mapActions(["addBuilding"]),
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      (this.form.name = ""),
        (this.form.number = ""),
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
      this.addBuilding(data);
      this.$bvModal.hide("add-building-modal");
      console.log(data);
    },
  },
  validations: {
    form: {
      number: {
        required,
        isUnique(value) {
          let index = this.buildings.findIndex(
            (building) => building.number == value
          );
          if (index === -1) return true;
          return false;
        },
      },
      number_of_offices: {
        required,
      },
    },
  },
};
</script>