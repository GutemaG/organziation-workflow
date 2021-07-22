<template>
  <b-modal
    id="add-procedure"
    title="Add Procedure"
    ok-only
    ok-title="Cancel"
    ok-variant="danger"
  >
    <form ref="form" @submit.stop.prevent="handleSubmit">
      <b-form-group
        id="procedure-name"
        label="Procedure Name"
        label-for="procedure-name-input"
      >
        <b-form-input
          id="procedure-name-input"
          v-model="procedure.name"
          placeholder="Procedure Name"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        id="procedure-step"
        label="First Name"
        label-for="procedure-step-input"
      >
        <b-form-input
        type="number"
          id="procedure-step-input"
          v-model="procedure.step"
          placeholder="Enter step Number"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        label="Procedure Description"
        label-for="procedure-description-input"
      >
        <b-form-textarea
          rows="3"
          v-model="procedure.description"
          id="procedure-description-input"
          placeholder="description for procedure(optional)"
        ></b-form-textarea>
      </b-form-group>

      <b-button class="form-control" type="submit" variant="primary"
        >Add</b-button
      >
    </form>
  </b-modal>
</template>
<script>
import { mapActions } from "vuex";

export default {
  props: {
    affair_id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      procedure: {
        name: "",
        description: "",
        step: "",
      },
    };
  },
  methods: {
    ...mapActions(["addProcedure"]),
    handleSubmit(event) {
      event.preventDefault();
      console.log(this.affair_id);
      const data = {
        ...this.procedure,
        affair_id: this.affair_id,
      };
      this.addProcedure(data);
      this.$bvModal.hide("add-procedure");
    },
  },
};
</script>