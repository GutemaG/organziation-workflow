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
      <b-form-group label="User Permissions" v-slot="{ ariaDescribedby }">
        <input type="checkbox" id="All" value="" v-model="all_permissions">
        <label for="">Select All</label>
      <b-form-checkbox-group
        id="checkbox-group-1"
        v-model="selected"
        :options="permission_options"
        :aria-describedby="ariaDescribedby"
        name="permissions"
      ></b-form-checkbox-group>
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
      selected: [], // Must be an array reference!

        permission_options: [
                { text: "Delete FAQ", value: "delete_FAQ" },
                { text: "Update FAQ", value: "update_FAQ" },
                { text: "Reply Request", value: "reply_request" },
                { text: "Add request to FAQ", value: "add_request_to_FAQ" },
                { text: "Delete Request", value: "delete_request" },
                { text: "Create Bureau", value: "create_bureau" },
                { text: "Update Bureau", value: "update_bureau" },
                { text: "Delete Bureau", value: "delete_bureau" },
                { text: "Create Affair", value: "create_affair" },
                { text: "Update Affair", value: "update_affair" },
                { text: "Delete Affair", value: "delete_affair" },

            ],
            perm: ['delete_FAQ', 'update_FAQ', 'reply_request', 'add_request_to_FAQ', 'delete_request', 'create_bureau', 'update_bureau', 'delete_bureau', 'create_affair', 'update_affair', 'delete_affair'],

            all_permissions: true,
      //TODO: do something tmorrow
      form: {
        user_name: "",
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        phone:"",
        is_active:true,
        
        delete_FAQ:1,
        update_FAQ:1,
        reply_request:1,
        add_request_to_FAQ:1,
        delete_request:1,
        create_bureau:1,
        update_bureau:1,
        delete_bureau:1,
        create_affair:1,
        update_affair:1,
        delete_affair:1,

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
      }
      this.addUser(data);
      this.$bvModal.hide("add-user-modal");
     
    },
  },
  watch: {
        all_permissions: function(new_val, old_val) {
          //TODO: delete the perm data and use for loop to push to the newForm the value of permissions
            if (new_val) {
              this.form.delete_FAQ=1
              this.form.update_FAQ=1
              this.form.reply_request=1
              this.form.add_request_to_FAQ=1
              this.form.delete_request=1
              this.form.create_bureau=1
              this.form.update_bureau=1
              this.form.delete_bureau=1;
              this.form.create_affair=1;
              this.form.update_affair=1;
              this.form.delete_affair=1;
              }
                else {
                 this.form.delete_FAQ=0
              this.form.update_FAQ=0
              this.form.reply_request=0
              this.form.add_request_to_FAQ=0
              this.form.delete_request=0
              this.form.create_bureau=0
              this.form.update_bureau=0
              this.form.delete_bureau=0
              this.form.create_affair=0
              this.form.update_affair=0
              this.form.delete_affair=0
                }
            }
        },
};
</script>