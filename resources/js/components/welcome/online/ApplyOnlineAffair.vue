<template>
  <div class="container">
    <b-form @submit.prevent="handleSubmit">
      <b-form-group
        id="full-name-input-label"
        label="Full Name"
        label-for="full-name-input"
      >
        <b-form-input
          id="full-name-input"
          placeholder="Enter Your full Name"
          v-model="$v.form.full_name.$model"
          :state="validateState('full_name')"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="email-address" label="Email" label-for="email-input">
        <b-form-input
          id="email-input"
          type="email"
          placeholder="Enter your Email"
          v-model="$v.form.email.$model"
          :state="validateState('email')"
        ></b-form-input>
      </b-form-group>
      <b-form-group
        id="phone-number-label"
        label="Phone number"
        label-for="phone-number-input"
      >
        <b-form-input
          id="phone-number-input"
          placeholder="Enter your phone number +2519.. or 09..."
          v-model="$v.form.phone_number.$model"
          :state="validateState('phone_number')"
          required
        ></b-form-input>
      </b-form-group>
      <b-button type="submit"> Send </b-button>
    </b-form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { required } from "vuelidate/lib/validators";
// import store from "../../../store";
export default {
  data() {
    return {
      selected: null,
      form: {
        full_name: "",
        email: "",
        phone_number: "",
      },
      token: "",
    };
  },
  computed: {
    ...mapGetters(["findRequest"]),
  },
  methods: {
    validateState(value) {
      // return true
      const { $dirty, $error } = this.$v.form[value];
      return $dirty ? !$error : null;
    },
    handleSubmit() {
      axios
        .post("/api/apply-request", {
          ...this.form,
          online_request_id: this.selected.id,
        })
        .then((resp) => {
          if (resp.data.status == 200) {
            this.$store.dispatch("setToken", resp.data.token);
            this.$router.go(-1);
          }
        });
    },
  },
  created() {
    // let req = store.getters.findRequest(this.$route.params.slug);
    this.selected = this.findRequest(this.$route.params.slug);
    // this.selected = result;
  },
  validations: {
    form: {
      full_name: {
        required,
      },
      email: {
        required,
      },
      phone_number: {
        name: required,
      },
    },
  },
};
</script>