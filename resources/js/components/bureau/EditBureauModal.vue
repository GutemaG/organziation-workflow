
<template>
  <b-modal
    id="edit-bureau-modal"
    title="Edit"
    ok-only
    ok-title="Cancel"
    ok-variant="danger"
  >
    <form ref="form" @submit.stop.prevent="updateForm">
      <b-form-group label="Name" label-for="bureau-name-input">
          <b-form-input
            id="bureau-name-input"
            v-model="selectedBureau.name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="building-number" label="Building" label-for="building-input">
          <b-form-select
            v-model="selectedBureau.building_number"
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
            v-model="selectedBureau.office_number"
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
                v-model="location.latitude"
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
                v-model="location.longitude"
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
          <b-form-textarea v-model="selectedBureau.description" id="input-description">
          </b-form-textarea>
        </b-form-group>
       
      <b-button class="form-control" type="submit" variant="primary"
        >UPDATE</b-button
      >
    </form>
  </b-modal>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

// TODO: modify using props of selectedUser, to reset
export default {
  props: {
    selectedBureau: {
      type: Object,
      required: true,
    },
  },
  data(){
      return{
        location:{
          latitude:'',
          longitude:''
        } 
      }

  },
  watch:{
    latitude(){
      this.location.latitude = this.latitude;
      this.location.longitude = this.longitude;
    }
  },
  computed:{
    ...mapGetters(['building_numbers']),
    latitude:{
      get:function(){
        let loc = this.selectedBureau.location
        if(!loc){
          return 0;
        }
      let lat = JSON.parse(loc).latitude
      return lat
      },
      set: function(){
        this.location.latitude = this.latitude;
      }

    },
    longitude:{
      get:function(){
        let loc = this.selectedBureau.location
        if(!loc){
          return 0;
        }
      let long = JSON.parse(loc).longitude
      return long
      },
      set: function(){
        this.location.longitude = this.longitude
      }

    },
  },
  methods: {
    ...mapActions(["updateBureau"]),
    updateForm(event) {
      event.preventDefault();
      let id = this.selectedBureau.id;
      let building_number = this.selectedBureau.building_number
      let created_at = this.selectedBureau.created_at
      let accountable_to  = this.selectedBureau.accountable_to
      let name = this.selectedBureau.name
      let office_number = this.selectedBureau.office_number
      let location = JSON.stringify(this.location);
      let description = this.selectedBureau.description
      // let user_id = this.selectedBureau.user_id
      const data = {
        id, building_number,created_at,accountable_to, name, office_number,
        location, description
      };
      this.updateBureau(data);
      this.$bvModal.hide("edit-bureau-modal");
    },
  },
};
</script>