<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand
        ><router-link to="/" class="nav-link">Home</router-link></b-navbar-brand
      >

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

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

          <b-navbar-nav right v-if="!currentUser">
            <b-nav-item
              @click="
                $root.$emit(
                  'bv::show::modal',
                  'login-modal-form',
                  $event.target
                )
              "
            >
            <b-button variant="primary">Login</b-button>
              </b-nav-item
            >
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
    <h1>Guest Welcome</h1>
    <vue-login></vue-login>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["currentUser"]),
  },
};
</script>