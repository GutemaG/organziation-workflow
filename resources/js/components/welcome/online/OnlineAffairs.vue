<template>
  <b-container fluid>
    <b-row class="mt-3">
      <b-col>
        <b-container>
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
                <b-tab title="All Affairs" v-b-scrollspy:nav-scroller>
                  <div>
                    <div class="m-2">
                      <b-input-group>
                        <b-form-input
                          id="filter-input"
                          type="search"
                          placeholder="Type to Search"
                        ></b-form-input>

                        <b-input-group-append>
                          <b-button :disabled="!filter">{{
                            tr("Clear")
                          }}</b-button>
                        </b-input-group-append>
                      </b-input-group>
                      <hr />
                    </div>
                    <b-row>
                      <b-col :cols="!selectedAffair ? '' : 6">
                        <b-list-group
                          v-for="affair in online_affairs"
                          :key="affair.id"
                        >
                          <b-list-group-item
                            button
                            @click="selectAffair(affair)"
                            :active="selectedListIndex(affair.id)"
                          >
                            <h3>
                              {{ affair.name }}
                            </h3>
                            <small>{{ affair.description }}</small>
                          </b-list-group-item>
                        </b-list-group>
                      </b-col>
                      <b-col v-if="selectedAffair" cols="6">
                        <h1>{{ selectedAffair.name }}</h1>
                        <hr />
                        <h4>Description:</h4>
                        <p>{{ selectedAffair.description }}</p>
                        <hr />
                        <h3>Pre Requests</h3>
                        <div
                          v-if="selectedAffair.prerequisite_labels.length != 0"
                        >
                          <b-list-group
                            v-for="prerequisite in selectedAffair.prerequisite_labels"
                            :key="prerequisite.id"
                          >
                            <b-list-group-item>
                              {{ prerequisite.label }}
                            </b-list-group-item>
                          </b-list-group>
                        </div>
                        <div v-else>
                          <h4>No Pre Request</h4>
                        </div>
                        <div>
                          <router-link
                            :to="{
                              name: 'apply-online-affair2',
                              params: { slug: selectedAffair.name },
                            }"
                          >
                            <b-button class="form-control">
                              Send Request
                            </b-button>
                          </router-link>
                        </div>
                      </b-col>
                    </b-row>
                  </div>
                </b-tab>
                <b-tab title="Student">
                  <h1>List of Affair that associate with Student</h1>
                </b-tab>
                <b-tab title="Staff">
                  <h1>List of Affair that associate with Staff</h1>
                </b-tab>
                <b-tab title="Teacher">
                  <h1>List of Affair that associate with Teacher</h1>
                </b-tab>
                <b-tab title="Hulegeb">
                  <h1>List of Affair that associate with all</h1>
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
export default {
  name: "online-affair-page",
  data() {
    return {
      tabIndex: 0,
      online_affairs: [],
      selectedAffair: null,
    };
  },
  computed: {
    affairOnly() {
      if (this.selectedAffair) {
        delete this.selectedAffair["users"];
      }
    },
  },
  methods: {
    fetchOnlineAffairs() {
      axios.get("/api/online-requests").then((resp) => {
        this.online_affairs = resp.data.online_requests;
      });
    },
    selectAffair(affair) {
      this.selectedAffair = affair;
    },
    selectedListIndex(id) {
      if (this.selectedAffair) {
        if (this.selectedAffair.id == id) {
          return true;
        }
      }
      return false;
    },
  },
  created() {
    this.fetchOnlineAffairs();
  },
};
</script>