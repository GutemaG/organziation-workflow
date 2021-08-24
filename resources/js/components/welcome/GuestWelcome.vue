<template>
  <div>
    <guest-nav-bar></guest-nav-bar>
    <div class="container" style="">
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
                    <h4 class="card-title">
                      <strong>Contact our Information center</strong>
                    </h4>
                    <a
                      class="btn btn-danger end"
                      style="margin-right: 0"
                      @click="closeChat"
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
      start_chat: false,
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
      if (reception) {
        socket.emit("private message", {
          content: this.message,
          to: reception.userID,
        });
        reception.messages.push({
          content: this.message,
          fromSelf: true,
        });
        this.message = "";
      } else {
        console.log("sorry, reception are not available for now");
      }
    },

    closeChat() {
      this.showChat = !this.showChat;
    },
    openChat() {
      this.showChat = !this.showChat;
      this.start_chat = true;
    },
  },
  watch: {
    start_chat() {
      let username = `customer-${uuidv4()}`;
      socket.auth = { username };
      socket.connect();
    },
  },
  mounted() {
    // let username = `customer-${uuidv4()}`;
    // socket.auth = { username };
    // socket.connect();
  },
  created() {
    if(this.start_chat){
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
      console.log(from);
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
    }
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
</script>

<style scoped>
/* @import '../../../../public/css/welcomeChat.css' */

.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  border-radius: 50%;
}
/* The popup chat - hidden by default */
.chat-popup {
  /* display: none; */
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  /* max-width: 300px; */
  padding: 10px;
  background-color: white;
}

/* Full-width textarea */
.form-container textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 200px;
}

/* When the textarea gets focus, do something */
.form-container textarea:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/send button */
.form-container .btn {
  background-color: #04aa6d;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom: 10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover,
.open-button:hover {
  opacity: 1;
}
/* for chat */
.card-bordered {
  border: 1px solid #ebebeb;
}

.card {
  border: 0;
  border-radius: 0px;
  margin-bottom: 30px;
  -webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.padding {
  padding: 3rem !important;
}

body {
  background-color: #f9f9fa;
}

.card-header:first-child {
  border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.card-header {
  display: -webkit-box;
  display: flex;
  -webkit-box-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  align-items: center;
  padding: 15px 20px;
  background-color: transparent;
  border-bottom: 1px solid rgba(77, 82, 89, 0.07);
}

.card-header .card-title {
  padding: 0;
  border: none;
}

h4.card-title {
  font-size: 17px;
}

.card-header > *:last-child {
  margin-right: 0;
}

.card-header > * {
  margin-left: 8px;
  margin-right: 8px;
}

.btn-secondary {
  color: #4d5259 !important;
  background-color: #e4e7ea;
  border-color: #e4e7ea;
  color: #fff;
}

.btn-xs {
  font-size: 11px;
  padding: 2px 8px;
  line-height: 18px;
}

.btn-xs:hover {
  color: #fff !important;
}

.card-title {
  font-family: Roboto, sans-serif;
  font-weight: 300;
  line-height: 1.5;
  margin-bottom: 0;
  padding: 15px 20px;
  border-bottom: 1px solid rgba(77, 82, 89, 0.07);
}

.ps-container {
  position: relative;
}

.ps-container {
  -ms-touch-action: auto;
  touch-action: auto;
  overflow: hidden !important;
  -ms-overflow-style: none;
}

.media-chat {
  padding-right: 64px;
  margin-bottom: 0;
}

.media {
  padding: 16px 12px;
  -webkit-transition: background-color 0.2s linear;
  transition: background-color 0.2s linear;
}

.media .avatar {
  flex-shrink: 0;
}

.avatar {
  position: relative;
  display: inline-block;
  width: 36px;
  height: 36px;
  line-height: 36px;
  text-align: center;
  border-radius: 100%;
  background-color: #f5f6f7;
  color: #8b95a5;
  text-transform: uppercase;
}

.media-chat .media-body {
  -webkit-box-flex: initial;
  flex: initial;
  display: table;
}

.media-body {
  min-width: 0;
}

.media-chat .media-body p {
  position: relative;
  padding: 6px 8px;
  margin: 4px 0;
  background-color: #f5f6f7;
  border-radius: 3px;
  font-weight: 100;
  color: #9b9b9b;
}

.media > * {
  margin: 0 8px;
}

.media-chat .media-body p.meta {
  background-color: transparent !important;
  padding: 0;
  opacity: 0.8;
}

.media-meta-day {
  -webkit-box-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  align-items: center;
  margin-bottom: 0;
  color: #8b95a5;
  opacity: 0.8;
  font-weight: 400;
}

.media {
  padding: 16px 12px;
  -webkit-transition: background-color 0.2s linear;
  transition: background-color 0.2s linear;
}

.media-meta-day::before {
  margin-right: 16px;
}

.media-meta-day::before,
.media-meta-day::after {
  content: "";
  -webkit-box-flex: 1;
  flex: 1 1;
  border-top: 1px solid #ebebeb;
}

.media-meta-day::after {
  content: "";
  -webkit-box-flex: 1;
  flex: 1 1;
  border-top: 1px solid #ebebeb;
}

.media-meta-day::after {
  margin-left: 16px;
}

.media-chat.media-chat-reverse {
  padding-right: 12px;
  padding-left: 64px;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: reverse;
  flex-direction: row-reverse;
}

.media-chat {
  padding-right: 64px;
  margin-bottom: 0;
}

.media {
  padding: 16px 12px;
  -webkit-transition: background-color 0.2s linear;
  transition: background-color 0.2s linear;
}

.media-chat.media-chat-reverse .media-body p {
  float: right;
  clear: right;
  background-color: #48b0f7;
  color: #fff;
}

.media-chat .media-body p {
  position: relative;
  padding: 6px 8px;
  margin: 4px 0;
  background-color: #f5f6f7;
  border-radius: 3px;
}

.border-light {
  border-color: #f1f2f3 !important;
}

.bt-1 {
  border-top: 1px solid #ebebeb !important;
}

.publisher {
  position: relative;
  display: -webkit-box;
  display: flex;
  -webkit-box-align: center;
  align-items: center;
  padding: 12px 20px;
  background-color: #f9fafb;
}

.publisher > *:first-child {
  margin-left: 0;
}

.publisher > * {
  margin: 0 8px;
}

.publisher-input {
  -webkit-box-flex: 1;
  flex-grow: 1;
  border: none;
  outline: none !important;
  background-color: transparent;
}

button,
input,
optgroup,
select,
textarea {
  font-family: Roboto, sans-serif;
  font-weight: 300;
}

.publisher-btn {
  background-color: transparent;
  border: none;
  color: #8b95a5;
  font-size: 16px;
  cursor: pointer;
  overflow: -moz-hidden-unscrollable;
  -webkit-transition: 0.2s linear;
  transition: 0.2s linear;
}

.file-group {
  position: relative;
  overflow: hidden;
}

.publisher-btn {
  background-color: transparent;
  border: none;
  color: #cac7c7;
  font-size: 16px;
  cursor: pointer;
  overflow: -moz-hidden-unscrollable;
  -webkit-transition: 0.2s linear;
  transition: 0.2s linear;
}

.file-group input[type="file"] {
  position: absolute;
  opacity: 0;
  z-index: -1;
  width: 20px;
}

.text-info {
  color: #48b0f7 !important;
}
</style>