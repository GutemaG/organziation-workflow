<template>
  <b-container fluid>
    <b-row class="mt-3">
      <b-col>
        <b-container>
          <b-alert
            variant="success"
            :show="customerToken.length != 0 && dismissCountDown"
            dismissible
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged"
          >
            <h4>Send Successfully {{dismissCountDown}}</h4>
            <hr />
            <h3>
              Your Token is <span style="color: red">{{ customerToken }}</span>
            </h3>
            <p>
              Please remember your token, It helps you to check your request
              progress.
              <br />
              Check your sms
            </p>
          </b-alert>
          <h1 style="text-align: center">ASTU ONLINE AFFAIRS</h1>
          <p>
            Here you can access our organization's affairs that can help you
            with. Below you will see list of affairs and these lists of affairs
            have thier own way of procedures that will meet your need. Go ahead
            and click the tabs to view thier description.
          </p>

          <div>
            <!-- Tabs with card integration -->
            <b-card no-body>
              <b-tabs
                active-nav-item-class="font-weight-bold bg-info text-uppercase"
                v-model="tabIndex"
                card
              >
                <b-tab title="All Affairs" lazy>
                  <online-affair-by-catagory
                    :tabIndex="tabIndex"
                  ></online-affair-by-catagory>
                </b-tab>
                <b-tab title="Student" lazy>
                  <online-affair-by-catagory
                    :tabIndex="tabIndex"
                  ></online-affair-by-catagory>
                </b-tab>
                <b-tab title="Staff" lazy>
                  <online-affair-by-catagory
                    :tabIndex="tabIndex"
                  ></online-affair-by-catagory>
                </b-tab>
                <b-tab title="Teacher" lazy>
                  <online-affair-by-catagory
                    :tabIndex="tabIndex"
                  ></online-affair-by-catagory>
                </b-tab>
                <b-tab title="Other" lazy>
                  <online-affair-by-catagory
                    :tabIndex="tabIndex"
                  ></online-affair-by-catagory>
                </b-tab>

                
              </b-tabs>
            </b-card>
          </div>
        </b-container>
      </b-col>
      <b-col cols="3">
        <div style="position: fixed">
          <b-breadcrumb>
            <b-breadcrumb-item>
              <router-link to="/"
                ><b-icon
                  icon="house-fill"
                  scale="1.25"
                  shift-v="1.25"
                  aria-hidden="true"
                ></b-icon>
                Home</router-link
              >
            </b-breadcrumb-item>
            <b-breadcrumb-item>
              <router-link to="/info">Info</router-link>
            </b-breadcrumb-item>
            <b-breadcrumb-item active>Online</b-breadcrumb-item>
          </b-breadcrumb>

          <b-card title="Title" header-tag="header" footer-tag="footer">
            <template #header>
              <h6 class="mb-0">Header Slot</h6>
            </template>
            <b-card-text>Header and footers using slots.</b-card-text>
            <b-button href="#" variant="primary">Go somewhere</b-button>
            <template #footer>
              <em>Footer Slot</em>
            </template>
          </b-card>
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import OnlineAffairByCatagory from "./OnlineAffairByCatagory.vue";
export default {
  name: "online-affair-page",
  components: { "online-affair-by-catagory": OnlineAffairByCatagory },
  data() {
    return {
      tabIndex: 0,
      dismissCountDown: 10,
      // online_affairs: [],
      // selectedAffair: null,
      // filterKey: "",
    };
  },
  computed: {
    ...mapGetters(["online_requests", "customerToken"]),
  },
  methods: {
    ...mapActions(["fetchOnlineRequests"]),
    //for alert countdown
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
      if(this.dismissCountDown == 0){
        this.customerToken == ''
      }
    },
    /*
    fetchOnlineAffairs() {
      axios.get("/api/online-requests").then((resp) => {
        this.online_affairs = resp.data.online_requests;
      });
    },
      */
  },
  created() {
    // this.fetchOnlineAffairs();
    this.fetchOnlineRequests();
  },
};
</script>