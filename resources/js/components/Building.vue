<template>
  <b-container fluid>
    <!-- User Interface controls -->
    <b-row>
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Add"
          label-for="addBureau"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-3"
        >
        <b-button
          size="sm"
          @click="addBuilding"
          class="mr-1"
          variant="primary"
        >
          + Add
        </b-button>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1">
      </b-col>

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

      <b-col lg="6" class="my-1">
      </b-col>

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
          :total-rows="buildingLength"
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
      :items="buildings"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filter-included-fields="filterOn"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      stacked="md"
      show-empty
      small
      @filtered="onFiltered"
      striped
    >
      <!-- <template #cell(name)="row">
        {{ row.value.first }} {{ row.value.last }}
      </template> -->

      <template #cell(actions)="row">
        <b-button
          size="sm"
          @click="info(row.item, row.index, $event.target)"
          class="mr-1"
          variant="primary"
        >
          <i class="fa fa-edit">Edit</i>
        </b-button>
        <b-button
          size="sm"
          @click="deleteBuilding(row.item)"
          class="mr-1"
          variant="danger"
        >
          <i class="fa fa-trash">Delete</i>
        </b-button>
      </template>

      <template #row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">
              {{ key }}: {{ value }}
            </li>
          </ul>
        </b-card>
      </template>
    </b-table>

    <!-- Info modal -->
      <edit-building-modal :selectedBuilding="selectedBuilding"></edit-building-modal>
      <add-building-modal></add-building-modal>
  </b-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  data() {
    return {
      fields: [
        {
          key: "id",
          label: "ID",
          sortable: true,
          sortDirection: "desc",
        },
        /*{
          key: "name",
          label: "Name",
          sortable: true,
          sortDirection: "desc",
        },*/
        {
          key: "number",
          label: "Building Number",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "number_of_offices",
          label: "Number Of Office",
          sortable: true,
          sortDirection: "desc",
        },
        /*{
          key: "description",
          label: "Description",
          sortable: true,
          sortDirection: "desc",
        },*/
        { key: "actions", label: "Actions" },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 5,
      pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
      sortBy: "",
      sortDesc: false,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      selectedBuilding:{},
    };
  },
  computed: {
    ...mapGetters(['buildings']),
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
    buildingLength(){
      return this.buildings.length
    }
  },
  methods: {
    ...mapActions(['fetchBuildings']),
    info(item, index, button) {
      console.log('editttting')
      this.selectedBuilding = item;
      this.$root.$emit("bv::show::modal", "edit-building-modal", button);
    },
    addBuilding(){
        this.$root.$emit("bv::show::modal", "add-building-modal");
    },
    deleteBuilding(){
        console.log('deleting Building ..')
    },
    editBuilding(){
        console.log('Editing Building ...')
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  created(){
    this.fetchBuildings();
  }
};
</script>