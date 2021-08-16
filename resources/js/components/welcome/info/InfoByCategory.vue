<template>
  <div>
    <div class="m-2">
      <b-input-group>
        <b-form-input
          id="filter-input"
          type="search"
          v-model="filterKey"
          placeholder="Type to Search"
          style="max-width: 24rem"
        ></b-form-input>

        <b-input-group-append>
          <button
            type="button"
            class="btn btn-dark"
            style="border-radius: none"
            @click="filterKey = ''"
          >
            {{ tr("Clear") }}
          </button>
        </b-input-group-append>
      </b-input-group>
      <hr />
    </div>
    <b-row>
      <h3 v-if="!filteredAffairs">Oops, No result found Please try other</h3>
      <b-col
        :cols="!selectedAffair ? '' : 5"
        style="height: 80vh; overflow-y: scroll"
      >
        <div class="list-group" style="height: 3.8rem">
          <div
            class="list-group"
            style="height: 3.8rem"
            v-for="(affair, index) in filteredAffairs"
            :key="affair.id"
          >
            <b-list-group-item
              @click="selectAffair(affair)"
              :active="selectedListIndex(affair.id)"
              class="d-flex mb-1 mt-1 shadow shadow-lg--hover items"
              style="
                cursor: pointer;
                border: 2px solid rgba(0, 0, 0, 0.151);
                align-items: baseline;
                overflow: hidden;
              "
            >
              <b-badge
                pill
                class="mr-2"
                style="font-size: 14px"
                variant="dark"
                >{{ index + 1 }}</b-badge
              >
              <p>
                <strong>{{ affair.name }}</strong>
              </p>
            </b-list-group-item>
          </div>
        </div>
      </b-col>
      <b-col v-if="selectedAffair" cols="7">
        <div
          class="
            card
            mb-2
            mt-2
            justify-content-md-center
            shadow
            shadow-lg--hover
          "
          style="
            max-width: 100%;
            border-radius: 1.36rem;
            border: 1px solid rgba(0, 0, 0, 0.125);
          "
        >
          <div class="card-body shadow" style="border-radius: 1.25rem">
            <div
              class="card-header text-center shadow"
              style="
                background-color: #343a40 !important;
                color: white;
                border-radius: 1.25rem 1.25rem 0rem 0;
              "
            >
              <div class="d-flex justify-content-md-center align-items-center">
                <b-icon
                  icon="file-earmark-spreadsheet-fill"
                  class="mr-3"
                  scale="2"
                  variant="success"
                ></b-icon>
                <h4 class="mb-0">{{ selectedAffair.name }}</h4>
              </div>
            </div>
            <div
              class="card-body align-items-center p-4"
              style="
                border: 1px solid rgba(0, 0, 0, 0.228);
                background-color: #ced5da;
                border-radius: 0 0 1.25rem 1.25rem;
              "
            >
              <h4><strong>Description</strong></h4>
              <hr />
              <p>{{ selectedAffair.description }}</p>

              <div class="timeline">
                <div class="time-label">
                  <span>Procedures</span>
                </div>
                <div
                  v-for="(procedure, index) in selectedAffair.procedures"
                  :key="procedure.id"
                  class="d-flex align-items-center"
                >
                  <!-- style="overflow-y: scroll" -->
                  <i class="fas bg-blue">{{ index + 1 }}</i>
                  <div class="timeline-item">
                    <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->

                    <div class="timeline-body">
                      {{ procedure.name }}
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div v-else>No Pre Request</div> -->
            </div>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
export default {
  name: "info-by-category",
  props: {
    tabIndex: {
      type: Number,
      required: true,
      default: 0,
    },
  },
  data() {
    return {
      selectedAffair: null,
    //   tabIndex: 0,
      filterKey: "",
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

<style scoped>
.timeline-header:hover {
  background-color: #007bff;
  color: #fff !important;
  transform: scale(1.03);
}
</style>