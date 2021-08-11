<template>
  <div>
    <div class="m-2">
      <b-input-group>
        <b-form-input
          id="filter-input"
          type="search"
          v-model="filterKey"
          placeholder="Type to Search"
        ></b-form-input>

        <b-input-group-append>
          <b-button @click="filterKey = ''">{{ tr("Clear") }}</b-button>
        </b-input-group-append>
      </b-input-group>
      <hr />
    </div>
    <b-row>
      <h3 v-if="!filteredAffairs">Oops, No result found Please try other  </h3>
      <b-col
        :cols="!selectedAffair ? '' : 6"
        style="height: 65vh; overflow-y: scroll"
      >
        <b-list-group v-for="affair in filteredAffairs" :key="affair.id">
          <b-list-group-item
            button
            @click="selectAffair(affair)"
            :active="selectedListIndex(affair.id)"
            class="m-1"
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
        <div v-if="selectedAffair.prerequisite_labels.length != 0">
          <b-list-group
            v-for="prerequisite in selectedAffair.prerequisite_labels"
            :key="prerequisite.id"
            style="overflow-y: scroll"
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
            <b-button class="form-control"> Send Request </b-button>
          </router-link>
        </div>
      </b-col>
    </b-row>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  name: "online-affair-by-catagory",
  props: {
    tabIndex: {
      type: Number,
      require: true,
      default: 0,
    },
  },
  data() {
    return {
      selectedAffair: null,
      filterKey: "",
      online_affairs: this.online_requests,
    };
  },
  computed: {
    ...mapGetters(["online_requests"]),
    filteredAffairs() {
      // this.selectedAffair = null
      // if (this.filterKey == null || this.filterKey == "") {
      //   return this.online_affairs;
      // }
      let key = this.filterKey.toLowerCase();
      console.log(this.onlie_requests);
      // return [];
      let filtered = this.online_requests.filter((affair) => {
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
        return this.online_affairs;
      }
    },
  },
  methods: {
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
};
</script>
