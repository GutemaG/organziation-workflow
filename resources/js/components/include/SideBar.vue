<template>
  <div>
    <b-sidebar
      id="sidebar-1"
      title="OWGS"
      width="320px"
      shadow
      backdrop
      no-close-on-route-change
    >
      <div class="p-3">
        <div style="margin: 1rem 0px 1rem 3rem">
          <b-avatar src="/images/astu.jpg" size="6rem"></b-avatar>
        </div>
        <hr class="my-1" />
        <router-link
          to="/profile"
          style="text-decoration: none; align-item: center"
        >
          <div style="padding: 0.5rem 1rem">
            <b-avatar variant="info" src="/images/user.png"></b-avatar>
            <span class="text-muted" style="margin-left: 0.5rem">{{
              username
            }}</span>
          </div>
        </router-link>
        <hr class="my-1" />
        <nav class="mb-3">
          <b-nav vertical>
            <b-nav-item to="/dashboard">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              Dashboard</b-nav-item
            >
            <b-nav-item to="/users" v-if="isAdmin">
              <i class="fa fa-users nav-icon blue"></i>
              {{ tr("Users") }}
            </b-nav-item>
            <b-nav-item v-b-toggle.request-collapse class="has-tree-view">
              <i class="nav-icon fas fa-home blue"></i>
              {{ tr("Requests") }}
              <i class="nav-icon fas fa-caret-down red ml-3"></i>
              <b-collapse id="request-collapse">
                <b-nav-item to="/requests">
                  <i class="nav-icon fas fa-list-ol green"></i>
                  {{ tr("Requests") }}
                </b-nav-item>
                <b-nav-item to="/online-requests">
                  <i class="nav-icon fas fa-building green"></i>
                  {{ tr("Online") }}-Requests
                </b-nav-item>
              </b-collapse>
            </b-nav-item>
            <b-nav-item v-b-toggle.bureau-collapse class="has-tree-view">
              <i class="nav-icon fas fa-home blue"></i>
              {{ tr("Bureau") }}
              <i class="nav-icon fas fa-caret-down red ml-3"></i>
              <b-collapse id="bureau-collapse">
                <b-nav-item to="/bureaus">
                  <i class="nav-icon fas fa-list-ol green"></i>
                  Bureau
                </b-nav-item>
                <b-nav-item to="/buildings">
                  <i class="nav-icon fas fa-building green"></i>
                  {{ tr("Buildings") }}
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
  methods:{
  }
};
</script>