<template>
  <aside
    class="main-sidebar sidebar-dark-primary elevation-4"
    style="position: fixed; top: 0; bottom: 0"
  >
    <!-- Brand Logo -->
    <router-link to="/" class="brand-link block">
      <img
        src="/images/astu.jpg"
        alt="ASTU LOGO"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">OWGS</span>
    </router-link>
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
          <router-link to="profile" class="d-block">{{ username }}</router-link>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="true"
        >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <div>
            <li class="nav-item">
              <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                <p>{{ tr("Dashboard") }}</p>
              </router-link>
            </li>
          </div>
          <div v-if="isAdmin || isSupportiveStaff">
            <li class="nav-item" v-if="isAdmin">
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
          </div>
            <li class="nav-item" v-if="isReception">
              <router-link to="/faqs" class="nav-link">
                <i class="nav-icon fas fa-times blue"></i>
                <p>{{ tr("FAQS") }}</p>
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
    isSupportiveStaff() {
      return this.currentUser.type === "it_team_member";
    },
    isStaff() {
      return this.currentUser.type === "staff";
    },
    isReception(){
      return this.currentUser.type === "reception";
    }
  },
  methods: {},
};
</script>

<style scoped>
.nav-item .nav-link{
  color: white;
  text-align: left;
  background-color: none;
  padding: 5px 19px 5px;
}
.nav-item i{
  margin-right: 0.5rem;
}
.nav-item .nav-link:hover{
  background-color: #50575ec2;
  border-radius: 2rem;
  color: #fff;

}
</style>