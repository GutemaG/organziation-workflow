<template>
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
</template>
<script>
export default {
  data() {
    return {
      login: {
        email: "",
        password: "",
        remember: false,
      },
    };
  },
  methods: {
    attemptLogin(event) {
      event.preventDefault();
      axios
        .post("/login", {
          email: this.login.email,
          password: this.login.password,
          remember: this.login.remember,
        })
        .then((resp) => {
            location.reload();
          $("#login-modal-form").modal("hide");
          console.log(resp);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>