<template>
  <div>
   <!-- <SecondV />  -->
   <!-- <Version3 /> -->
   <Version4 />
    <div class="" hidden>
      <div class="left-panel">
        <customer-list
          v-for="user in users"
          :key="user.userID"
          :user="user"
          :selected="selectedUser == user"
          @select="selectUser(user)"
        />
      </div>
      <message-panel
        v-if="selectedUser"
        :user="selectedUser"
        @input="sendMessage"
        class="right-panel"
      />
    </div>
  </div>
</template>
<script>
import Version4 from './copy/Version4.vue'
import socket from "../../chat/socket";
import CustomerList from "../reception/CustomerList.vue";
import MessagePanel from "../reception/MessagePanel.vue";
// import {v4 as uuidv4 } from 'uuid'
export default {
  name: "reception-dashboard",
  components: { CustomerList, MessagePanel, Version4},
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
      this.selectedUser = user;
    },
    sendMessage(content) {
      if (this.selectedUser) {
        socket.emit("private message", {
          content,
          to: this.selectedUser.userID,
        });
        this.selectedUser.messages.push({
          content,
          fromSelf: true,
        });
      }
    },
  },
  // mounted() {
  //   let username = "reception";
  //   let user = { username };
  //   socket.auth = user;
  //   socket.connect();
  // },
  created() {
    // socket.on("connect", () => {
    //   this.users.forEach((user) => {
    //     if (user.self) {
    //       user.connected = true;
    //     }
    //   });
    // });
    // socket.on("connect_error", (err) => {
    //   console.log(err);
    // });
    // const initReactiveProperties = (user) => {
    //   user.connected = true;
    //   user.messages = [];
    //   user.hasNewMessages = false;
    // };
    // socket.on("users", (users) => {
    //   users.forEach((user) => {
    //     user.self = user.userID === socket.id;
    //     initReactiveProperties(user);
    //   });
    //   console.log("users: ", users);
    //   // put the current user first, and sort by username
    //   this.users = users.sort((a, b) => {
    //     if (a.self) return -1;
    //     if (b.self) return 1;
    //     if (a.username < b.username) return -1;
    //     return a.username > b.username ? 1 : 0;
    //   });
    // });
    // socket.on("user connected", (user) => {
    //   initReactiveProperties(user);
    //   this.users.push(user);
    // });
    // socket.on("user disconnected", (id) => {
    //   for (let i = 0; i < this.users.length; i++) {
    //     const user = this.users[i];
    //     if (user.userID === id) {
    //       user.connected = false;
    //       break;
    //     }
    //   }
    // });
    // socket.on("private message", ({ content, from }) => {
    //   for (let i = 0; i < this.users.length; i++) {
    //     const user = this.users[i];
    //     if (user.userID === from) {
    //       user.messages.push({
    //         content,
    //         fromSelf: false,
    //       });
    //       if (user !== this.selectedUser) {
    //         user.hasNewMessages = true;
    //       }
    //       break;
    //     }
    //   }
    // });
  },
};
</script>

<style scoped>
.left-panel {
  position: fixed;
  /* left: 0; */
  top: 0;
  bottom: 0;
  width: 260px;
  overflow-x: hidden;
  background-color: #3f0e40;
  color: white;
}

.right-panel {
  margin-left: 560px;
}

.selected {
  background-color: #1164a3;
}

.user {
  padding: 10px;
}

.description {
  display: inline-block;
}

.status {
  color: #92959e;
}

.new-messages {
  color: white;
  background-color: red;
  width: 20px;
  border-radius: 5px;
  text-align: center;
  float: right;
  margin-top: 10px;
}
.icon {
  height: 8px;
  width: 8px;
  border-radius: 50%;
  display: inline-block;
  background-color: #e38968;
  margin-right: 6px;
}

.icon.connected {
  background-color: #86bb71;
}

.messages {
  margin: 0;
  padding: 20px;
}

.message {
  list-style: none;
}
</style>
