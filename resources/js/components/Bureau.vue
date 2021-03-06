<template>
  <b-container
    fluid
    class="bg-light  mx-auto mt-2"
    style="max-height: 100%; "
  >
    <!-- User Interface controls -->
    <b-row>
      <!-- Add button -->
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Add"
          label-for="addBureau"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-3"
        >
          <b-button size="sm" @click="addBureau" class="mr-1" variant="primary">
            + Add
          </b-button>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1"> </b-col>

      <!-- Filter input and button -->
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Filter"
          label-for="filter-input"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
        >
          <b-input-group size="sm">
            <b-form-input
              id="filter-input"
              v-model="filter"
              type="search"
              placeholder="Type to Search"
            ></b-form-input>

            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''"
                >Clear</b-button
              >
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1"> </b-col>
      <!-- Pagination  -->
      <b-col sm="5" md="6" class="my-1">
        <b-form-group
          label="Per page"
          label-for="per-page-select"
          label-cols-sm="6"
          label-cols-md="4"
          label-cols-lg="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
        >
          <b-form-select
            id="per-page-select"
            v-model="perPage"
            :options="pageOptions"
            size="sm"
          ></b-form-select>
        </b-form-group>
      </b-col>

      <b-col sm="7" md="6" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="bureaus.length"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
          first-text="First"
          prev-text="Prev"
          next-text="Next"
          last-text="Last"
        ></b-pagination>
      </b-col>
    </b-row>

    <!-- Main table element -->
    <b-table
      :items="bureaus"
      :fields="bureau_fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filter-included-fields="filterOn"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      stacked="lg"
      show-empty
      small
      @filtered="onFiltered"
      striped
      bordered
      ref="listOfBureau"
    >
      <!-- <template #cell(name)="row">
        {{ row.value.first }} {{ row.value.last }}
      </template> -->
      <template #cell(id)="row">
        {{ row.index + 1 }}
      </template>
      <template #cell(description)="row">
        <p
          @click="row.toggleDetails"
          v-b-popover.hover.top="row.item.description"
          title="Description"
        >
          <!-- v-b-tooltip.hover -->
          <!-- :title="row.item.description" -->
          {{ row.item.description.substring(0, 20) }} ...
        </p>
      </template>

      <template #cell(actions)="row">
        <b-button size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? "Hide" : "Show" }} Details
        </b-button>
        <b-button
          size="sm"
          @click="info(row.item, row.index, $event.target)"
          class="mr-1"
          variant="primary"
        >
          <i class="fa fa-edit">Edit</i>
        </b-button>
        <!-- <b-button size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? "Hide" : "Show" }} Details
        </b-button> -->
        <b-button
          size="sm"
          @click="deleteBureau(row.item)"
          class="mr-1"
          variant="danger"
        >
          <i class="fa fa-trash">Delete</i>
        </b-button>
      </template>

      <template #row-details="row">
        <b-card header="Detail" header-bg-variant="dark" title="Description">
          <b-card-text>{{ row.item.description }}</b-card-text>
          <!-- <div>{{ row.item.description }}</div> -->
          <!-- <ul>
            <li v-for="(value, key) in row.item" :key="key">
              {{ key }}: {{ value }}
            </li>
          </ul> -->
        </b-card>
      </template>
    </b-table>

    <!-- Info modal -->
    <edit-bureau-modal :selectedBureau="selectedBureau"></edit-bureau-modal>
    <add-bureau-modal></add-bureau-modal>
  </b-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AddBureauModal from "./bureau/AddBureauModal.vue";
import EditBureauModal from "./bureau/EditBureauModal.vue";
import { bureau_fields } from "../table_fields";
export default {
  name:"Bureaus",
  components: {
    "add-bureau-modal": AddBureauModal,
    "edit-bureau-modal": EditBureauModal,
  },
  data() {
    return {
      bureau_fields,
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
      sortBy: "",
      sortDesc: false,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      selectedBureau: {},
    };
  },
  computed: {
    ...mapGetters(["bureaus"]),
    sortOptions() {
      // Create an options list from our fields
      return this.bureau_fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
  },
  methods: {
    ...mapActions(["fetchBureaus","removeBureau"]),
    info(item, index, button) {
      // console.log(item)
      this.selectedBureau = item;
      this.$root.$emit("bv::show::modal", "edit-bureau-modal", button);
    },
    addBureau() {
      this.$root.$emit("bv::show::modal", "add-bureau-modal");
      console.log("Creating bureau ...");
    },
    deleteBureau(item) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          this.removeBureau(item.id);
        }
      });
    },
    editBureau() {
      console.log("Editing user ...");
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  created() {
    this.fetchBureaus();
  },
};
</script>