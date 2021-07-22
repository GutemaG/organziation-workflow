<template>
  <div class="container-fluid">
    <b-card>
      <b-card-body>
        <div>
          <b-row>
            <b-col lg="6" class="my-1">
              <router-link to="/add-online-request" class="m-2">
                <b-button size="sm" class="mr-1" variant="primary">
                  + Add
                </b-button>
              </router-link>
            </b-col>
            <b-col lg="6" class="my-1"> </b-col>
            <b-col lg="6" class="my-1">
              <b-form-group
                label="Search"
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
                    type="search"
                    placeholder="Type to Search"
                  ></b-form-input>

                  <b-input-group-append>
                    <!-- <b-button :disabled="!filter" @click="filter = ''"
                      >Clear</b-button
                    > -->
                    <b-button>hel</b-button>
                  </b-input-group-append>
                </b-input-group>
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
                >
                  <template #first>
                    <b-form-select-option :value="totalRequests"
                      >ALL</b-form-select-option
                    >
                  </template>
                </b-form-select>
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
                    type="search"
                    placeholder="Type to Search"
                  ></b-form-input>

                  <b-input-group-append>
                    <!-- <b-button :disabled="!filter" @click="filter = ''"
                      >Clear</b-button
                    > -->
                    <b-button>hel</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>

            <b-col sm="5" md="6" class="my-1"> </b-col>
          </b-row>
        </div>
        <b-table
          :items="online_requests"
          :fields="fields"
          bordered
          :current-page="currentPage"
          :filter="filter"
          foot-clone
          foot-variant="dark"
          head-row-variant="dark"
          head-variant="dark"
          no-footer-sorting
          :per-page="perPage"
          show-empty
          small
          stacked="md"
          striped
        >
          <template #cell(id)="row">
            <b-button
              @click="row.toggleDetails"
              size="sm"
              :variant="!row.item._showDetails ? 'primary' : 'success'"
            >
              <i
                v-if="!row.item._showDetails"
                class="fas fa-angle-right small"
              ></i>
              <i v-else class="fas fa-angle-up small"></i>
            </b-button>
            {{ row.index + 1 }}
          </template>
          <template #cell(user_id)="row">
            {{ searchUser(row.item.user_id) }}
          </template>
          <template #cell(description)="row">
            <p
              @click="row.toggleDetails"
              v-b-tooltip.hover
              :title="row.item.description"
            >
              {{ row.item.description.substring(0, 20) }}...
            </p>
          </template>
          <template #cell(online_request_procedures)="row">
            {{ row.item.online_request_procedures.length }}
          </template>
          <template #cell(actions)="row">
            <router-link :to="'online-request/edit/' + row.item.id">
              <b-button variant="primary" size="sm">
                <i class="fa fa-edit"></i>
                Edit</b-button
              >
            </router-link>
            <b-button
              variant="danger"
              size="sm"
              @click="deleteRequest(row.item.id)"
            >
              <i class="fa fa-trash"></i>
            </b-button>
          </template>
          <template #row-details="row">
            <div>
              <b-jumbotron
                header="Description"
                :lead="row.item.description"
                header-level="5"
                style="padding: 1rem 2rem; margin-botttom: 0.5rem"
              >
              </b-jumbotron>
              <!-- <p>{{ row.item }}</p> -->
            </div>

            <online-request-procedure-table
              :procedures="row.item.online_request_procedures"
              :index="row.index"
            ></online-request-procedure-table>
          </template>
        </b-table>
      </b-card-body>
      <b-card-footer>
        <div>
          <b-col sm="7" md="6" class="my-1">
            <b-pagination
              v-model="currentPage"
              :total-rows="totalRequests"
              :per-page="perPage"
              size="sm"
              class="my-0"
              first-text="First"
              prev-text="Prev"
              next-text="Next"
              last-text="Last"
              last-number
              align="right"
            ></b-pagination>
          </b-col>
        </div>
      </b-card-footer>
    </b-card>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
// import {
//   online_request_fields,
//   online_request_procedure_fields,
// } from "./../table_fields";
import moment from "moment";
export default {
  name: "online-request",
  data() {
    return {
      perPage: 5,
      currentPage: 1,
      filter: null,
      pageOptions: [20, 15, 10, 5],
      fields: [
        {
          key: "id",
          label: "#",
          sortable: true,
        },
        {
          key: "user_id",
          label: "User",
          sortable: true,
          formatter: (id) => {
            return this.searchUser(id);
          },
        },
        {
          key: "name",
          label: "Name",
          sortable: true,
        },
        {
          key: "description",
          label: "Description",
        },
        {
          key: "online_request_procedures",
          label: "No Procedures",
          sortable: true,
        },
        {
          key: "created_at",
          label: "Created At",
          sortable: true,
          formatter: (value) => {
            let ago = moment(value).fromNow();
            let date = moment(value).format("MMM Do, YY");
            return `${date}, ${ago}`;
          },
        },
        {
          key: "actions",
          label: "Actions",
        },
      ],
      procedure_fields: [
        { key: "id", label: "#" },
        // { key: "online_request_id", label: "Online Request" },
        { key: "responsible_bureau_id", label: "Responsible Bureau" },
        { key: "description", label: "Description" },
        { key: "step_number", label: "Step" },
        { key: "created_at", label: "Created At" },
        { key: "users", label: "User(Responsible)" },
      ],
    };
  },
  methods: {
    ...mapActions([
      "fetchOnlineRequests",
      "fetchBureaus",
      "fetchUsers",
      "removeOnlineRequest",
    ]),
    deleteRequest(id) {
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
          this.removeOnlineRequest(id);
        }
      });
    },
    searchUser(id) {
      let us = this.users.filter((user) => user.id == id);
      if (us[0]) {
        return us[0].user_name;
      } else {
        return "admin";
      }
    },
    searchBureau(id) {
      let bureau = this.bureaus.filter((bureau) => bureau.id == id)[0];
      return `${bureau.office_number}, ${bureau.building_number}, ${bureau.name}`;
    },
  },
  computed: {
    ...mapGetters(["online_requests", "users", "bureaus"]),
    totalRequests() {
      return this.online_requests.length;
    },
  },
  created() {
    this.fetchOnlineRequests();
    this.fetchBureaus();
    this.fetchUsers();
  },

  filters: {
    formatDate(value) {
      let ago = moment(value).fromNow(); // years or day ago
      let date = moment(value).format("MMM Do YY");
      return `${date}, ${ago}`;
    },
  },
};
</script>