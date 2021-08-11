<template>
  <div>
    <!-- <guest-nav-bar></guest-nav-bar> -->
    <b-container style="padding-top: 85px;">
      <b-row class="justify-content-md-center">
        <b-col cols="8">
          <b-card
            header="Login"
            header-class="scale-3"
            class=""
            shadow shadow-lg--hover
            style="border-radius: 1.25rem; border: 3px solid rgba(0, 0, 0, 0.125);"
            header-tag="header"
          >
            <b-form class="d-grid" ref="form" @submit.stop.prevent="attemptLogin">
              <b-alert v-if="loggingUserErrorMessage" class="mb-4 mt-1" show variant="danger">{{
                loggingUserErrorMessage
              }}</b-alert>
              <b-alert v-if="!!error" class="text-center " style="border-radius: 1.25rem;" show variant="danger">{{ error }}</b-alert>
              <b-form-group
                :label="tr('Email:')"
                class="mt-3"
                style="display: flex;
                  justify-content: center;
                  align-items: baseline;
                  width: 100%;"
                label-for="email-input"
                :invalid-feedback="
                  !$v.form.email.required
                    ? 'Required'
                    : 'Email is not valid, please enter valide email'
                "
              >
                <b-input-group>
                  <b-input-group-prepend is-text style="margin-left: 3.3rem">
                    @
                  </b-input-group-prepend>
                  <b-form-input
                    id="email-input"
                    v-model="$v.form.email.$model"
                    required
                    type="email"
                    style="width: 100%; inline-size: auto"
                    :state="validateState('email')"
                    placeholder="Email address"
                  ></b-form-input>
                </b-input-group>
              </b-form-group>

              <b-form-group :label="tr('Password: ')" 
              class="mt-3"
              style="display: flex;
                justify-content: center;
                align-items: baseline;
                width: 100%;"
              label-for="password-input">
                <b-input-group>
                  <b-input-group-prepend is-text class="ml-4">
                    <b-icon icon="key"></b-icon>
                  </b-input-group-prepend>
                  
                  <b-form-input
                    id="password-input"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    style=""
                    :state="validateState('password')"
                    v-model="$v.form.password.$model"
                  >
                  </b-form-input>

                  <b-input-group-append class="" 
                  style="padding: 8px;
                    z-index: 111;
                    position: absolute;
                    margin-left: 14.1rem;"
                  >
                    <b-link
                      @click="showPassword = !showPassword"
                      style="color: black;"
                    >
                      <i v-show="!showPassword" class="far fa-eye-slash" id="show"></i>
                      <i
                        v-show="showPassword"
                        class="far fa-eye"
                        id="show"
                      ></i>
                    </b-link>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>

              <b-form-group 
              class="mt-3"
              style="display: flex; justify-content: center; align-items: baseline;">
                <b-input-group>
                  <b-form-checkbox
                    id="rememberme"
                    v-model="form.remember"
                    class="mt-2"
                    name="remeberme"
                  >
                    {{ tr("Remember me") }}
                  </b-form-checkbox>
                    <!-- class="form-control" -->
                  <b-button
                    class="mt-4 mb-3"
                    type="submit"
                    variant="primary"
                    block
                    :disabled="$v.$invalid || isLoading"
                  >
                    <span v-if="!isLoading">{{ tr("Login") }}</span>
                    <b-spinner v-show="isLoading" label="Loading..."></b-spinner>
                  </b-button>
                </b-input-group>
              </b-form-group>
            </b-form>
          </b-card>
        </b-col>
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