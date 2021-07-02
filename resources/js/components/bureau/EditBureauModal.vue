
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
      <b-form-group id="building" label="Building" label-for="building">
        <b-form-select
          v-model="selectedBureau.building"
          :options="building_numbers"
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
          v-model="selectedBureau.office_number"
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
      }

  },
  computed:{
    ...mapGetters(['building_numbers'])
  },
  methods: {
    ...mapActions(["updateBureau"]),
    updateForm(event) {
      event.preventDefault();
      const data = {
        ...this.selectedBureau,
      };
      this.updateBureau(data);
      this.$bvModal.hide("edit-bureau-modal");
    },
  },
};
</script>