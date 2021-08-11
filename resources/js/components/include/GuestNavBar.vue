<template>
  <div>
    <b-navbar fixed="top" toggleable="lg" type="dark" variant="dark">
      <router-link to="/">
        <b-navbar-brand>{{ tr("Home") }}</b-navbar-brand>
      </router-link>
      <!-- <b-navbar-toggle target="nav-collapse"></b-navbar-toggle> -->
      <b-navbar-toggle target="nav-collapse">
        <template #default="{ expanded }">
          <b-icon v-if="expanded" icon="chevron-bar-up"></b-icon>
          <b-icon v-else icon="chevron-bar-down"></b-icon>
        </template>
      </b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav v-if="username">
          <b-nav-item to="/dashboard">{{ tr("Dashbaord") }}</b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav>
          <b-nav-item to="/apply-online-affair">{{
            tr("Online Affair")
          }}</b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav>
          <b-nav-item to="/check-request-progress">
            <b-button size="sm">
              {{ tr("Check Requst progress") }}
            </b-button>
          </b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-form>
            <b-form-input
              size="sm"
              class="mr-sm-2"
              placeholder="Search"
            ></b-form-input>
            <b-button size="sm" class="my-2 my-sm-0" type="submit">{{
              tr("Search")
            }}</b-button>
          </b-nav-form>
          <b-navbar-nav right v-if="!username">
            <b-nav-item to="/login" active>
              <span>Login</span>
              <!-- <a class="btn btn-secondary" size="sm" role="button">{{ tr("Login") }}</a> -->
            </b-nav-item>
          </b-navbar-nav>

          <b-nav-item-dropdown right v-if="username">
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <em>{{ username }}</em>
            </template>
            <b-dropdown-item to="/profile">{{ tr("Profile") }}</b-dropdown-item>
            <b-dropdown-item href="/api/logout">{{
              tr("Sign Out")
            }}</b-dropdown-item>
          </b-nav-item-dropdown>
          <b-nav-item-dropdown right hidden>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <em>{{ tr("Language") }}</em>
            </template>
            <!-- <b-dropdown-item to="/profile">Profile</b-dropdown-item> -->
            <b-dropdown-item @click="change_language('eng')"
              >English</b-dropdown-item
            >
            <b-dropdown-item @click="change_language('amh')"
              >Amharic</b-dropdown-item
            >
            <b-dropdown-item @click="change_language('oro')"
              >Afaan Oromo</b-dropdown-item
            >
          </b-nav-item-dropdown>
          <b-nav-item-dropdown right hidden>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <em>{{ tr("Language") }}</em>
            </template>
            <!-- <b-dropdown-item to="/profile">Profile</b-dropdown-item> -->
            <b-dropdown-item @click="change_language('eng')"
              >English</b-dropdown-item
            >
            <b-dropdown-item @click="change_language('amh')"
              >Amharic</b-dropdown-item
            >
            <b-dropdown-item @click="change_language('oro')"
              >Afaan Oromo</b-dropdown-item
            >
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  computed: {
    username() {
      let user = window.user;
      if (user) {
        return user.user_name;
      }
      return null;
    },
  },
  methods: {},
};
</script>