<template>
     <b-modal
      id="edit-modal"
      title="Edit"
      ok-title="Update"
      @ok="updateForm"
      @hide="resetModal"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group id="user_name" label="Username" label-for="username-input">
          <b-form-input
            id="username-input"
            v-model="selectedUser.user_name"
            placeholder="Username"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="first_name" label="First Name" label-for="first_name-input">
          <b-form-input
            id="first_name-input"
            v-model="selectedUser.first_name"
            placeholder="enter first name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="last_name" label="Last Name" label-for="last_name-input">
          <b-form-input
            id="last_name-input"
            v-model="selectedUser.last_name"
            placeholder="enter last name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="email"
          label="Email address:"
          label-for="email-input"
        >
          <b-form-input
            id="email-input"
            v-model="selectedUser.email"
            type="email"
            placeholder="Enter email"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="phone" label="phone" label-for="phone-input">
          <b-form-input
            id="phone-input"
            v-model="selectedUser.phone"
            placeholder="phone(+251... or 09 )"
            required
          ></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';

// TODO: modify using props of selectedUser, to reset
export default {
    props:["selectedUser"],
   
    methods: {
    ...mapActions(["updateUser"]),
    info(item, index, button) {
      this.selectedUser = item;
      this.$root.$emit("bv::show::modal", "edit-modal", button);
    },
    resetModal() {
        // this.selectedUser = {},
     this.$root.$emit("bv::hide::modal", "edit-modal"); 
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    updateForm(event){

      event.preventDefault()
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
    //    user_name: this.selectedUser.user_name,
    //       first_name: this.selectedUser.first_name,
    //       last_name: this.selectedUser.last_name,
    //       phone: this.selectedUser.phone,
    //       email: this.selectedUser.email,
      const data = {
         ...this.selectedUser,
          ...permission,
      }
    //   console.log(data.user_name)
      this.updateUser(data);

    },
    onSubmit(event) {
      event.preventDefault();
      console.log("submitttion");
    },
    
  },
}
</script>