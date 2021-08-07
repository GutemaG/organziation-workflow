<template>
  <b-container fluid>
    <!-- User Interface controls -->
    <b-row>
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Add"
          label-for="addUser"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-3"
        >
          <b-button size="sm" @click="addUser" class="mr-1" variant="primary">
           + {{tr('Add')}}
          </b-button>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1"> </b-col>

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
                >{{tr('Clear')}}</b-button
              >
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1"> </b-col>

      <b-col sm="5" md="6" class="my-1">
        <b-form-group
          :label="tr('Per page')"
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
          :total-rows="userLength"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
          :first-text="tr('First')"
          :prev-text="tr('Prev')"
          :next-text="tr('Next')"
          :last-text="tr('Last')"
        ></b-pagination>
      </b-col>
    </b-row>

    <!-- Main table element -->
    <b-table
      :items="users"
      :fields="user_fields"
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
      <template #cell(id)="row">
        {{row.index + 1}}
      </template>

      <template #cell(actions)="row">
        <b-button
          size="sm"
          @click="info(row.item, row.index, $event.target)"
          class="mr-1"
          variant="primary"
        >
          <i class="fa fa-edit">{{tr('Edit')}}</i>
        </b-button>
        <!-- <b-button size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? "Hide" : "Show" }} Details
        </b-button> -->
        <b-button
          size="sm"
          @click="deleteUser(row.item)"
          class="mr-1"
          variant="danger"
        >
          <i class="fa fa-trash">{{tr('Delete')}}</i>
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
    <edit-user-modal :selectedUser="selectedUser"></edit-user-modal>
    <add-user-modal></add-user-modal>
  </b-container>
</template>

<script>
import EditModal from "./user/EditModal.vue";
import AddUserModal from "./user/AddUserModal.vue";
import { user_fields } from "../table_fields";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    "edit-user-modal": EditModal,
    "add-user-modal": AddUserModal,
  },
  data() {
    return {
      user_fields,
      totalRows: 1,
      currentPage: 1,
      perPage: 5,
      pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
      sortBy: "",
      sortDesc: false,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      selectedUser: {},
    };
  },
  computed: {
    ...mapGetters(["users"]),
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
    userLength() {
      return this.users.length;
    },
  },
  created() {
    this.$Progress.start();
    this.fetchUsers();
    this.$Progress.finish();
  },
  methods: {
    ...mapActions(["fetchUsers", "removeUser"]),

    info(item, index, button) {
      this.selectedUser = item;
      this.$root.$emit("bv::show::modal", "edit-modal", button);
    },
    addUser() {
      this.$root.$emit("bv::show::modal", "add-user-modal");
    },
    deleteUser(item) {
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
          this.removeUser(item.id);
          Swal.fire("Deleted!", "User is removed", "success");
        }
      });
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
};
</script>

<style scoped>
</style>