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
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          label="Username"
          label-for="username"
          invalid-feedback="Your user ID must be 5-12 characters long"
          valid-feedback="good"
        >
          <b-form-input
            id="username-input"
            v-model="form.user_name"
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
        <b-form-group label="phone number" label-for="phone number">
          <b-form-input
            id="phone number"
            v-model="form.phone"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="email-address"
          label="Email address:"
          label-for="email-address"
        >
          <!-- invalid-feedback="required" -->
          <b-form-input
            id="email-address"
            v-model="form.email"
            type="email"
            placeholder="Enter email"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="user-type" label="User Type" label-for="user-type">
          <b-form-select
            v-model="form.type"
            :options="userType"
            id="user-type"
          >
          <b-form-select-option value="" disabled>Please select user type</b-form-select-option>
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
          invalid-feedback="required"
        >
          <b-form-input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            placeholder="Enter password for the IT team"
            required
          ></b-form-input>
        </b-form-group>
        <b-button
          class="form-control"
          type="submit"
          variant="primary"
          >Add</b-button
        >
          <!-- :disabled="!userNameValidation" -->
      </form>
    </b-modal>
  </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
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
      submitEnabled: true,
      userType: [
        { value: "staff", text: "Staff" },
        { value: "it_team_member", text: "IT team" },
        { value: "reception", text: "Reception" },
      ],
    };
  },
  computed: {
    userNameValidation() {
      let condition =
        this.form.user_name.length > 4 && this.form.user_name.length < 13;
      return condition;
    },
  },
  methods: {
    ...mapActions(["addUser"]),
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
};
</script>