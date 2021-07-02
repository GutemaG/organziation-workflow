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
        <b-form-group id="building-number" label="Building" label-for="building-input">
          <b-form-select
            v-model="form.building_number"
            :options="building_numbers"
            id="building-input"
          >
            <b-form-select-option value="" disabled
              >Selecte Bureau Building Number</b-form-select-option
            >
          </b-form-select>
        </b-form-group>
        <b-form-group label="Office Number" label-for="office-number-input">
          <b-form-input
            id="office-number-input"
            v-model="form.office_number"
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
        <b-button class="form-control" type="submit" variant="primary"
          >Add</b-button
        >
      </form>
    </b-modal>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
       locationObj: {
          latitude: "",
          longitude: "",
        },
      form: {
        building_number:"",
        name: "",
        office_number: "",
        description: "",
        // location:"" ,
      },
      submitEnabled: true,
    };
  },
  computed: {
    ...mapGetters(["building_numbers"]),
  },
  created() {
    this.fetchBuildings();
  },
  methods: {
    ...mapActions(["addBureau", "fetchBuildings"]),
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      (this.form.name = ""),
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
        location:JSON.stringify(this.locationObj)
      };
      this.addBureau(data);
      this.$bvModal.hide("add-bureau-modal");
    },
  },
};
</script>