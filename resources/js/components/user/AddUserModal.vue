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
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          label="Username"
          label-for="username"
          invalid-feedback="Your user ID must be 5-12 characters long"
          valid-feedback="good"
          :state="userNameValidation"
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
        <b-form-group
          label="phone number"
          label-for="phone number"
        >
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
            :disabled="!userNameValidation"
            >Add</b-button
          >
     
      </form>
    </b-modal>
  </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      //TODO: do something tmorrow
      form: {
        user_name: "",
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        phone:"",
        is_active:true
      },
      nameState: null,
      submitEnabled: true,
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
       let permission = {
          delete_FAQ:0,
          update_FAQ:0,
          reply_request:0,
          add_request_to_FAQ:0,
          delete_request:0,
          create_bureau:0,
          update_bureau:0,
          delete_bureau:0,
          create_affair:0,
          update_affair:0,
          delete_affair:0,

      }
      const data = {
         ...this.form,
          ...permission,
      }
      this.addUser(data);
      this.$bvModal.hide("add-user-modal");
     
    },
  },
};
</script>