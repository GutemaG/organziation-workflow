<template>
  <div class="">
    <!-- <div v-for="(procedure, index) in procedures" :key="index">
      <base-card headerVariant="dark" headerTextVariant="white">
        <b-row align-v="center" slot="header">
          <b-col cols="8">procedure-{{ index }}</b-col>
          <b-col cols="4"
            ><b-button variant="danger"><i class="fa fa-trash"></i></b-button
          ></b-col>
        </b-row>
        <b-row>
          <b-col cols="6">
            <p><span class="text-uppercase">Name:</span>{{ procedure.name }}</p>
            <p>
              <span class="text-uppercase">Description: </span
              >{{ procedure.description }}
            </p>
          </b-col>
          <b-col cols="4">
            <h4 class="mb-1">Pre Requests</h4>
            <div
              v-for="(pre_request, pre_index) in procedure.pre_requests"
              :key="pre_index"
            >
              <base-card :type="pre_index%2!==0?'dark':'light'" :textVariant="pre_index%2!==0?'white':''">
                <p>Name: {{ pre_request.name }}</p>
                <p>Description: {{ pre_request.description }}</p>
              </base-card>
            </div>
          </b-col>
        </b-row>
      </base-card>
    </div> -->
    <b-table
      :items="list_of_procedures"
      :fields="procedure_fields"
      sort-by="step"
      head-variant="dark"
      striped
      responsive
      hover
    >
      <template #cell(id)="row">
        {{ row.index + 1 }}
      </template>
      <template #cell(description)="row">
        <span v-b-tooltip.hover :title="row.item.description">
          {{ row.item.description.substring(0, 30) }}...</span
        >
      </template>
      <template #cell(actions)="row">
        <b-button
          variant="primary"
          size="sm"
          @click="editProcedure(row.item.id)"
        >
          <i class="fa fa-edit"></i>
          Edit</b-button
        >
        <!-- @click="deleteRequest(row.item.id)" -->
        <b-button
          v-if="list_of_procedures.length !== 1"
          variant="danger"
          size="sm"
          @click="deleteProcedure(row.item.id, row.item.affair_id)"
        >
          <i class="fa fa-trash"></i>
        </b-button>
      </template>

      <template #cell(pre_requests)="row">
        <span v-if="row.item.pre_requests.length == 0">no pre request</span>
        <span v-else @click="row.toggleDetails" style="cursor: pointer;display:block"
          >{{ row.item.pre_requests.length }}
          <!-- <b-table :items="row.item.pre_requests"> </b-table> -->
        </span>
      </template>
      <template #row-details="pre_row">
        <div class="container">
          <h5>Pre Requests</h5>
          <b-table
            :items="[...pre_row.item.pre_requests]"
            :fields="procedure_pre_request_fields"
            fixed
            responsive
          >
            <template #cell(id)="row">{{ row.index + 1 }}</template>
            <template #cell(name)="row">
              <span v-if="row.item.name == ''">...</span>
              <span v-else>{{ row.item.name }}</span>
            </template>
            <template #cell(description)="row">
              <span v-if="row.item.description == ''">...</span>
              <span v-else>{{ row.item.description }}</span>
            </template>
            <template #cell(affair_id)="row">
              <span v-if="row.item.affair_id == ''">...</span>
              <span v-else>
                {{ searchAffair(row.item.affair_id) }}
                <!-- {{$store.getters.findAffair([row.item.affair_id])}} -->
                <!-- {{ row.item.affair_id }} -->
              </span>
            </template>
            <template #cell(actions)="row">
              <b-button
                variant="primary"
                size="sm"
                @click="
                  editPreRequest(
                    row.item.id,
                    pre_row.item.id,
                    pre_row.item.affair_id
                  )
                "
              >
                <i class="fa fa-edit"></i>
                Edit</b-button
              >
              <b-button
                variant="danger"
                size="sm"
                @click="
                  deletePreRequest(
                    row.item.id,
                    pre_row.item.id,
                    pre_row.item.affair_id
                  )
                "
              >
                <i class="fa fa-trash"></i>
              </b-button>
            </template>
          </b-table>
        </div>
      </template>
    </b-table>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import {
  procedure_fields,
  procedure_pre_request_fields,
} from "./../../table_fields";
export default {
  props: {
    procedures: {
      type: Array,
      require: true,
    },
  },
  data() {
    return {
      list_of_procedures: this.procedures,
      procedure_fields,
      procedure_pre_request_fields,
    };
  },
  computed: {
    // ...mapGetters("findAffair"),
    isEven() {
      return "danger";
    },
  },
  methods: {
    ...mapActions(["removePreRequest", "removeProcedure", "fetchAffairs"]),
    searchAffair(id) {
      let affair = this.$store.getters.findAffair(id);
      if (affair) {
        return affair.name;
      }
      return "...";
    },
    editProcedure(id) {
      console.log("Editing", id);
    },
    deleteProcedure(procedure_id, affair_id) {
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
          this.removeProcedure({ procedure_id, affair_id });
          console.log(procedure_id, affair_id);
          this.$emit("removeProcedure", procedure_id, affair_id);
        }
      });
    },
    editPreRequest(pre_request_id, procedure_id, affair_id) {
      let ids = {
        pre_request_id: pre_request_id,
        procedure_id: procedure_id,
        affair_id: affair_id,
      };
      console.log(ids);
    },
    deletePreRequest(pre_request_id, procedure_id, affair_id) {
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
          let ids = {
            pre_request_id: pre_request_id,
            procedure_id: procedure_id,
            affair_id: affair_id,
          };
          this.removePreRequest(ids);
          let pre = this.list_of_procedures
            .find((procedure) => procedure.id == ids.procedure_id)
            .pre_requests.find(
              (pre_request) => (pre_request.id = ids.pre_request_id)
            );
          this.list_of_procedures
            .find((procedure) => procedure.id == ids.procedure_id)
            .pre_requests.splice(pre, 1);
        }
      });
    },
  },
};
</script>
