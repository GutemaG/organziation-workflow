<template>
  <b-modal
    id="login-modal-form"
    title="Login"
    ok-only
    centered
    ok-title="Cancel"
    ok-variant="danger"
    no-close-on-backdrop
    @hide="cancelLogin"
  >
    <form ref="form" @submit.stop.prevent="attemptLogin">
      <b-alert v-if="loggingUserErrorMessage" show variant="danger">{{
        loggingUserErrorMessage
      }}</b-alert>
      <b-form-group label="Email" label-for="email-input">
        <b-form-input
          id="email-input"
          v-model="user.email"
          required
          type="email"
          placeholder="Email address"
        ></b-form-input>
        <b-form-invalid-feedback :state="validation">
          Email is not valid, please enter valide email
        </b-form-invalid-feedback>
      </b-form-group>
      <base-input
        label="Password"
        v-model.trim="user.password"
        labelFor="password-input"
        id="email-input"
        type="password"
        required
      >
      </base-input>
      <b-form-checkbox id="rememberme" v-model="user.remember" name="remeberme">
        Remember Me
      </b-form-checkbox>
      <b-button
        class="form-control"
        type="submit"
        variant="primary"
        :disabled="!isValidLoginForm"
        >Login</b-button
      >
    </form>
  </b-modal>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      user: {
        email: "",
        password: "",
        remember: false,
      },
    };
  },
  computed: {
    ...mapGetters(["loggingUserErrorMessage"]),
    isValidLoginForm() {
      return this.isEmailValid() && this.user.password;
    },
    validation() {
      return this.isEmailValid();
    },
  },
  methods: {
    ...mapActions(["login"]),
    attemptLogin(event) {
      event.preventDefault();
      this.login(this.user);
    },
    cancelLogin() {
      this.user.email = "";
      this.user.password = "";
      this.user.remember = false;
      this.$store.commit("SET_ERROR", "");
    },
    isEmailValid() {
      // let mailFormater = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
      let mailFormater =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
      if (mailFormater.test(this.user.email)) {
        return true;
      }
      return false;
    },
  },
};
// var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
</script>