<template>
  <div>
    <!-- @show="resetModal" -->
    <b-modal
      id="add-faq-modal"
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
            id="question-input"
            v-model="form.question"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="Answer"
          label-for="answer-input"
          invalid-feedback="required"
        >
          <b-form-textarea
            id="answer-input"
            v-model="form.answer"
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
  name: "add-faq-modal",
  data() {
    return {
      form: {
        question: "",
        answer: "",
      },
    };
  },
  methods: {
    handleSubmit() {
      axios
        .post("/api/faqs", { ...this.form })
        .then((resp) => {
          if(resp.data.status==200){
            this.$emit('add_faq', resp.data.faq)
            Swal.fire("Created!", "Qustion is Created ", "success");
            this.$root.$emit("bv::hide::modal", "add-faq-modal");
          }else{
            console.log('errrr')
          }
        })
        // console.log(resp));
    },
  },
};
</script>