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
      @hide="resetModal"
    >
      <!-- TODO: Validate the input before sending -->
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          label="* Name"
          label-for="bureau-name-input"
          :invalid-feedback="
            !$v.form.name.isUnique ? 'Name already exist' : 'Name is required'
          "
        >
          <b-form-input
            id="bureau-name-input"
            v-model="$v.form.name.$model"
            :state="validateState('name')"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="building-number"
          label="Building"
          label-for="building-number-input"
          invalid-feedback='Select Building number'
        >
          <b-form-select
            v-model="$v.form.building_number.$model"
            :options="building_numbers"
            id="building-number-input"
            :state="validateState('building_number')"
            required
          >
            <b-form-select-option value="" disabled
              >Selecte Bureau Building Number</b-form-select-option
            >
          </b-form-select>
        </b-form-group>
        <b-form-group
          label="Office Number"
          label-for="office-number-input"
          invalid-feedback="Office number is required"
        >
          <b-form-input
            id="office-number-input"
            v-model="$v.form.office_number.$model"
            :state="validateState('office_number')"
            required
          ></b-form-input>
        </b-form-group>
        <b-card bg-variant="light">
          <b-form-group
            label-cols-lg="3"
            label="Location"
            label-size="lg"
            label-class="font-weight-bold pt-0"
            class="mb-0"
          >
            <b-form-group
              label="Latitude:"
              label-for="latitude-input"
              label-cols-sm="3"
              label-align-sm="right"
            >
              <b-form-input
                v-model="locationObj.latitude"
                id="latitude-input"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              label="Longitude:"
              label-for="longitude-input"
              label-cols-sm="3"
              label-align-sm="right"
              invalid-feedback="Enter the correct value"
            >
              <b-form-input
                v-model="locationObj.longitude"
                id="longtitude-input"
              ></b-form-input>
            </b-form-group>
          </b-form-group>
        </b-card>
        <b-form-group
          id="description"
          label="Description"
          label-for="bureau-description"
        >
          <b-form-textarea v-model="form.description" id="input-description">
          </b-form-textarea>
        </b-form-group>
        <b-button
          class="form-control"
          type="submit"
          variant="primary"
          :disabled="$v.$invalid"
          >Add</b-button
        >
      </form>
    </b-modal>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import { required, decimal, or, integer } from "vuelidate/lib/validators";
const notBeNull = (value) => value !== "" || value !== null;
export default {
  data() {
    return {
      locationObj: {
        latitude: "",
        longitude: "",
      },
      form: {
        building_number: "",
        name: "",
        office_number: "",
        description: "",
        // location:"" ,
      },
      submitEnabled: true,
    };
  },
  computed: {
    ...mapGetters(["building_numbers", "bureaus"]),
  },
  created() {
    this.fetchBuildings();
  },
  methods: {
    ...mapActions(["addBureau", "fetchBuildings"]),

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
        (this.form.building_number = ""),
        (this.form.office_number = "");
      this.form.description = "";
      (this.locationObj.latitude = ""), (this.locationObj.longitude = "");
    },
    handleOk() {
      // bvModalEvt.close();
      // Trigger submit handler
      // this.resetModal();
    },
    handleSubmit() {
      const data = {
        ...this.form,
        location: JSON.stringify(this.locationObj),
      };
      this.addBureau(data);
      this.$bvModal.hide("add-bureau-modal");
    },
  },
  validations: {
    form: {
      building_number: {
        required,
      },
      name: {
        required,
        isUnique(value) {
          let index = this.bureaus.findIndex((bureau) => bureau.name == value);
          if (index === -1) return true;
          return false;
        },
      },
      building_number: {
        required,
        notBeNull,
      },
      office_number: { required },
    },
      // TODO: how to use both decimal and integer using or validator
    /*
    locationObj: {
        latitude:{
          decimal,or,integer,
        },
        longitude:{
          decimal, or, integer
        }
      },*/
  },
};
</script>