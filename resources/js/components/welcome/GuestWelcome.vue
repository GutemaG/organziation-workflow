<template>
  <div>
    <guest-nav-bar></guest-nav-bar>
    <div class="container" style="margin-top: 5rem">
      <router-view name="welcome"></router-view>
    </div>

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block"><b>Version</b> 3.1.0</div>
      <strong
        >Copyright © 2014-2021
        <a href="https://adminlte.io">AdminLTE.io</a>.</strong
      >
      All rights reserved.
    </footer>
    <div class="footer" hidden>
      <div style="left: 0; right: 0">
        <!-- Footer -->
        <div class="page-footer font-small pt-0">
          <div style="backgroundcolor: #000">
            <b-container class="text-left">
              <b-row class="py-4 d-flex align-items-center" style="color: #000">
                <b-col
                  md="6"
                  lg="5"
                  class="text-center text-md-left mb-4 mb-md-0"
                >
                  <h6 class="mb-0">
                    Get connected with us on social networks!
                  </h6>
                </b-col>
                <b-col
                  md="6"
                  lg="7"
                  class="text-center text-md-right bLink"
                  style="font-size: 1.7rem"
                >
                  <b-link class="fb-ic ml-0"
                    ><i class="fab fa-facebook white-text mr-lg-4"> </i
                  ></b-link>
                  <b-link class="tw-ic"
                    ><i class="fab fa-twitter white-text mr-lg-4"> </i
                  ></b-link>
                  <b-link class="gplus-ic"
                    ><i class="fab fa-google-plus white-text mr-lg-4"> </i
                  ></b-link>
                  <b-link class="li-ic"
                    ><i class="fab fa-linkedin-in white-text mr-lg-4"> </i
                  ></b-link>
                  <b-link class="ins-ic"
                    ><i class="fab fa-instagram white-text mr-lg-4"> </i
                  ></b-link>
                </b-col>
              </b-row>
            </b-container>
          </div>
          <div
            class="pt-5 pb-5 text-center text-md-left"
            center
            style="background-color: #1c2331; color: white"
          >
            <b-container>
              <b-row class="mt-0 py-3 pt-2 pb-2" style="margin: 0; left: 12rem">
                <b-col md="3" lg="4" xl="4" class="mb-4">
                  <h1 class="text-uppercase font-weight-bold">
                    <strong>ASTU</strong>
                    <br />
                    <strong>Guidance</strong>
                  </h1>
                  <p></p>
                </b-col>

                <b-col md="3" lg="4" xl="4" class="mb-4">
                  <h6 class="text-uppercase font-weight-bold">
                    <strong>Help Center</strong>
                  </h6>
                  <hr
                    class="accent-2 mb-4 mt-0 d-inline-block mx-auto"
                    style="width: 60px; background-color: #6a5acd"
                  />
                  <p>
                    <b-link href="#" style="color: white; text-decoration: none"
                      >Help</b-link
                    >
                  </p>
                </b-col>
                <b-col md="4" lg="3" xl="4" class="mb-0">
                  <h6 class="text-uppercase font-weight-bold">
                    <strong>Contact</strong>
                  </h6>
                  <hr
                    class="accent-2 mb-4 mt-0 d-inline-block mx-auto"
                    style="width: 60px; background-color: #6a5acd"
                  />
                  <p>
                    <i class="fas fa-home mr-3"></i> Addis Abeba, Ethiopia 2013
                  </p>
                  <p>
                    <i class="fas fa-envelope mr-3"></i>
                    info@astu.com
                  </p>
                  <p><i class="fas fa-phone mr-3"></i> +251911223366</p>
                  <p><i class="fas fa-print mr-3"></i> +251900000000</p>
                </b-col>
              </b-row>
            </b-container>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <div
        class="footer-copyright text-center py-3 pt-2 pb-2"
        style="background-color: #161c27; color: white"
      >
        <b-container fluid> &copy; 2021 Copyright </b-container>
      </div>
    </div>
  </div>
</template>
<script>
// import VueLogin from "./../auth/Login.vue";
import { mapGetters } from "vuex";
import GuestNavBar from "../include/GuestNavBar.vue";
export default {
  components: { GuestNavBar },
  computed: {
    ...mapGetters(["currentUser"]),
  },
};
</script>