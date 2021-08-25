<template>
  <div>
    <!-- @show="resetModal" -->
    <b-modal
      id="edit-faq-modal"
      ref="modal"
      title="Add new FAQ"
      ok-only
      ok-title="Cancel"
      ok-variant="danger"
    >
      <b-form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          label="Question"
          label-for="question-input"
          invalid-feedback="question is required"
        >
          <b-form-input
            v-model="currentFAQ.question"
            id="question-input"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="Answer"
          label-for="answer-input"
          invalid-feedback="required"
        >
          <b-form-textarea
            v-model="currentFAQ.answer"
            id="answer-input"
            required
          ></b-form-textarea>
        </b-form-group>

        <!-- :disabled="!formIsValid" -->
        <b-button class="form-control" type="submit" variant="primary">
          Add
        </b-button>
        <!-- :disabled="!userNameValidation" -->
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: {
    faq: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
    };
    
  },
  computed:{
    currentFAQ(){return this.faq}
  },
  methods: {
    handleSubmit() {
      axios
        .put(`/api/faqs/${this.currentFAQ.id}`, {
          question: this.currentFAQ.question,
          answer: this.currentFAQ.answer,
        })
        .then((resp) => {
          if(resp.data.status==200){
            Swal.fire("Success!", "updated", "success");
            this.$bvModal.hide("edit-faq-modal");
            this.$emit('update_faq',resp.data.faq)
          }
        })
        .catch((err) => console.log("err: ", err));
    },
  },
};
</script>