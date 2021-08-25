<template>
  <div class="infoHome">
    <div>
      <h1 class="text-center">INFORMATION CENTER</h1>
      <p>
        Here you can access our organization's affairs that can help you with.
        Below you will see list of affairs and these lists of affairs have their
        own way of procedures that will meet your need. Go ahead and click the
        tabs to view their description.
      </p>
    </div>
    <!-- Tabs with card integration -->
    <b-card no-body class="shadow shadow-lg--hover"
      style="border-radius: 1.2rem 1.2rem">
      <div class="card-header text-center shadow"
        style="background-color: #343a40 !important;
        color: white;
        border-radius: 1.2rem 1.2rem 0rem 0;">
        <h2><strong>Affair Information</strong></h2>
      </div>
      <b-tabs card pills no-fade vertical
        active-nav-item-class="font-weight-bold bg-info"
        v-model="tabIndex"
      >
        <b-tab title="All Affairs" lazy>
          <info-by-category
            :tabIndex="tabIndex"
          ></info-by-category>
        </b-tab>
        <b-tab title="Student" lazy>
          <info-by-category
            :tabIndex="tabIndex"
          ></info-by-category>
        </b-tab>
        <b-tab title="Staff" lazy>
          <info-by-category
            :tabIndex="tabIndex"
          ></info-by-category>
        </b-tab>
        <b-tab title="Teacher" lazy>
          <info-by-category
            :tabIndex="tabIndex"
          ></info-by-category>
        </b-tab>
        <b-tab title="Other" lazy>
          <info-by-category
            :tabIndex="tabIndex"
          ></info-by-category>
        </b-tab>
      </b-tabs>
    </b-card>
  </div>
</template>

<script>
import InfoByCategory from "./InfoByCategory.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  components: { InfoByCategory },
  name: "Affairs",
  data() {
    return {
      selectedAffair: null,
      tabIndex: 0,
      filterKey: "",
      sideicon: false
    };
  },
  computed: {
    ...mapGetters(["affairs"]),
    filteredAffairs() {
      let key = this.filterKey.toLowerCase();
      let filtered = this.affairs.filter((affair) => {
        return (
          affair.name.toLowerCase().indexOf(key) != -1 ||
          affair.description.toLowerCase().indexOf(key) != -1
        );
      });
      if (filtered.length != 0) {
        if (this.tabIndex == 0) {
          return filtered;
        }
        if (this.tabIndex == 1) {
          return filtered.filter((student) => student.type === "student");
        }
        if (this.tabIndex == 2) {
          return filtered.filter((staff) => staff.type === "staff");
        }
        if (this.tabIndex == 3) {
          return filtered.filter((teacher) => teacher.type === "teacher");
        }
        if (this.tabIndex == 4) {
          return filtered.filter((other) => other.type === "other");
        }
      } else {
        return this.filtered;
      }
    },
  },
  methods: {
    ...mapActions(["fetchAffairs"]),
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
  mounted() {
    this.fetchAffairs();
  },
};
</script>

<style scoped>

</style>