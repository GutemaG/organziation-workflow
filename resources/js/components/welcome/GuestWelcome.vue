<template>
  <div>
    <guest-nav-bar></guest-nav-bar>
    <div class="container" style="margin-top: 1.8rem">
      <router-view name="welcome"></router-view>
      <button @click="openChat" class="open-button">
        <i class="fas fa-comment green"></i>
      </button>
      <div>
        <div
          v-show="showChat"
          class="chat-popup page-content page-container"
          id="page-content"
        >
          <div class="p-3">
            <div class="row container d-flex justify-content-center">
              <div class="">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title"><strong>Contact our Information center</strong></h4>
                    <a class="btn btn-danger end" style="margin-right:0" @click="closeChat"
                      ><i class="fas fa-times"></i>
                    </a>
                  </div>
                  <div
                    class="ps-container ps-theme-default ps-active-y"
                    id="chat-content"
                    style="
                      overflow-y: scroll !important;
                      height: 400px !important;
                    "
                  >
                    <div v-for="(msg, index) in messages" :key="index">
                      <div class="media media-chat" v-if="msg.fromSelf">
                        <i class="far fa-circle"></i>
                        <div class="media-body">
                          <p>{{ msg.content }}</p>
                        </div>
                      </div>
                      <div
                        class="media media-chat media-chat-reverse"
                        v-if="!msg.fromSelf"
                      >
                        <div class="media-body">
                          <p>{{ msg.content }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="publisher bt-1 border-light">
                    <img
                      class="avatar avatar-xs"
                      src="https://img.icons8.com/color/36/000000/administrator-male.png"
                      alt="..."
                    />
                    <input
                      v-on:keyup.enter="sendMessage"
                      v-model="message"
                      class="publisher-input"
                      type="text"
                      placeholder="Write something"
                    />
                    <button @click="sendMessage" class="btn btn-sm btn-primary">
                      Send
                      <i class="fa fa-paper-plane"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="main-footer" hidden>
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
import socket from "../../chat/socket";
import { v4 as uuidv4 } from "uuid";
export default {
  components: { GuestNavBar },
  computed: {
    ...mapGetters(["currentUser"]),
  },
  data() {
    return {
      showChat: false,
      selectedUser: null,
      users: [],
      message: "",
      customer: {},
    };
  },
  computed: {
    messages() {
      let customer = this.users.find((user) => user.username == "reception");
      if (customer) {
        return customer.messages;
      }
      return [];
    },
    current() {
      let c = this.users.find((user) => user.self);
      return c;
    },
    auth() {
      return socket.auth;
    },
  },
  methods: {
    sendMessage() {
      // let current = this.users.find((user) => user.self);
      let reception = this.users.find((user) => user.username == "reception");
      if(reception){
      socket.emit("private message", {
        content: this.message,
        to: reception.userID,
      });
      reception.messages.push({
        content: this.message,
        fromSelf: true,
      });
      this.message = "";
     }else{
       console.log('sorry, reception are not available for now')
     }
    },

    closeChat() {
      this.showChat = !this.showChat;
    },
    openChat() {
      this.showChat = !this.showChat;
    },
  },
  mounted() {
    let username = `customer-${uuidv4()}`;
    socket.auth = { username };
    socket.connect();
  },
  created() {
    socket.on("connect", () => {
      this.users.forEach((user) => {
        if (user.self) {
          user.connected = true;
        }
      });
    });
    socket.on("connect_error", (err) => {
      console.log(err);
    });
    const initReactiveProperties = (user) => {
      user.connected = true;
      user.messages = [];
      user.hasNewMessages = false;
    };
    socket.on("users", (users) => {
      users.forEach((user) => {
        user.self = user.userID === socket.id;
        initReactiveProperties(user);
      });
      // console.log("users: ", users);
      // put the current user first, and sort by username
      this.users = users.sort((a, b) => {
        if (a.self) return -1;
        if (b.self) return 1;
        if (a.username < b.username) return -1;
        return a.username > b.username ? 1 : 0;
      });
    });
    socket.on("private message", ({ content, from }) => {
      console.log(from)
      for (let i = 0; i < this.users.length; i++) {
        const user = this.users[i];
        // console.log(user.userID);
        if (user.userID === from) {
          user.messages.push({
            content,
            fromSelf: false,
          });
          if (user !== this.selectedUser) {
            user.hasNewMessages = true;
          }
          break;
        }
      }
    });
  },
  destroyed() {
    socket.off("connect");
    socket.off("disconnect");
    socket.off("users");
    socket.off("user connected");
    socket.off("user disconnected");
    socket.off("private message");
  },
};
import '../../../../public/css/welcomeChat.css'
</script>

<style scoped>
</style>