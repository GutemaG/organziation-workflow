<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light navbar-white shadow" style="z-index: 100; position: fixed; width: 100%; top: 0;">
      <div class="container">
        <router-link to="/" class="navbar-brand">
          <span class="brand-text font-weight-light">OWGS</span>
        </router-link>

        <button class="navbar-toggler order-1 collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse order-3 collapse" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link v-if="username" to="/dashboard" class="nav-link">
                {{tr("Dashboard")}}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/" class="nav-link">
                {{tr("Home")}}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/info" class="nav-link">
                {{tr("Info")}}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/apply-online-affair" class="nav-link">
                {{tr("Online Affair")}}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/check-request-progress" class="nav-link">
                {{ tr("Check Request progress") }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/frequesntly-asked-question" class="nav-link">
                {{ tr("FAQ") }}
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
            <b-navbar-nav right v-if="!username">
              <b-nav-item to="/login" active>
                <span>Login</span>
                <!-- <a class="btn btn-secondary" size="sm" role="button">{{ tr("Login") }}</a> -->
              </b-nav-item>
            </b-navbar-nav>
            <b-nav-item-dropdown right v-if="username">
              <!-- Using 'button-content' slot -->
              <template #button-content>
                <span>{{ username }}</span>
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
          </li>
        </ul>
      </div>
    </nav>
    <nav hidden class="navbar navbar-expand-md navbar-light navbar-white shadow-sm shadow-lg--hover">
      <div class="container">
        <router-link to="/" class="navbar-brand">
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
          <ul class="navbar-nav navItems">
            <li v-if="username" class="nav-item">
              <router-link v-if="username" to="/dashboard" class="nav-link">{{
                tr("Dashboard")
              }}</router-link>
            </li>
            <li class="nav-item  d-flex">
              <router-link to="/" class="nav-link">{{
                tr("Home")
              }}</router-link>
              
              <router-link to="/info" class="nav-link">{{
                tr("Info")
              }}</router-link>

              <router-link to="/apply-online-affair" class="nav-link">{{
                tr("Online Affair")
              }}</router-link>

              <router-link to="/check-request-progress" class="nav-link">
                {{ tr("Check Request progress") }}
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

<style scoped>
.nav-item .nav-link:hover {
  background-color: #1f4a79ce !important;
  color: #fff !important;
  padding: 8px;
  border-radius: .5rem;
  transform: scale(1.03) !important;
}
.nav-link {
  color: black !important;
}
</style>