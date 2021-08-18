<template>
  <div>
    <div class="container-fluid">
      <b-row>
        <b-col cols="" class="text-center d-flex justify-content-md-center">
          <div class="card" style="width: 50%; padding: 2rem;">
            <div style="display: flex; justify-content: flex-end;">
              <b-dropdown
                id="dropdown-right"
                right
                text="Edit"
                variant="primary"
                class="edit_button"
              >
                <b-dropdown-item v-b-modal.edit-account-modal
                  >Edit Profile</b-dropdown-item
                >
                <b-dropdown-item v-b-modal.change-password-modal
                  >Change Password</b-dropdown-item
                >
              </b-dropdown>
            </div>

            <div>
              <b-img
                src="/images/user.png"
                fluid
                rounded="circle"
                class="img-right shadow shadow-lg--hover mb-4"
                style="width: 15rem"
              />
            </div>
            <h5 class="h3 title">
              <small class="h4 font-weight-light text-muted">{{
                userProfile.user_name
              }}</small>
              <span class="d-block mb-1"
                >{{ userProfile.first_name }} {{ userProfile.last_name }}</span
              >
            </h5>
            <b-list-group class="text-left" flush>
              <b-list-group-item
                ><b>First Name: </b
                >{{ userProfile.first_name }}</b-list-group-item
              >
              <b-list-group-item
                ><b>Last Name: </b
                >{{ userProfile.last_name }}</b-list-group-item
              >
              <b-list-group-item
                ><b>Email: </b>{{ userProfile.email }}</b-list-group-item
              >
              <b-list-group-item
                ><b>Phone Number: </b>{{ userProfile.phone }}</b-list-group-item
              >
            </b-list-group>
            <div>
              <b-modal
                id="edit-account-modal"
                centered
                ref="modal"
                title="Edit Account"
                ok-only
                ok-variant="secondary"
                ok-title="Cancel"
                @hide="updateUser"
              >
                <form ref="form" @submit.prevent="editProfile">
                  <b-form-group
                    label="First Name"
                    label-for="first_name"
                    class="form-group"
                  >
                    <b-form-input
                      type="text"
                      placeholder="Enter first name"
                      v-model="userProfile.first_name"
                      id="first_name"
                      name="first_name"
                      class="form-control"
                      :class="{
                        'is-invalid':
                          profileSubmitted && $v.userProfile.first_name.$error,
                        'is-valid': !$v.userProfile.first_name.$invalid,
                      }"
                    >
                    </b-form-input>

                    <!-- Displays Error Message for First name input -->
                    <div class="valid-feedback">Your first name is valid!</div>
                    <div class="invalid-feedback">
                      <span
                        v-if="
                          profileSubmitted &&
                          !$v.userProfile.first_name.required
                        "
                        >First name is required.</span
                      >
                      <span
                        v-if="
                          profileSubmitted &&
                          !$v.userProfile.first_name.minLength
                        "
                        >First name must have at least
                        {{
                          $v.userProfile.first_name.$params.minLength.min
                        }}
                        letters</span
                      >
                      <span
                        v-if="
                          profileSubmitted &&
                          !$v.userProfile.first_name.maxLength
                        "
                        >First name must have at most
                        {{
                          $v.userProfile.first_name.$params.maxLength.max
                        }}
                        letters.</span
                      >
                    </div>
                  </b-form-group>

                  <b-form-group
                    label="Last Name"
                    label-for="last_name"
                    class="form-group"
                  >
                    <b-form-input
                      type="text"
                      placeholder="Enter last name"
                      v-model="userProfile.last_name"
                      id="last_name"
                      name="last_name"
                      class="form-control"
                      :class="{
                        'is-invalid':
                          profileSubmitted && $v.userProfile.last_name.$error,
                        'is-valid': !$v.userProfile.last_name.$invalid,
                      }"
                    >
                    </b-form-input>

                    <!-- Displays Error Message for Last name input -->
                    <div class="valid-feedback">Your last name is valid!</div>
                    <div class="invalid-feedback">
                      <span
                        v-if="
                          profileSubmitted && !$v.userProfile.last_name.required
                        "
                        >Last name is required.</span
                      >
                      <span
                        v-if="
                          profileSubmitted &&
                          !$v.userProfile.last_name.minLength
                        "
                        >Last name must have at least
                        {{
                          $v.userProfile.last_name.$params.minLength.min
                        }}
                        letters</span
                      >
                      <span
                        v-if="
                          profileSubmitted &&
                          !$v.userProfile.last_name.maxLength
                        "
                        >Last name must have at most
                        {{
                          $v.userProfile.last_name.$params.maxLength.max
                        }}
                        letters.</span
                      >
                    </div>
                  </b-form-group>

                  <b-form-group
                    label="Email"
                    label-for="email"
                    class="form-group"
                  >
                    <b-form-input
                      type="text"
                      placeholder="Enter email"
                      v-model="userProfile.email"
                      id="email"
                      name="email"
                      class="form-control"
                      :class="{
                        'is-invalid':
                          profileSubmitted && $v.userProfile.email.$error,
                        'is-valid': !$v.userProfile.email.$invalid,
                      }"
                    >
                    </b-form-input>

                    <!-- Displays Error Message for Email input -->
                    <div class="valid-feedback">Your email is valid!</div>
                    <div class="invalid-feedback">
                      <span
                        v-if="
                          profileSubmitted && !$v.userProfile.email.required
                        "
                        >Email required.</span
                      >
                      <span
                        v-if="
                          profileSubmitted && !$v.userProfile.email.isUnique
                        "
                        >Invalid email.</span
                      >
                    </div>
                  </b-form-group>

                  <b-form-group
                    label="Phone number"
                    label-for="phone"
                    class="form-group"
                  >
                    <b-form-input
                      type="text"
                      placeholder="Enter phone number"
                      v-model="userProfile.phone"
                      id="phone"
                      name="phone"
                      class="form-control"
                      :class="{
                        'is-invalid':
                          profileSubmitted && $v.userProfile.phone.$error,
                        'is-valid': !$v.userProfile.phone.$invalid,
                      }"
                    >
                    </b-form-input>

                    <!-- Displays Error Message for First name input -->
                    <div class="valid-feedback">
                      Your phone number is valid!
                    </div>
                    <div class="invalid-feedback">
                      <span
                        v-if="
                          profileSubmitted && !$v.userProfile.phone.required
                        "
                        >First name is required.</span
                      >
                      <span
                        v-if="
                          profileSubmitted && !$v.userProfile.phone.minLength
                        "
                        >First name must have at least
                        {{
                          $v.userProfile.phone.$params.minLength.min
                        }}
                        letters</span
                      >
                      <span
                        v-if="
                          profileSubmitted && !$v.userProfile.phone.maxLength
                        "
                        >First name must have at most
                        {{
                          $v.userProfile.phone.$params.maxLength.max
                        }}
                        letters.</span
                      >
                    </div>
                  </b-form-group>

                  <div class="form-group">
                    <b-button pill block class="submitButton">Submit</b-button>
                  </div>
                </form>
              </b-modal>
            </div>

            <div>
              <b-modal
                id="change-password-modal"
                centered
                ref="modal"
                title="Change Password"
                body-class="p-4"
                ok-only
                ok-variant="secondary"
                ok-title="Cancel"
                @hide="updateUser"
              >
                <form ref="form" @submit.prevent="changePassword">
                  <b-form-group
                    label="Current Password"
                    label-for="current-password-input"
                    class="form-group"
                  >
                    <b-input-group>

                      <b-form-input
                        :type="currentPasswordVisibility"
                        v-model="userPassword.current_password"
                        id="currentPassword"
                        name="currentPassword"
                        class="form-control"
                        :class="{
                          'is-invalid':
                            passwordChange &&
                            $v.userPassword.current_password.$error,
                          'is-valid': !$v.userPassword.current_password.$invalid,
                        }"
                      >
                      </b-form-input>

                      <!-- Show and Hide password -->
                        <b-input-group-append style="padding: 7px; z-index: 111; position: absolute; margin-left: 24rem;"
                        >
                          <b-link
                            @click="showPassword = !showPassword"
                            style="color: black;"
                          >
                            <i @click="showCurrentPassword()" v-if="currentPasswordVisibility == 'password'" class="far fa-eye-slash" id="hide"></i>
                            <i @click="hideCurrentPassword()" v-if="currentPasswordVisibility == 'text'" class="far fa-eye" id="show"></i>
                          </b-link>
                        </b-input-group-append>

                      <!-- Displays Error Message for Password input -->
                      <div class="valid-feedback"></div>
                      <div
                        v-if="
                          passwordChange &&
                          $v.userPassword.current_password.$error
                        "
                        class="invalid-feedback"
                      >
                        <span v-if="!$v.userPassword.current_password.required"
                          >Current password is required.</span
                        >
                        <span
                          v-if="
                            !$v.userPassword.current_password.minLength &&
                            passwordError.length != 0
                          "
                          >{{ passwordError }} Please enter again!</span
                        >
                      </div>
                    </b-input-group>
                  </b-form-group>

                  <b-form-group
                    label="New Password"
                    label-for="new-password-input"
                    class="form-group">

                    <b-input-group>
                      <b-form-input
                        :type="newPasswordVisibility"
                        v-model="userPassword.password"
                        id="newPassowrd"
                        name="newPassword"
                        class="form-control"
                        :class="{ 'is-invalid': passwordChange && $v.userPassword.password.$error,
                        'is-valid': !$v.userPassword.password.$invalid,}"
                      ></b-form-input>

                      <!-- Show and Hide password -->
                      <b-input-group-append style="padding: 7px; z-index: 111; position: absolute; margin-left: 24rem;"
                      >
                        <b-link
                          @click="showPassword = !showPassword"
                          style="color: black;"
                        >
                          <i @click="showNewPassword()" v-if="newPasswordVisibility == 'password'" class="far fa-eye-slash" id="hide"></i>
                          <i @click="hideNewPassword()" v-if="newPasswordVisibility == 'text'" class="far fa-eye" id="show"></i>
                        </b-link>
                      </b-input-group-append>

                      <!-- Displays Error Message for Password input -->
                      <div class="valid-feedback">New password is valid!</div>
                      <div v-if="passwordChange && $v.userPassword.password.$error" class="invalid-feedback">
                        <span v-if="!$v.userPassword.password.required">
                          New password is required.
                        </span>
                        <span v-if="!$v.userPassword.password.minLength">
                          New password must be at least 8 characters.
                        </span>
                      </div>
                    </b-input-group>
                  </b-form-group>

                  <b-form-group
                    label="Confirm Password"
                    label-for="confirm-password-input"
                    class="form-group">

                    <b-input-group>
                      <b-form-input
                        :type="confirmationPasswordVisibility"
                        v-model="userPassword.password_confirmation"
                        id="passwordConfirmation"
                        name="passwordConfirmation"
                        class="form-control"
                        :class="{ 'is-invalid': passwordChange && $v.userPassword.password_confirmation.$error, 'is-valid':
                        !$v.userPassword.password_confirmation.$invalid,}">
                      </b-form-input>

                      <!-- Show and Hide password -->
                      <b-input-group-append style="padding: 7px; z-index: 111; position: absolute; margin-left: 24rem;"
                      >
                        <b-link
                          @click="showPassword = !showPassword"
                          style="color: black;"
                        >
                          <i @click="showConfirmationPassword()" v-if="confirmationPasswordVisibility == 'password'" class="far fa-eye-slash" id="hide"></i>
                          <i @click="hideConfirmationPassword()" v-if="confirmationPasswordVisibility == 'text'" class="far fa-eye" id="show"></i>
                        </b-link>
                      </b-input-group-append>

                      <!-- Displays Error Message for Password input -->
                      <div class="valid-feedback">
                        Confirmation password match!
                      </div>
                      <div v-if="passwordChange && $v.userPassword.password_confirmation.$error" class="invalid-feedback">
                        <span v-if="!$v.userPassword.password_confirmation.required">
                          Confirmation password is required.
                        </span>
                        <span v-else-if=" !$v.userPassword.password_confirmation.sameAsPassword">
                          Confirmation password does not match.
                        </span>
                      </div>
                    </b-input-group>
                  </b-form-group>

                  <div class="form-group">
                    <b-button pill block class="submitButton">Submit</b-button>
                  </div>
                </form>
              </b-modal>
            </div>
          </div>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import {
  required,
  requiredIf,
  minLength,
  maxLength,
  email,
  sameAs,
} from "vuelidate/lib/validators";

