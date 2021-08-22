<template>
  <div>
    <div class="container">
      <div class="row m-2" style="height: 70vh">
        <div class="col-4" style="overflow-y: scroll">
          <ul class="chat_list" v-for="user in users" :key="user.userID">
            <li @click="selectUser(user)" :class="[user==selectedUser?'active_chat':'']">
              <span class="">
                <i class="fa fa-circlef"></i>
              </span>
              <div class="body mt-1">
                <div class="header">
                  <span class="username">{{ user.username }}</span>
                  <small class="timestamp text-muted">
                    <b-badge v-if="user.hasNewMessages" variant="danger"
                      >new</b-badge
                    >
                  </small>
                </div>
                <p></p>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-8" v-if="selectedUser">
          <div style="height: 65vh; overflow: auto">
            <ul
              class="message-list"
              v-for="(msg, index) in selectedUser.messages"
              :key="index"
            >
              <li v-if="!msg.fromSelf">
                <div class="incoming_msg">
                  <div class="received_msg">
                    <div class="received_withd_msg">
                      <p>{{ msg.content }}</p>
                      <!-- <span class="time_date">new</span> -->
                    </div>
                  </div>
                </div>
              </li>
              <li v-if="msg.fromSelf">
                <div class="outgoing_msg">
                  <div class="sent_msg">
                    <p>{{ msg.content }}</p>
                    <span class="time_date">you</span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div>
            <div class="type_msg">
              <div class="input_msg_write">
                <input
                  type="text"
                  v-model="message"
                  v-on:keyup.enter="sendMessage"
                  class="write_msg"
                  placeholder="Type a message"
                />
                <button class="msg_send_btn" @click="sendMessage" type="button">
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import socket from "../../../chat/socket";
import CustomerList from "../../reception/CustomerList.vue";
import MessagePanel from "../../reception/MessagePanel.vue";
// import {v4 as uuidv4 } from 'uuid'
export default {
  name: "version-4",
  components: { CustomerList, MessagePanel },
  data() {
    return {
      selectedUser: null,
      users: [],
      message: "",
    };
  },
  computed: {
    connectedUser() {
      let connected = this.users.filter((user) => user.connected == true);
      return connected;
    },
  },
  methods: {
    selectUser(user) {
      console.log(user);
      this.selectedUser = user;
      this.selectedUser.hasNewMessages = false;
    },
    sendMessage() {
      console.log(this.selectedUser.userID);
      // return
      if (this.selectedUser) {
        socket.emit("private message", {
          content: this.message,
          to: this.selectedUser.userID,
        });
        this.selectedUser.messages.push({
          content: this.message,
          fromSelf: true,
        });
        this.message = "";
      }
    },
  },
  mounted() {
    // let username = "reception";
    // // let user = { username };
    // socket.auth = {username};
    // socket.connect();
    // console.log(socket.auth)
  },
  created() {
    let username = "reception";
    socket.auth = { username };
    socket.connect();

    socket.on("connect", () => {
      this.users.forEach((user) => {
        if (user.self) {
          user.connected = true;
        }
      });
    });
    socket.on("disconnect", () => {
      this.users.forEach((user) => {
        if (user.self) {
          user.connected = false;
        }
      });
    });
    socket.on("connect_error", (err) => {
      console.log("connection erorrr");
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
      // put the current user first, and sort by username
      this.users = users.sort((a, b) => {
        if (a.self) return -1;
        if (b.self) return 1;
        if (a.username < b.username) return -1;
        return a.username > b.username ? 1 : 0;
      });
    });
    socket.on("user connected", (user) => {
      initReactiveProperties(user);
      this.users.push(user);
    });

    socket.on("user disconnected", (id) => {
      for (let i = 0; i < this.users.length; i++) {
        const user = this.users[i];
        if (user.userID === id) {
          user.connected = false;
          break;
        }
      }
    });
    socket.on("private message", ({ content, from, to }) => {
      for (let i = 0; i < this.users.length; i++) {
        const user = this.users[i];
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
};
</script>
<style scoped>
/* .container{max-width:1170px; margin:auto;} */
img {
  max-width: 100%;
}

.chat_list {
  /* border-bottom: 1px solid #c4c4c4; */
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat {
  height: 550px;
  overflow-y: scroll;
}

.active_chat {
  background: #ebebeb;
}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
}
.received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
  margin: 1px;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg {
  width: 57%;
}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
  height: 550px;
  overflow-y: scroll;
}

.sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0;
  color: #fff;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.outgoing_msg {
  overflow: hidden;
  margin: 26px 0 26px;
}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 90%;
}

.type_msg {
  border-top: 1px solid #c4c4c4;
  position: relative;
  /* bottom: 0; */
}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
/* New */
li.left {
  float: left;
  text-align: left;
  display: block;
  color: #999;
  font-size: 11px;
  line-height: 18px;
  font-style: italic;
  margin-bottom: 4px;
  margin-right: 4px;
}
li {
  list-style: none;
}
.avatar {
  width: 60px;
  height: auto;
  border: 4px solid transparent;
  float: left;
}
.chat_list li {
  /* background-color:red */
  display: block;
  /* padding: 20px 10px; */
  clear: both;
  cursor: pointer;
  border-bottom: 1px solid #ddd;
  transition: all 0.2s ease-in-out;
  text-align: match-parent;

}
.chat_list li:hover{
  background-color: #f4f4f4f4;
}
.body{
  margin-top: 4px;
  margin-bottom: 4px;
}
</style>