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
        label-for="procedure-responsible-bureau-input"
        label="Responsible Bureau"
        invalid-feedback="required"
      >
        <v-select
          v-model="procedure.responsible_bureau_id"
          id="procedure-responsible-bureau-input"
          label="text"
          :options="bureau_ids"
          :reduce="(bureau) => bureau.value"
          placeholder="Select Responsible bureau"
        >
          <template #search="{ attributes, events }">
            <input
              class="vs__search"
              :required="!procedure.responsible_bureau_id"
              v-bind="attributes"
              v-on="events"
            />
          </template>
        </v-select>
      </b-form-group>
      <b-form-group
        id="procedure-step"
        label="Step Number"
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
import { mapActions, mapGetters } from "vuex";

import Vselect from "vue-select";
export default {
  components:{
    'v-select':Vselect
  },
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
        responsible_bureau_id:null
      },
    };
  },
  computed:{
    ...mapGetters(["affair_ids","bureau_ids"]),
  },
  methods: {
    ...mapActions(["addProcedure", "fetchBureaus"]),
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
  mounted(){
    this.fetchBureaus()
  }
};
</script>