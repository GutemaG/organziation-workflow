<template>
  <div>
    <b-modal
      id="add-user-modal"
      ref="modal"
      title="Add New IT Team"
      @show="resetModal"
      ok-only
      ok-title="Cancel"
      ok-variant="danger"
    >
      <!-- TODO: Validate the input before sending -->
      <b-form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          label="Username"
          label-for="username"
          :invalid-feedback="
            !$v.form.user_name.isUnique
              ? 'User name already exist'
              : 'User Name is Reqired'
          "
        >
          <b-form-input
            id="username-input"
            v-model="$v.form.user_name.$model"
            :state="validateState('user_name')"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="First Name"
          label-for="name-input"
          invalid-feedback="Name is required"
        >
          <b-form-input
            id="first-name-input"
            v-model="form.first_name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="Last Name"
          label-for="name-input"
          invalid-feedback="required"
        >
          <b-form-input
            id="last-name-input"
            v-model="form.last_name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="phone number"
          label-for="phone number"
          :invalid-feedback="
            !$v.form.phone.isUnique
              ? 'phone number name already exist'
              : 'Phone number is required'
          "
        >
          <b-form-input
            id="phone number"
            v-model="$v.form.phone.$model"
            :state="validateState('phone')"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="email-address"
          label="Email address:"
          label-for="email-address"
          invalid-feedback="email is taken"
        >
          <!-- invalid-feedback="required" -->
          <b-form-input
            id="email-address"
            v-model="$v.form.email.$model"
            :state="validateState('email')"
            type="email"
            placeholder="Enter email"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="user-type"
          label="* User Type"
          label-for="user-type"
          invalid-feedback="Select user Type"
        >
          <b-form-select
            v-model="$v.form.type.$model"
            :options="userType"
            id="user-type"
            :state="validateState('type')"
            required
          >
            <b-form-select-option value="" disabled
              >Please select user type</b-form-select-option
            >
          </b-form-select>
        </b-form-group>
        <b-form-group
          id="password"
          label="Password"
          label-for="password"
          invalid-feedback="required"
        >
          <b-form-input
            id="password"
            v-model="form.password"
            type="password"
            placeholder="Enter password for the IT team"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="password_confirmation"
          label="Password"
          label-for="Confirm Password"
          invalid-feedback="Password does not match!"
        >
          <b-form-input
            id="password_confirmation"
            v-model="$v.form.password_confirmation.$model"
            :state="validateState('password_confirmation')"
            type="password"
            placeholder="Enter password for the IT team"
            required
          ></b-form-input>
        </b-form-group>
        <b-button
          class="form-control"
          :disabled="!formIsValid"
          type="submit"
          variant="primary"
        >
          Add
        </b-button>
        <!-- :disabled="!userNameValidation" -->
      </b-form>
    </b-modal>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

// import { validationMixin } from "vuelidate";
import { required, minLength, sameAs } from "vuelidate/lib/validators";

export default {
  // mixins: [validationMixin],
  data() {
    return {
      selected: [], // Must be an array reference!

      all_permissions: true,
      //TODO: do something tmorrow
      form: {
        user_name: "",
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        phone: "",
        type: "",
      },
      nameState: null,
      userType: [
        { value: "staff", text: "Staff" },
        { value: "it_team_member", text: "IT team" },
        { value: "reception", text: "Reception" },
      ],
    };
  },
  computed: {
    ...mapGetters(["users"]),
    userNameValidation() {
      let condition =
        this.form.user_name.length > 4 && this.form.user_name.length < 13;
      return condition;
    },
    formIsValid() {
      return !this.$v.$invalid;
    },
  },
  methods: {
    ...mapActions(["addUser"]),
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      (this.form.user_name = ""),
        (this.form.first_name = ""),
        (this.form.last_name = ""),
        (this.form.email = ""),
        (this.form.password = "");
    },
    handleOk() {
      // bvModalEvt.close();
      // Trigger submit handler
      // this.resetModal();
    },
    handleSubmit() {
      const data = {
        ...this.form,
      };
      this.addUser(data);
      this.$bvModal.hide("add-user-modal");
    },
  },
  validations: {
    form: {
      email: {
        required,
        isUnique(email) {
          let index = this.users.findIndex((user) => user.email == email);
          // TODO: List admin email on a states
          if (index === -1 && email !== "owgs@astu.com") return true;
          return false;
        },
      },
      phone: {
        required,
        isUnique(value) {
          let index = this.users.findIndex((user) => user.email == value);
          // TODO: List admin phone on a states
          if (index === -1 && value !== "+251921641744") return true;
          return false;
        },
      },
      user_name: {
        required,
        isUnique(value) {
          let user = this.users.findIndex((user) => user.user_name == value);
          if (user === -1) return true;
          return false;
        },
      },
      password_confirmation: {
        sameAsPassword: sameAs("password"),
      },
      type: {
        required,
      },
    },
  },
};
</script>