export default {
  data() {
    return {
      userProfile: {
        user_name: "",
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
      },
      userPassword: {
        current_password: "",
        password: "",
        password_confirmation: "",
      },
      profileSubmitted: false,
      passwordChange: false,
      passwordError: "",
      currentPasswordVisibility: "password",
      newPasswordVisibility: "password",
      confirmationPasswordVisibility: "password",
    };
  },
  validations: {
    userProfile: {
      first_name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(10),
      },
      last_name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(10),
      },
      email: {
        required,
        email,
        isUnique(value) {
          if (value === "") return true;

          //eslint-disable-next-line
          var email_regex =
            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return new Promise((resolve) => {
            setTimeout(() => {
              resolve(email_regex.test(value));
            }, 350 + Math.random() * 300);
          });
        },
      },
      phone: {
        required,
        minLength: minLength(13),
        maxLength: maxLength(13),
      },
    },
    userPassword: {
      current_password: {
        required,
        minLength: minLength(8),
      },
      password: {
        required,
        minLength: minLength(8),
      },
      password_confirmation: {
        required,
        sameAsPassword: sameAs("password"),
      },
    },
  },
  methods: {
    editProfile(e) {
      e.preventDefault();
      this.profileSubmitted = true;

      // stop here if form is invalid
      this.$v.userProfile.$touch();
      if (this.$v.userProfile.$invalid) {
        Swal.fire("I am not understanding you!!", "", "error");
        return;
      }

      axios
        .post("/api/account", { ...this.userProfile })
        .then((resp) => {
          Swal.fire("Profile successfully updated!", "", "success");
          console.log(resp.data);
          let user = resp.data.user;
          window.user = user;
          this.setUser(user);
        })
        .catch((error) => console.log(error));
    },
    setUser(loggedInUser) {
      this.userProfile.id = loggedInUser.id;
      this.userProfile.user_name = loggedInUser.user_name;
      this.userProfile.first_name = loggedInUser.first_name;
      this.userProfile.last_name = loggedInUser.last_name;
      this.userProfile.email = loggedInUser.email;
      this.userProfile.phone = loggedInUser.phone;
      this.userProfile.user_name = loggedInUser.user_name;
    },
    changePassword(e) {
      e.preventDefault();
      this.passwordChange = true;

      // stop here if form is invalid
      this.$v.userPassword.$touch();
      if (this.$v.userPassword.$invalid) {
        return;
      }

      axios
        .post("/api/account/change-password", { ...this.userPassword })
        .then((resp) => {
          console.log(resp.data);
          let error = resp.data["error"];
          let er = error["current_password"][0];
          Swal.fire("Error!", er, "error");
          this.passwordError = er;
        })
        .catch((error) => console.log(error));
    },
    showCurrentPassword() {
      this.currentPasswordVisibility = "text";
    },
    hideCurrentPassword() {
      this.currentPasswordVisibility = "password";
    },
    showNewPassword() {
      this.newPasswordVisibility = "text";
    },
    hideNewPassword() {
      this.newPasswordVisibility = "password";
    },
    showConfirmationPassword() {
      this.confirmationPasswordVisibility = "text";
    },
    hideConfirmationPassword() {
      this.confirmationPasswordVisibility = "password";
    },
    updateUser() {
      this.userProfile.user_name = window.user.user_name;
      this.userProfile.first_name = window.user.first_name;
      this.userProfile.last_name = window.user.last_name;
      this.userProfile.email = window.user.email;
      this.userProfile.phone = window.user.phone;
    },
  },
  created() {
    let loggeduser = window.user;
    this.setUser(loggeduser);
  },
};
</script>


<style scoped>
.content {
  margin-left: 25%;
  max-width: 40%;
  max-height: auto;
  font-size: 16px;
}
.row {
  margin: 0;
}
.edit_button {
  border-radius: 0.25rem;
}
.submitButton {
  background-color: #227dc7;
  border: 2px solid #2176bd;
  border-radius: 4px;
  color: #fff;
  display: block;
  font-family: inherit;
  font-size: 16px;
  padding: 10px;
  width: 100%;
}
</style>