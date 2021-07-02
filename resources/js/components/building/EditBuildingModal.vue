
<template>
  <b-modal
    id="edit-building-modal"
    title="Edit"
    ok-only
    ok-title="Cancel"
    ok-variant="danger"
  >
    <form ref="form" @submit.stop.prevent="updateForm">
      <b-form-group label="Name" label-for="building-name-input">
        <b-form-input
          id="building-name-input"
          v-model="selectedBuilding.name"
          placeholder="You can leave it"
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Building Number" label-for="building-number-input">
        <b-form-input
          id="building-number-input"
          v-model="selectedBuilding.number"
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
          v-model="selectedBuilding.number_of_offices"
          id="input-number-of-offices"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group
        id="description"
        label="Description"
        label-for="Building-description"
      >
        <b-form-textarea
          v-model="selectedBuilding.description"
          id="input-description"
          placeholder="You can leave it"
        >
        </b-form-textarea>
      </b-form-group>
      <b-button class="form-control" type="submit" variant="primary"
        >Update</b-button
      >
    </form>
  </b-modal>
</template>
<script>
import { mapActions } from "vuex";

// TODO: modify using props of selectedUser, to reset
export default {
  props: {
    selectedBuilding: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      
    };
  },
  methods: {
    ...mapActions(["updateBuilding"]),
    updateForm(event) {
      event.preventDefault();
      const data = {
        ...this.selectedBuilding,
      };
      this.updateBuilding(data);
      this.$bvModal.hide("edit-building-modal");
    },
  },
};
</script>