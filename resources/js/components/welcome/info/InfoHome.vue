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
    <div
      class="card shadow shadow-lg--hover"
      style="border-radius: 1.2rem 1.2rem"
    >
      <div
        class="card-header text-center shadow"
        style="
          background-color: #343a40 !important;
          color: white;
          border-radius: 1.2rem 1.2rem 0rem 0;
        "
      >
        <h2><strong>Affair Information</strong></h2>
      </div>
      <b-tabs
        card
        pills
        no-fade
        vertical
        active-nav-item-class="font-weight-bold bg-info"
        v-model="tabIndex"
      >
        <b-tab title="All Affairs" lazy>
          <info-by-category :tabIndex="tabIndex"></info-by-category>
        </b-tab>
        <b-tab title="Student" lazy>
          <info-by-category :tabIndex="tabIndex"></info-by-category>
        </b-tab>
        <b-tab title="Staff" lazy>
          <info-by-category :tabIndex="tabIndex"></info-by-category>
        </b-tab>
        <b-tab title="Teacher" lazy>
          <info-by-category :tabIndex="tabIndex"></info-by-category>
        </b-tab>
        <b-tab title="Other" lazy>
          <info-by-category :tabIndex="tabIndex"></info-by-category>
        </b-tab>
      </b-tabs>
    </div>
  </div>
</template>

<script>
import InfoByCategory from "./InfoByCategory.vue";
import { mapActions } from "vuex";
export default {
  components: { InfoByCategory },
  name: "Affairs",
  data() {
    return {
      //   affairs: [],
      selectedAffair: null,
      tabIndex: 0,
      filterKey: "",
    };
  },
  methods: {
    ...mapActions(["fetchAffairs"]),
  },
  mounted() {
    this.fetchAffairs();
  },
};
</script>

<style scoped>
.timeline-header:hover {
  background-color: #007bff;
  color: #fff !important;
  transform: scale(1.03);
}
</style>