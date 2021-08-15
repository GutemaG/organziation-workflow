<template>
  <!-- style="position:fixed; top:0;width:100vw; right:0;left:0" -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"
          ><i class="fas fa-bars"></i
        ></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/home" class="nav-link">Home</router-link>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input
                class="form-control form-control-navbar"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button
                  class="btn btn-navbar"
                  type="button"
                  data-widget="navbar-search"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img
                src="dist/img/user1-128x128.jpg"
                alt="User Avatar"
                class="img-size-50 mr-3 img-circle"
              />
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"
                    ><i class="fas fa-star"></i
                  ></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted">
                  <i class="far fa-clock mr-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img
                src="dist/img/user8-128x128.jpg"
                alt="User Avatar"
                class="img-size-50 img-circle mr-3"
              />
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"
                    ><i class="fas fa-star"></i
                  ></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted">
                  <i class="far fa-clock mr-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img
                src="dist/img/user3-128x128.jpg"
                alt="User Avatar"
                class="img-size-50 img-circle mr-3"
              />
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"
                    ><i class="fas fa-star"></i
                  ></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted">
                  <i class="far fa-clock mr-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{
            notifications.length
          }}</span>
        </a>
        <div
          class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
          :style="{
            width: 400 + 'px',
          }"
        >
          <!-- height: heightOfNotificationDropDown,
            overflow: 'scroll', -->
          <span class="dropdown-header"
            >{{ notifications.length }} Notifications</span
          >
          <div
            v-if="notifications.length > 0"
            style="max-height: 60vh; overflow-y: scroll"
          >
            <div v-for="(notification, index) in notifications" :key="index">
              <div class="dropdown-divider"></div>
              <span class="dropdown-item">
                <router-link
                class="dropdown-item"
                  :to="{
                    name: 'notification',
                    params: {
                      slug: 'notification-' + notification.id,
                      request: notification,
                    },
                  }"
                >
                <i class="fas fa-dot-circle mr-2"></i>
                  <p>
                    {{ notification.online_request.name }}
                  </p>
                </router-link>
                <span class="float-right text-muted">
                  <b-button
                    variant="info"
                    size="sm"
                    @click="acceptRequest(notification)"
                  >
                    <span>accept</span>
                    <!-- <i class="fas fa-check white"></i> -->
                  </b-button>
                </span>
              </span>
              <div class="dropdown-divider"></div>
            </div>
          </div>
          <router-link
            v-if="notifications.length > 1"
            class="dropdown-item"
            :to="{
              name: 'notification',
              params: { slug: 'all-notifications', request: notifications },
            }"
            >Show All Request
          </router-link>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button">
          {{ user.user_name }}
          <!-- <i class="right fas fa-angle-left"></i> -->
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item"
              >{{ user.first_name }} {{ user.last_name }}</a
            >
            <div class="dropdown-divider"></div>
            <router-link to="/profile" class="dropdown-item">
              Profile
            </router-link>
            <div class="dropdown-divider"></div>
            <a
              href="#"
              class="dropdown-item"
              onclick="event.preventDefault();
          document.getElementById('logout-form').submit();"
            >
              <i class="nav-icon fas fa-power-off red"></i>
              {{ tr("Sign Out") }}
            </a>
            <form
              id="logout-form"
              action="api/logout"
              method="get"
              style="display: none"
            ></form>
          </div>
        </a>
      </li>
    </ul>
  </nav>
</template>
<script>
import axios from "axios";
import { mapActions, mapGetters } from 'vuex';
export default {
  data() {
    return {
      // notifications:[],
      notification:[
        {"id":350,"online_request_tracker_id":"104","online_request_procedure_id":"91","started_at":null,"ended_at":null,"next_step":"351","user_id":"52","is_completed":"0","is_rejected":null,"reason":null,"deleted_at":null,"created_at":"2021-08-12T09:05:56.000000Z","updated_at":"2021-08-13T05:11:15.000000Z","online_request":{"id":23,"user_id":"1","name":"request for staff","type":"staff","description":"Qui unde cumque dolo","created_at":"2021-08-11T13:51:26.000000Z"}},
        {"id":366,"online_request_tracker_id":"112","online_request_procedure_id":"88","started_at":null,"ended_at":null,"next_step":"367","user_id":"52","is_completed":"0","is_rejected":null,"reason":null,"deleted_at":null,"created_at":"2021-08-12T10:01:20.000000Z","updated_at":"2021-08-13T06:32:06.000000Z","online_request":{"id":21,"user_id":"1","name":"Colorado Oliver","type":"staff","description":"Dolor doloribus quia","created_at":"2021-08-10T17:52:02.000000Z"}}
      ],
    };
  },
  computed: {
    ...mapGetters(['pending_requests']),
    user() {
      let currentUser = window.user;
      return currentUser;
    },
    notifications(){
      let n = this.notification
        return n.concat(this.pending_requests)
    }
    // pusherListner() {
    //   Echo.private("online-request-applied").listen(
    //     "OnlineRequestEvent",
    //     (e) => {
    //       this.notfication.unshift(e);
    //       console.log("from pusher: ", e);
    //     }
    //   );
    // },
  },
  methods: {
    ...mapActions(['fetchPendingRequests','acceptPendingRequest']),
    acceptRequest(request) {
      this.acceptPendingRequest(request)
      /*
      // Route::get('/online-request-applied/accept/{notification_tracker}', [\App\Http\Controllers\NotificationTrackerController::class, 'onlineRequestAccepted']);
      axios
        .get(
          `/api/online-request-applied/accept/${request.notification_tracker_id}`
        )
        .then((resp) => {
          if (resp.data[0].status == 200) {
            this.notifications = this.notifications.filter(
              (notification) =>
                notification.notification_tracker_id !=
                request.notification_tracker_id
            );
            // this.fetchAllPendingRequest();
          }
        });
        */
    },
    fetchAllPendingRequest() {
      axios
        .get("/api/online-request-applied")
        .then((resp) => {
          if (resp.data[0].status == 200) {
            let datas = resp.data[0].online_request_steps;
            datas.forEach((data) => {
              this.notifications.push(data);
            });
          }
        })
        .catch((err) => console.log(err));
    },
  },
  mounted() {
    if (this.user.type == "staff") {
      this.fetchPendingRequests()
      // this.fetchAllPendingRequest();
      /*
      Echo.private(`${this.user.id}.online-request-applied`).listen(
        "NotifyUserEvent",
        (e) => {
          this.notfications.unshift(e.onlineRequestStep);
          console.log("from pusherrrr: ", e.onlineRequestStep);
        }
      );
      */
    }
  },
};
</script>