const httpServer = require("http").createServer();
const io = require("socket.io")(httpServer, {
  cors: {
    origin: "*",
  },
});

const crypto = require("crypto");
const randomId = () => crypto.randomBytes(8).toString("hex");

const { InMemorySessionStore } = require("./sessionStore");
const sessionStore = new InMemorySessionStore();

io.use((socket, next) => {
  const username = socket.handshake.auth.username;
  console.log('username: ', username)
  if (!username) {
    return next(new Error("invalid username"));
  }
  socket.username = username;
  next();
});

io.on("connection", (socket) => {
  // fetch existing users
  const users = [];
  for (let [id, socket] of io.of("/").sockets) {
    users.push({
      userID: id,
      username: socket.username,
    });
  }
  socket.emit("users", users);
  console.log('users: ',users)
  // notify existing users
  // let reception = users.find(user => user.username=='reception')
  socket.broadcast.emit("user connected", {
    userID: socket.id,
    username: socket.username,
    connected: true,
  });
  

  // forward the private message to the right recipient
  socket.on("private message", ({ content, to}) => {
    socket.to(to).emit("private message", {
      content,
      from: socket.id,
      
    });
  });

  // notify users upon disconnection
  socket.on("disconnect", () => {
    socket.broadcast.emit("user disconnected", socket.id);
  });
});

const PORT = process.env.PORT || 3000;

httpServer.listen(PORT, () =>
  console.log(`server listening at http://localhost:${PORT}`)
);
// httpServer.listen(3000,'10.240.72.41');
