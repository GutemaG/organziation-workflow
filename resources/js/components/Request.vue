<template>
  <div class="container-fluid">
    <h1>List of Request</h1>
    <b-skeleton-wrapper :loading="isLoading">
      <template #loading>
        <b-card>
          <b-spinner label="Spinning"></b-spinner>
          <b-skeleton width="85%"></b-skeleton>
          <b-skeleton width="55%"></b-skeleton>
          <b-skeleton width="70%"></b-skeleton>
        </b-card>
      </template>
      <div>
        <b-row>
          <b-col lg="6" class="my-1">
            <router-link to="/add-request" class="m-2">
              <b-button size="sm" class="mr-1" variant="primary">
                + {{ tr("Add") }}
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
                  <b-button :disabled="!filter" @click="filter = ''">{{
                    tr("Clear")
                  }}</b-button>
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
                  <b-button>{{ tr("hel") }}</b-button>
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
              ></b-form-select>
            </b-form-group>
          </b-col>

          <b-col md="6" class="my-1">
            <b-pagination
              v-model="currentPage"
              :total-rows="totalAffairs"
              :per-page="perPage"
              size="sm"
              class="my-0"
              align="fill"
              :first-text="tr('First')"
              :prev-text="tr('Prev')"
              :next-text="tr('Next')"
              :last-text="tr('Last')"
            ></b-pagination>
          </b-col>

          <b-col sm="5" md="6" class="my-1"> </b-col>
        </b-row>

        <b-table
          :items="affairs"
          :fields="request_fields"
          :current-page="currentPage"
          :per-page="perPage"
          :filter="filter"
          small
          striped
          :busy="isLoading"
          show-empty
          stacked="xl"
          label-sort-clear
          sticky-header
        >
          <template #table-busy>
            <div class="text-center text-danger my-2">
              <b-spinner class="align-middle"></b-spinner>
              <strong>{{ tr("Loading") }}...</strong>
            </div>
          </template>
          <template #cell(#)="row">
            <b-button @click="row.toggleDetails" size="sm" variant="primary">
              <i
                v-if="!row.item._showDetails"
                class="fas fa-angle-right small"
              ></i>
              <i v-else class="fas fa-angle-up small"></i>
            </b-button>
            {{ row.index + 1 }}
          </template>
          <template #cell(description)="row" @click="row.toggleDetails">
            <p
              @click="row.toggleDetails"
              id="affair-description"
              v-b-popover.hover.top="row.item.description"
              title="Description"
            >
              {{ row.item.description.substring(0, 20) }} ...
            </p>
          </template>

          <template #cell(procedures)="row" @click="row.toggleDetails">
            <span
              @click="row.toggleDetails"
              style="cursor: pointer; display: block"
              >{{ row.item.procedures.length }}</span
            >
          </template>
          <template #cell(actions)="row">
            <router-link :to="'/request/edit/' + row.item.id">
              <b-button size="sm" class="mr-1" variant="primary">
                <i class="fa fa-edit" style="color: white">
                  <span style="color: white">{{ tr("Edit") }}</span>
                </i>
              </b-button>
            </router-link>
            <b-button
              size="sm"
              @click="deleteAffair(row.item.id)"
              variant="danger"
            >
              <i class="fa fa-trash"></i>
            </b-button>
          </template>
          <template #cell(created_at)="row">
            {{ row.item.created_at | formatDate }}
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
            </div>

            <procedures
              :procedures="row.item.procedures"
              v-on:removeProcedure="removeProcedure"
            >
            </procedures>
            <!-- <b-card title="List Of procedures with their Pre request" no-body>
                <b-card-header>List of Procedures with their pre-request</b-card-header>
              </b-card> -->
          </template>
        </b-table>
      </div>
      <!-- <b-card-footer>
          <div>
            <b-col sm="7" md="6" class="my-1">
              <b-pagination
                v-model="currentPage"
                :total-rows="totalAffairs"
                :per-page="perPage"
                size="sm"
                class="my-0"
                :first-text="tr('First')"
                :prev-text="tr('Prev')"
                :next-text="tr('Next')"
                :last-text="tr('Last')"
                align="right"
              ></b-pagination>
            </b-col>
          </div>
        </b-card-footer> -->
    </b-skeleton-wrapper>
  </div>
