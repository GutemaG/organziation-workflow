<template>
  <div>
    <b-row class="">
      <b-col>
        <div>
          <b-alert
            variant="success"
            :show="customerToken.length != 0 && dismissCountDown"
            dismissible
            @dismissed="dismissCountDown = 0"
            @dismiss-count-down="countDownChanged"
          >
            <h4>Send Successfully {{ dismissCountDown }}</h4>
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
            <div class="card shadow shadow-lg--hover" style="border-radius: 1.2rem 1.2rem;">
              <div class="card-header text-center shadow" 
              style="background-color: #343a40 !important; color: white; border-radius: 1.2rem 1.2rem 0rem 0;">
                  <h2><strong>Apply Online Affair</strong></h2>
              </div>
              <b-tabs card pills no-fade vertical
                active-nav-item-class="font-weight-bold bg-info"
                v-model="tabIndex"
              >
                <b-tab title="All Affairs" lazy>
                  <online-affair-by-category
                    :tabIndex="tabIndex"
                  ></online-affair-by-category>
                </b-tab>
                <b-tab title="Student" lazy>
                  <online-affair-by-category
                    :tabIndex="tabIndex"
                  ></online-affair-by-category>
                </b-tab>
                <b-tab title="Staff" lazy>
                  <online-affair-by-category
                    :tabIndex="tabIndex"
                  ></online-affair-by-category>
                </b-tab>
                <b-tab title="Teacher" lazy>
                  <online-affair-by-category
                    :tabIndex="tabIndex"
                  ></online-affair-by-category>
                </b-tab>
                <b-tab title="Other" lazy>
                  <online-affair-by-category
                    :tabIndex="tabIndex"
                  ></online-affair-by-category>
                </b-tab>
              </b-tabs>
            </div>
          </div>
        </div>
      </b-col>
      
    </b-row>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import OnlineAffairByCategory from "./OnlineAffairByCategory.vue";
export default {
  name: "online-affair-page",
  components: { "online-affair-by-category": OnlineAffairByCategory },
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
      if (this.dismissCountDown == 0) {
        // this.$sotre.dispatch("removeToken");
        this.$store.dispatch("removeToken");
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