<template>
  <div>
    <b-sidebar id="sidebar-1" title="OWGS" width="260px" shadow backdrop>
      <div class="p-3">
        <div class="flex" style="justify-content: center">
          <b-avatar src="/images/astu.jpg" size="6rem"></b-avatar>
        </div>
        <router-link to="/profile">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img
                src="/images/user.png"
                class="img-circle elevation-2"
                alt="User Image"
              />
            </div>
            <div class="info">
              <span class="d-block text-muted">{{ username }}</span>
            </div>
          </div>
        </router-link>
        <nav class="mb-3">
          <b-nav vertical>
            <b-nav-item to="/dashboard">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              Dashboard</b-nav-item
            >
            <b-nav-item to="/users" v-if="isAdmin">
              <i class="fa fa-users nav-icon blue"></i>
              Users
            </b-nav-item>
            <b-nav-item v-b-toggle.request-collapse class="has-tree-view">
              <i class="nav-icon fas fa-home blue"></i>
              Requests
              <i class="nav-icon fas fa-caret-down red ml-3"></i>
              <b-collapse id="request-collapse">
                <b-nav-item to="/requests">
                  <i class="nav-icon fas fa-list-ol green"></i>
                  Reqeuests
                </b-nav-item>
                <b-nav-item to="/online-request">
                  <i class="nav-icon fas fa-building green"></i>
                  Online-Requests
                </b-nav-item>
              </b-collapse>
            </b-nav-item>
            <b-nav-item v-b-toggle.bureau-collapse class="has-tree-view">
              <i class="nav-icon fas fa-home blue"></i>
              Bureau
              <i class="nav-icon fas fa-caret-down red ml-3"></i>
              <b-collapse id="bureau-collapse">
                <b-nav-item to="/bureaus">
                  <i class="nav-icon fas fa-list-ol green"></i>
                  Bureau
                </b-nav-item>
                <b-nav-item to="/buildings">
                  <i class="nav-icon fas fa-building green"></i>
                  Buildings
                </b-nav-item>
              </b-collapse>
            </b-nav-item>
          </b-nav>
        </nav>
      </div>
    </b-sidebar>
  </div>
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
};
</script>