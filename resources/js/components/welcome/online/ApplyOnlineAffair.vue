<template>
  <div class="container">
    <b-form>
      <b-form-group
        id="full-name-input-label"
        label="Full Name"
        label-for="full-name-input"
      >
        <b-form-input
          id="full-name-input"
          placeholder="Enter Your full Name"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="email-address" label="Email" label-for="email-input">
        <b-form-input
          id="email-input"
          type="email"
          placeholder="Enter your Email"
          required
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
          required
        ></b-form-input>
      </b-form-group>
      <b-button type="submit"> Send </b-button>
    </b-form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
// import store from "../../../store";
export default {
  data() {
    return {
      selected: null,
    };
  },
  computed: {
    ...mapGetters(["findRequest"]),
  },
  created() {
    // let req = store.getters.findRequest(this.$route.params.slug);
    this.selected = this.findRequest(this.$route.params.slug);
    // this.selected = result;
  },
};
</script>