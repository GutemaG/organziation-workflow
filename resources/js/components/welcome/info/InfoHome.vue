<template>
  <b-container fluid>
    <b-row class="mt-3">
      <b-col>
        <b-container>
          <h1 style="text-align: center">INFORMATION CENTER</h1>
          <p>
            Here you can access our organization's affairs that can help you
            with. Below you will see list of affairs and these lists of affairs
            have thier own way of procedures that will meet your need. Go ahead
            and click the tabs to view thier description.
          </p>
          <div style="height: 100vh">
            <!-- Tabs with card integration -->
            

            <!-- {{ affairs }} -->
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
                Home
              </router-link>
            </b-breadcrumb-item>
            <b-breadcrumb-item>
              <router-link to="/online"> Online </router-link>
            </b-breadcrumb-item>
            <b-breadcrumb-item active>Info</b-breadcrumb-item>
          </b-breadcrumb>

          <div>
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
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      tabIndex: 0,
      isVisible: false, // starts un-collapsed
      affairs: [],
      procedures: [],
    };
  },
  computed: {
    // ...mapGetters(['affairs']),
    affairNames() {
      let names = this.affairs.map((affair) => {
        return {
          name: affair.name,
          id: affair.id,
        };
      });
      return names;
    },
  },
  methods: {
    // ...mapActions(['fetchAffairs']),
    getAffairs() {
      axios.get("/api/affairs").then((resp) => {
        // console.log(resp.data);
        // console.log(resp.data.affairs.procedures)
        this.affairs = resp.data.affairs;
        // this.procedures = resp.data.affairs.procedures;
      });
    },
  },
  created() {
    // this.fetchAffairs()
    // this.$store.dispatch('fetchAffairs')
    this.getAffairs();
  },
};
</script>
