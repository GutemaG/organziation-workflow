<template>
  <div>
    <body class="login-page" style="min-height: 296px; background: none;">
      <div class="login-box" style="width:460px" fluid>
        <!-- /.login-logo -->
        <div class="card card-outline card-primary" style="border-radius: 2rem; border-top-width: 9px;">
          <div class="card-header text-center" style="border-radius: 2rem 2rem 0 0;">
            <h1><b>Login</b></h1>
          </div>
          <div class="card-body" style="padding: 2.66rem;">
            <p class="login-box-msg">Sign in to your account</p>

            <form ref="form" @submit.stop.prevent="attemptLogin">
              <b-alert v-if="loggingUserErrorMessage" class="mb-4 mt-1" show variant="danger">{{loggingUserErrorMessage}}</b-alert>
              <b-alert v-if="!!error" class="text-center " style="border-radius: 1.25rem;" show variant="danger">{{ error }}</b-alert>
              <div :label="tr('Email:')" 
              label-for="email-input"
              :invalid-feedback="
                !$v.form.email.required
                  ? 'Required'
                  : 'Email is not valid, please enter valide email' "
              class="input-group mb-3">
                <input id="email-input"
                v-model="$v.form.email.$model" 
                required
                type="email" 
                :state="validateState('email')"
                placeholder="Email address"
                class="form-control">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3"
              :label="tr('Password: ')" 
              label-for="password-input">
                <input id="password-input"
                :type="showPassword ? 'text' : 'password'"
                required
                :state="validateState('password')"
                v-model="$v.form.password.$model"
                class="form-control" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <b-link @click="showPassword = !showPassword" 
                    style="color: black;">
                      <i v-show="!showPassword" class="far fa-eye-slash" id="hide"></i>
                      <i v-show="showPassword" class="far fa-eye" id="show"></i>
                    </b-link>
                    <span class="fas fa-lock ml-3"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="rememberme"
                    v-model="form.remember"
                    name="remeberme">
                    <label for="remember">
                      {{ tr("Remember me") }}
                    </label>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <div>
                <b-button class="mt-4 mb-3"
                type="submit"
                variant="primary"
                block
                pill
                :disabled="$v.$invalid || isLoading">
                  <span v-if="!isLoading">{{ tr("Login") }}</span>
                  <b-spinner v-show="isLoading" label="Loading..."></b-spinner>
                </b-button>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </body>
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
</script>