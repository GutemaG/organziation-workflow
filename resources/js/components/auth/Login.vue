<template>
  <!--
  <div class="modal fade" tabindex="-1" id="login-modal-form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Login</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.stop.prevent="attemptLogin">
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right"
                >E-Mail Address</label
              >

              <div class="col-md-6">
                <input
                  id="email"
                  type="email"
                  class="form-control"
                  name="email"
                  required
                  autocomplete="email"
                  autofocus
                  v-model="login.email"
                />
              </div>
            </div>

            <div class="form-group row">
              <label
                for="password"
                class="col-md-4 col-form-label text-md-right"
                >Password</label
              >

              <div class="col-md-6">
                <input
                  id="password"
                  type="password"
                  class="form-control"
                  name="password"
                  required
                  autocomplete="current-password"
                  v-model="login.password"
                />
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    id="remember"
                    v-model="login.remember"
                  />

                  <label class="form-check-label" for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
            </div>

            <button type="submit" class="form-control btn btn-primary">
              Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  -->
  <b-modal
    id="login-modal-form"
    title="Login"
    ok-only
    ok-title="Cancel"
    ok-variant="danger"
    no-close-on-backdrop
    @hide="cancelLogin"
  >
    <form ref="form" @submit.stop.prevent="attemptLogin">
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
      <b-form-checkbox
        id="rememberme"
        v-model="user.remember"
        name="remeberme"
      >
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
import { mapActions } from 'vuex';
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
    isValidLoginForm() {
      return this.isEmailValid() && this.user.password;
    },
    validation(){
      return this.isEmailValid();
    }
  },
  methods: {
    ...mapActions(['login']),
    attemptLogin(event) {
      event.preventDefault();
      this.login(this.user)
    },
    cancelLogin() {
      this.user.email = "";
      this.user.password = "";
      this.user.remember = false;
    },
    isEmailValid(){
      // let mailFormater = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
      let mailFormater = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
      if(mailFormater.test(this.user.email)){
        return true
      }
      return false
    }
  },
};
// var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
</script>