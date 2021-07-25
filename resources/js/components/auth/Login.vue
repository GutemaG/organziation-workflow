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
      <b-alert v-if="!!error" show variant="danger">{{ error }}</b-alert>
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
      <!-- <base-input
        label="Password"
        v-model.trim="user.password"
        labelFor="password-input"
        id="email-input"
        type="password"
        required
      >
      </base-input> -->
      <b-form-group label="Password" label-for="password-input">
        <b-input-group>
          <b-form-input
            id="email-input"
            :type="showPassword?'text':'password'"
            required
            v-model="user.password"
          ></b-form-input>
          <b-input-group-append>
            <b-button @click="showPassword=!showPassword" variant="light">
              <i v-show="!showPassword" class="far fa-eye" id="show"></i>
              <i v-show="showPassword" class="far fa-eye-slash" id="show"></i>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form-group>
      <b-form-checkbox id="rememberme" v-model="user.remember" name="remeberme">
        Remember Me
      </b-form-checkbox>
      <b-button
        class="form-control"
        type="submit"
        variant="primary"
        :disabled="!isValidLoginForm || isLoading"
      >
        <span v-if="!isLoading">Login</span>
        <b-spinner v-show="isLoading" label="Loading..."></b-spinner>
      </b-button>
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
      error: null,
      isLoading: false,
      showPassword:false
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
    async attemptLogin(event) {
      event.preventDefault();
      let user = this.user;
      this.isLoading = true;
      try {
        await this.login(user);
        $("#login-modal-form").modal("hide");
        window.location.replace("/dashboard");
      } catch (err) {
        this.error = err.message || "Failed to authenticate";
      }
      this.isLoading = false;
    },
    cancelLogin() {
      this.user.email = "";
      this.user.password = "";
      this.user.remember = false;
      this.isLoading = false;
      this.error = null;
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