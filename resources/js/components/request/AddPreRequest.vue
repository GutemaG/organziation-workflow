
<template>
  <b-modal
    id="add-pre-request"
    title="Add pre request"
    ok-only
    ok-title="Cancel"
    ok-variant="danger"
  >
    <form ref="form" @submit.stop.prevent="handleSubmit">
      <base-input
        label="Pre Request Name"
        placeholder="Enter Pre request Name"
        v-model="pre_request.name"
        labelFor="pre-request-name-input"
        id="pre-request-name-input"
        
      >
      </base-input>
      <b-form-group
        label="Pre Request Description"
        class="mb-1 mt-1"
        label-for="pre-request-description-input"
      >
        <b-form-textarea
          rows="3"
          v-model.trim="pre_request.description"
          id="pre-request-description-input"
          placeholder="description for  pre -request(optional)"
        ></b-form-textarea>
      </b-form-group>
      <b-form-group
        id="pre-request-affair"
        label="Select Affair"
        label-for="pre-request-affair-input"
      >
        <b-form-select
          v-model="pre_request.affair_id"
          id="pre-request-affair-input"
          :options="options"
        >
        <b-form-select-option value="" disabled v-if="isNameOrDescriptionNull"> Selecte affair</b-form-select-option>

          <b-form-select-option v-if="!isNameOrDescriptionNull" value="" selected disabled
            >Name and Description must be empty</b-form-select-option
          >
        </b-form-select>
      </b-form-group>
      <b-button class="form-control" type="submit" variant="primary"
        >Add</b-button
      >
    </form>
  </b-modal>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

// TODO: modify using props of selectedUser, to reset
export default {
  props: {
    affair_id: {
      type: Number,
      required: true,
      description: "it used when vuex state is mutate",
    },
    procedure_id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      pre_request: {
        name: "",
        description: "",
        affair_id: "",
      },
    };
  },
  computed: {
    ...mapGetters(["affair_ids"]),
    options() {
      let options = {};
      if (
        this.pre_request.name.length === 0 &&
        this.pre_request.description.length === 0
      ) {
        options = this.affair_ids;
      }
      return options;
    },
    isNameOrDescriptionNull() {
      return (
        this.pre_request.name.length === 0 &&
        this.pre_request.description.length === 0
      );
    },
    isAffairEmpty(){
        return this.pre_request.affair_id === ""
    }
  },
  methods: {
    ...mapActions(["addPreRequest"]),
    handleSubmit(event) {
      event.preventDefault();
      const data = {
        ...this.pre_request,
        selected_affair_id: this.affair_id,
        procedure_id: this.procedure_id,
      };
      this.addPreRequest(data);
      this.$bvModal.hide("add-pre-request");
    },
  },
};
</script>