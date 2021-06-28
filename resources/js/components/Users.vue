<template>
  <b-container fluid>
    <!-- User Interface controls -->
    <b-row>
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Sort"
          label-for="sort-by-select"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
          v-slot="{ ariaDescribedby }"
        >
          <b-input-group size="sm">
            <b-form-select
              id="sort-by-select"
              v-model="sortBy"
              :options="sortOptions"
              :aria-describedby="ariaDescribedby"
              class="w-75"
            >
              <template #first>
                <option value="">-- none --</option>
              </template>
            </b-form-select>

            <b-form-select
              v-model="sortDesc"
              :disabled="!sortBy"
              :aria-describedby="ariaDescribedby"
              size="sm"
              class="w-25"
            >
              <option :value="false">Asc</option>
              <option :value="true">Desc</option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1">
        <b-form-group
          label="Initial sort"
          label-for="initial-sort-select"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
        >
          <b-form-select
            id="initial-sort-select"
            v-model="sortDirection"
            :options="['asc', 'desc', 'last']"
            size="sm"
          ></b-form-select>
        </b-form-group>
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
        <b-form-group
          v-model="sortDirection"
          label="Filter On"
          description="Leave all unchecked to filter on all data"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
          v-slot="{ ariaDescribedby }"
        >
          <b-form-checkbox-group
            v-model="filterOn"
            :aria-describedby="ariaDescribedby"
            class="mt-1"
          >
            <b-form-checkbox value="name">Name</b-form-checkbox>
            <b-form-checkbox value="age">Age</b-form-checkbox>
            <b-form-checkbox value="isActive">Active</b-form-checkbox>
          </b-form-checkbox-group>
        </b-form-group>
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
          :total-rows="userLength"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
        ></b-pagination>
      </b-col>
    </b-row>

    <!-- Main table element -->
    <b-table
      :items="users"
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
    >
      <template #cell(name)="row">
        {{ row.value.first }} {{ row.value.last }}
      </template>

      <template #cell(actions)="row">
        <b-button
          size="sm"
          @click="info(row.item, row.index, $event.target)"
          class="mr-1"
          variant="primary"
        >
          <i class="fa fa-edit">Edit</i>
        </b-button>
        <b-button size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? "Hide" : "Show" }} Details
        </b-button>
        <b-button
          size="sm"
          @click="deleteUser(row.item)"
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
    <b-modal
      id="edit-modal"
      title="Edit"
      ok-title="Update"
      @ok="updateForm"
      @hide="resetInfoModal"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group id="user_name" label="Username" label-for="username-input">
          <b-form-input
            id="username-input"
            v-model="selectedUser.user_name"
            placeholder="Username"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="first_name" label="First Name" label-for="first_name-input">
          <b-form-input
            id="first_name-input"
            v-model="selectedUser.first_name"
            placeholder="enter first name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="last_name" label="Last Name" label-for="last_name-input">
          <b-form-input
            id="last_name-input"
            v-model="selectedUser.last_name"
            placeholder="enter last name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          id="email"
          label="Email address:"
          label-for="email-input"
        >
          <b-form-input
            id="email-input"
            v-model="selectedUser.email"
            type="email"
            placeholder="Enter email"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group id="phone" label="phone" label-for="phone-input">
          <b-form-input
            id="phone-input"
            v-model="selectedUser.phone"
            placeholder="phone(+251... or 09 )"
            required
          ></b-form-input>
        </b-form-group>
      </form>
    </b-modal>
  </b-container>
</template>

<script>
import axios from "axios";
import { mapGetters, mapActions } from 'vuex';
export default {
  data() {
    return {
      fields: [
        { key: "id", label: "Id", sortable: true, sortDirection: "desc" },
        {
          key: "user_name",
          label: "Username",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "first_name",
          label: "First Name",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "last_name",
          label: "Last Name",
          sortable: true,
          sortDirection: "desc",
        },
        { key: "email", label: "email" },
        { key: "phone", label: "Phone", sortable: true, sortDirection: "desc" },
        {
          key: "age",
          label: "Person age",
          sortable: true,
          class: "text-center",
        },
        {
          key: "is_active",
          label: "Is Active",
          formatter: (value, key, item) => {
            return value === "1" ? "Yes" : "No";
          },
          sortable: true,
          sortByFormatted: true,
          filterByFormatted: true,
        },
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
      infoModal: {
        id: "info-modal",
        title: "",
        content: "",
      },
      selectedUser: {},
    };
  },
  computed: {
    ...mapGetters(['users']),
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
    userLength(){
      return this.users.length
    }
  },
  mounted() {
  },
  created() {
    this.$Progress.start();
    this.fetchUsers();
    this.$Progress.finish();
  },
  methods: {
    ...mapActions(["fetchUsers"]),

    info(item, index, button) {
      this.infoModal.title = `Row index: ${index}`;
      this.infoModal.content = JSON.stringify(item, null, 2);
      this.selectedUser = item;
      this.$root.$emit("bv::show::modal", "edit-modal", button);
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
          axios
            .delete(`api/users/${item.id}`)
            .then(() => {
              Swal.fire("Deleted!", "User is removed", "success");
              this.users = this.users.filter((user) => user.id !== item.id);
              // this.fetchUser();
            })
            .catch((data) => {
              Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },
    resetModal() {
      this.selectedUser = {};
    },
    resetInfoModal() {
      this.infoModal.title = "";
      this.infoModal.content = "";
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    updateForm(event){
      event.preventDefault();
        axios.put(`api/users/${this.selectedUser.id}`, {
          ...this.selectedUser
      })
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    onSubmit(event) {
      event.preventDefault();
      console.log("submitttion");
    },
    onReset(event) {
      event.preventDefault();
      console.log("resting");
    },
  },
};
</script>

<style scoped>

</style>