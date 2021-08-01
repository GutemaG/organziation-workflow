<template>
  <b-navbar toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand
      ><router-link to="/" class="nav-link">Home</router-link></b-navbar-brand
    >

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <router-link to="/search">Search</router-link>
    <b-collapse id="nav-collapse" is-nav>
      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-form>
          <b-form-input
            size="sm"
            class="mr-sm-2"
            placeholder="Search"
          ></b-form-input>
          <b-button size="sm" class="my-2 my-sm-0" type="submit"
            >Search</b-button
          >
        </b-nav-form>
        <!-- <b-navbar-nav v-if="!currentUser">
          <b-nav-item to="/login"> Login </b-nav-item>
        </b-navbar-nav> -->
        <b-navbar-nav right v-if="!currentUser">
          <b-nav-item to="/login">
            <!-- <span>Login</span> -->
            <a class="btn btn-secondary" role="button" >Login</a>
          </b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav right v-if="currentUser">
          <b-nav-item to="/dashboard"> Dashboard </b-nav-item>
        </b-navbar-nav>
        <b-nav-item-dropdown right v-if="currentUser">
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em>{{ currentUser.first_name }}</em>
          </template>
          <!-- <b-dropdown-item to="/profile">Profile</b-dropdown-item> -->
          <b-dropdown-item href="/api/logout">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>
<script>
// import VueLogin from "./../auth/Login.vue";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["currentUser"]),
  },
};
</script>