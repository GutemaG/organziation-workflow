<template>
  <div>
    <!-- <guest-nav-bar></guest-nav-bar> -->
    <b-container class="mt-5">
      <b-row>
        <b-col> </b-col>
        <b-col cols="8" class="mt-2">
          <form ref="form" @submit.stop.prevent="attemptLogin">
            <b-alert v-if="loggingUserErrorMessage" show variant="danger">{{
              loggingUserErrorMessage
            }}</b-alert>
            <b-alert v-if="!!error" show variant="danger">{{ error }}</b-alert>
            <b-form-group
              :label="tr('Email')"
              label-for="email-input"
              :invalid-feedback="
                !$v.form.email.required
                  ? 'Required'
                  : 'Email is not valid, please enter valide email'
              "
            >
              <b-input-group>
                <b-input-group-append>
                  <b-button>
                    <i class="fas fa-at"></i>
                    <!-- <i class="far fa-user"></i> -->
                  </b-button>
                </b-input-group-append>
                <b-form-input
                  id="email-input"
                  v-model="$v.form.email.$model"
                  required
                  type="email"
                  :state="validateState('email')"
                  placeholder="Email address"
                ></b-form-input>
              </b-input-group>
            </b-form-group>

            <b-form-group :label="tr('Password')" label-for="password-input">
              <b-input-group>
              <b-input-group-append>
                <b-button>
                  <i class="fas fa-key"></i>
                  <!-- <i class="far fa-user"></i> -->
                </b-button>
              </b-input-group-append>
                <b-form-input
                  id="password-input"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  :state="validateState('password')"
                  v-model="$v.form.password.$model"
                ></b-form-input>
                <b-input-group-append class="ml-1">
                  <b-button
                    @click="showPassword = !showPassword"
                    variant="light"
                  >
                    <i v-show="!showPassword" class="far fa-eye" id="show"></i>
                    <i
                      v-show="showPassword"
                      class="far fa-eye-slash"
                      id="show"
                    ></i>
                  </b-button>
                </b-input-group-append>
                <b-form-invalid-feedback>{{
                  tr("Required")
                }}</b-form-invalid-feedback>
              </b-input-group>
            </b-form-group>
            <b-form-checkbox
              id="rememberme"
              v-model="form.remember"
              name="remeberme"
            >
              {{ tr("Remember me") }}
            </b-form-checkbox>
              <!-- class="form-control" -->
            <b-button
              type="submit"
              variant="primary"
              :disabled="$v.$invalid || isLoading"
            >
              <span v-if="!isLoading">{{ tr("Login") }}</span>
              <b-spinner v-show="isLoading" label="Loading..."></b-spinner>
            </b-button>
          </form>
        </b-col>
        <b-col> </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import { required, email } from "vuelidate/lib/validators";
import GuestNavBar from "../include/GuestNavBar.vue";
export default {
  components: { GuestNavBar },
  name: "LoginPage",
  data() {
    return {
      form: {
        email: "",
        password: "",
        remember: false,
      },
      error: null,
      isLoading: false,
      showPassword: false,
    };
  },
  computed: {
    ...mapGetters(["loggingUserErrorMessage"]),
    isValidLoginForm() {
      return this.isEmailValid() && this.form.password;
    },
    validation() {
      return this.isEmailValid();
    },
  },
  methods: {
    ...mapActions(["login"]),
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    async attemptLogin(event) {
      event.preventDefault();
      let form = this.form;
      this.isLoading = true;
      try {
        await this.login(form);
        $("#login-modal-form").modal("hide");
        window.location.replace("/dashboard");
      } catch (err) {
        this.error = err.message || "Failed to authenticate";
      }
      this.isLoading = false;
    },
    cancelLogin() {
      this.form.email = "";
      this.form.password = "";
      this.form.remember = false;
      this.isLoading = false;
      this.error = null;
      this.$store.commit("SET_ERROR", "");
    },
    isEmailValid() {
      // let mailFormater = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
      let mailFormater =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
      if (mailFormater.test(this.form.email)) {
        return true;
      }
      return false;
    },
  },
  validations: {
    form: {
      email: {
        required,
        email,
      },
      password: {
        required,
      },
    },
  },
};
// var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
</script>