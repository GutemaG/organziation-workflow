import { io } from "socket.io-client";

// const URL = "http://10.240.72.41:3000";
const socket = io("http://localhost:3000", { autoConnect: true });

socket.onAny((event, ...args) => {
  console.log(event, args);
});

export default socket;
