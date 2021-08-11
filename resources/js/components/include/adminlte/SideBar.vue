<template>
  <aside
    class="main-sidebar sidebar-dark-primary elevation-4"
    style="position: fixed; top: 0; bottom: 0"
  >
    <!-- Brand Logo -->
    <a href="#" class="brand-link block">
      <img
        src="/images/astu.jpg"
        alt="ASTU LOGO"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">OWGS</span>
    </a>
    <!-- <div style="margin: 1rem 0px 1rem 3rem">
          <b-avatar src="/images/astu.jpg" size="6rem"></b-avatar>
      </div> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <b-avatar src="/images/astu.jpg" size="6rem"></b-avatar> -->
          <img
            src="/images/user.png"
            class="img-circle elevation-2"
            alt="User Image"
          />
        </div>
        <div class="info">
          <a href="#" class="d-block">{{username}}</a>
          <!-- <a href="#" class="d-block">{{username}}</a> -->
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input
            class="form-control form-control-sidebar"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
        <div class="sidebar-search-results">
          <div class="list-group">
            <a href="#" class="list-group-item"
              ><div class="search-title">
                <strong class="text-light"></strong>adadfasdN<strong
                  class="text-light"
                ></strong
                >o<strong class="text-light"></strong>
                <strong class="text-light"></strong>e<strong
                  class="text-light"
                ></strong
                >l<strong class="text-light"></strong>e<strong
                  class="text-light"
                ></strong
                >m<strong class="text-light"></strong>e<strong
                  class="text-light"
                ></strong
                >n<strong class="text-light"></strong>t<strong
                  class="text-light"
                ></strong>
                <strong class="text-light"></strong>f<strong
                  class="text-light"
                ></strong
                >o<strong class="text-light"></strong>u<strong
                  class="text-light"
                ></strong
                >n<strong class="text-light"></strong>d<strong
                  class="text-light"
                ></strong
                >!<strong class="text-light"></strong>
              </div>
              <div class="search-path"></div
            ></a>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>Dashboard</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <!-- <router-link to="/"> Back to Home </router-link> -->
              <i class="nav-icon fa fa-users blue"></i>
              <p>{{ tr("Users") }}</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/requests" class="nav-link">
              <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
              <i class="nav-icon fas fa-home blue"></i>
              <p>
                {{ tr("Requests") }}
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/online-requests" class="nav-link">
              <i class="nav-icon fas fa-building blue"></i>
              <p>{{ tr("Online") }}-Requests</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/bureaus" class="nav-link">
              <i class="nav-icon fas fa-list-ol blue"></i>
              <p>{{ tr("Bureau") }}</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/buildings" class="nav-link">
              <i class="nav-icon fas fa-building blue"></i>
              <p>{{ tr("Buildings") }}</p>
            </router-link>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home blue"></i>
              <p>
                Requests
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/requests" class="nav-link">
                  <i class="nav-icon fas fa-home blue"></i>
                  <p>
                    {{ tr("Requests") }}
                  </p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/online-requests" class="nav-link">
                  <i class="nav-icon fas fa-building green"></i>
                  <p>{{ tr("Online") }}-Requests</p>
                </router-link>
              </li>
            </ul>
          </li> -->
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home blue"></i>
              <p>
                {{ tr("Bureau") }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/bureaus" class="nav-link">
                  <i class="nav-icon fas fa-list-ol green"></i>
                  <p>{{ tr("Bureau") }}</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/buildings" class="nav-link">
                  <i class="nav-icon fas fa-building green"></i>
                  <p>{{ tr("Buildings") }}</p>
                </router-link>
              </li>
            </ul>
          </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      username: window.user.first_name,
    };
  },
  computed: {
    ...mapGetters(["currentUser"]),
    isAdmin() {
      return this.currentUser.type === "admin";
    },
    isItTeamMember() {
      return this.currentUser.type === "it-team-member";
    },
    isStaf() {
      return this.currentUser.type === "staff";
    },
  },
  methods:{
  }
};
</script>