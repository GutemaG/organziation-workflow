<template>
     <b-modal
      id="edit-modal"
      title="Edit"
      ok-only
      ok-title="Cancel"
      ok-variant="danger"
    >
      <form ref="form" @submit.stop.prevent="updateForm">
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
          <b-button
            class="form-control"
            type="submit"
            variant="primary"
            >UPDATE</b-button
          >
     
      </form>
    </b-modal>
</template>
<script>
import { mapActions } from 'vuex';

// TODO: modify using props of selectedUser, to reset
export default {
    props:{
        selectedUser:{
          type: Object,
          required: true,
        }
    },
    methods: {
    ...mapActions(["updateUser"]),
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
      const data = {
         ...this.selectedUser,
          ...permission,
      }
      this.updateUser(data);
      this.$bvModal.hide("edit-modal");
    },

  },
}
</script>