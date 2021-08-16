<template>
  <div>
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
      <div class="container">
        <router-link to="/" class="navbar-brand">
          <!-- src="/images/astu.jpg" -->
          <!-- <img src="/images/astu.jpg" alt="ASTU LOGO" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
          <span class="brand-text font-weight-light">OWGS</span>
        </router-link>

        <button
          class="navbar-toggler order-1"
          type="button"
          data-toggle="collapse"
          data-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link to="/" class="nav-link">{{
                tr("Home")
              }}</router-link>
            </li>
            <!-- <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li> -->

            <li v-if="username" class="nav-item">
              <router-link to="/dashboard" class="nav-link">{{
                tr("Dashboard")
              }}</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/info" class="nav-link">{{
                tr("Info")
              }}</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/apply-online-affair" class="nav-link">{{
                tr("Online Affair")
              }}</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/check-request-progress" class="nav-link">
                <b-button size="sm">
                  {{ tr("Check Requst progress") }}
                </b-button>
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown" hidden>
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-comments"></i>
              <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div
              class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
            ></div>
          </li>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown" hidden>
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div
              class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
            ></div>
          </li>
          <li class="nav-item" hidden>
            <a
              class="nav-link"
              data-widget="control-sidebar"
              data-slide="true"
              href="#"
              role="button"
            >
              <i class="fas fa-th-large"></i>
            </a>
          </li>
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
          <b-nav-item-dropdown hidden>
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
        </ul>
      </div>
    </nav>
    <b-navbar fixed="top" toggleable="lg" type="light" hidden>
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