</template>
<script>
import Procedures from "./request/Procedures.vue";
import { mapActions, mapGetters } from "vuex";
import { request_fields } from "../table_fields";
import moment from "moment";
export default {
  components: {
    Procedures,
  },
  data() {
    return {
      perPage: 10,
      currentPage: 1,
      filter: null,
      pageOptions: [
        { value: 5, text: "5" },
        { value: 10, text: "10" },
        { value: 15, text: "15" },
        { value: this.totalAffairs, text: "All" },
      ],
      request_fields,
      isLoading: true,
    };
  },
  computed: {
    ...mapGetters(["affairs"]),
    totalAffairs() {
      return this.affairs.length;
    },
  },
  methods: {
    ...mapActions(["fetchAffairs", "removeAffair"]),
    collapse(id) {
      this.$root.$emit("bv::toggle::collapse", "affair-" + id);
    },
    changePage(page) {
      this.currentPage = page;
    },
    editAffair(id) {
      console.log("editing");
    },
    deleteAffair(id) {
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
          this.removeAffair(id);
        }
      });
    },
    removeProcedure(procedure_id, affair_id) {
      console.log(procedure_id, affair_id);
      let affair = this.affairs.find((affair) => affair.id == affair_id);
      let procedure = affair.procedures.find(
        (procedure) => procedure.id == procedure_id
      );
      this.affairs
        .find((affair) => affair.id == affair_id)
        .procedures.splice(procedure, 1);
    },
  },
  created() {
    this.$Progress.start();
    if (!this.affairs) this.isLoading = true;
    this.fetchAffairs();
    this.isLoading = false;
    this.$Progress.finish();
  },
  filters: {
    formatDate(value) {
      let ago = moment(value).fromNow(); // years or day ago
      let date = moment(value).format("MMM Do YY");
      return `${date}, ${ago}`;

      /* let d = new Date(value);
      let ye = new Intl.DateTimeFormat("en", { year: "numeric" }).format(d);
      let mo = new Intl.DateTimeFormat("en", { month: "short" }).format(d);
      let da = new Intl.DateTimeFormat("en", { day: "2-digit" }).format(d);
      return `${da}-${mo}-${ye}`;
      */
    },
  },
};
</script>

<style>
.el-button {
  display: inline-block;
  line-height: 1;
  white-space: nowrap;
  background: #fff;
  background-color: #fff;
  border: 1px solid #dcdfe6;
  color: #606266;
  text-align: center;
  box-sizing: border-box;
  outline: none;
  margin: 0;
  margin-left: 0px;
  transition: 0.1s;
  font-weight: 500;
  padding: 12px 20px;
  font-size: 14px;
  border-radius: 4px;
}

.el-small {
  padding: 9px 15px;
  font-size: 12px;
  border-radius: 3px;
}
.el-primary {
  color: #fff;
  background-color: #409eff;
  border-color: #409eff;
}
.el-danger {
  color: #fff;
  background-color: #f56c6c;
  border-color: #f56c6c;
}
.el-success {
  color: #fff;
  background-color: #67c23a;
  border-color: #67c23a;
}
.el-warning {
  color: #fff;
  background-color: #e6a23c;
  border-color: #e6a23c;
}
.el-success:hover {
  background: #85ce61;
  border-color: #85ce61;
  color: #fff;
}
.el-primary:focus,
.el-primary:hover {
  background: #66b1ff;
  border-color: #66b1ff;
  color: #fff;
}

.el-info:focus,
.el-info:hover {
  background: #a6a9ad;
  border-color: #a6a9ad;
  color: #fff;
}
.el-warning:focus,
.el-warning:hover {
  background: #ebb563;
  border-color: #ebb563;
  color: #fff;
}
.el--danger:focus,
.el-danger:hover {
  background: #f78989;
  border-color: #f78989;
  color: #fff;
}
</style>

