<template>
  <div class="container-fluid">
    <b-table
      head-variant="dark"
      striped
      dark
      hover
      sort-by="step_number"
      :items="procedures"
      :fields="online_procedure_fields"
    >
      <template #cell(id)="row">
        {{ row.index + 1 }}
      </template>
      <template #cell(responsible_bureau_id)="row">
        <span v-b-tooltip.hover title="office, building, name">{{
          searchBureau(row.item.responsible_bureau_id)
        }}</span>
      </template>
      <template #cell(description)="row">
        <!-- <p>{{row}}</p> -->
        <p
          v-b-tooltip.hover
          :title="row.item.description"
          v-if="row.item.description !== null"
        >
          {{ row.item.description.substring(0, 20) }}...
        </p>
        <p v-else>...</p>
      </template>
      <template #cell(users)="user_row">
        <ul v-for="(user,i) in user_row.item.users" :key="user.id">
          <li
            class="user-list"
            v-b-tooltip.hover
            :id="
              'responsible-user-list' +
              user.id +
              '' +
              user_row.index +
              '' +
              index
            "
          >
            <span class="user-list-value">{{i + 1}} {{ user.user_name }}</span>
            <b-tooltip
              title="Info"
              boundary-padding="0"
              :target="
                'responsible-user-list' +
                user.id +
                '' +
                user_row.index +
                '' +
                index
              "
              triggers="hover"
            >
              <b-list-group>
                <b-list-group-item variant="dark"
                  ><span style="font-weight: bold">userName:</span>
                  {{ user.user_name }}</b-list-group-item
                >
                <b-list-group-item variant="dark"
                  ><span style="font-weight: bold"> Name: </span
                  ><span style="font-style: italic"
                    >{{ user.first_name }} {{ user.last_name }}</span
                  ></b-list-group-item
                >
                <b-list-group-item variant="dark"
                  ><span style="font-weight: bold"> Phone: </span
                  ><span style="font-style: italic">{{
                    user.phone
                  }}</span></b-list-group-item
                >
                <b-list-group-item variant="dark"
                  ><span style="font-weight: bold"> email: </span
                  ><span style="font-style: italic">{{
                    user.email
                  }}</span></b-list-group-item
                >
              </b-list-group>
            </b-tooltip>
          </li>
        </ul>
      </template>

      <template #cell(actions)="procedure_row">
        <b-button
          variant="primary"
          size="sm"
          v-b-modal="'edit-online-procedure-' + procedure_row.item.id"
        >
          <i class="fa fa-edit"></i>
          <!-- v-b-modal="'edit-online-request-label-' + label.id" -->
          Edit</b-button
        >
        <b-button
          variant="danger"
          v-if="procedures.length > 1"
          size="sm"
          @click="
            deleteProcedure(
              procedure_row.item.id,
              procedure_row.item.online_request_id
            )
          "
        >
          <i class="fa fa-trash"></i>
        </b-button>
        <edit-online-request-procedure
          :procedure="procedure_row.item"
        ></edit-online-request-procedure>
      </template>
    </b-table>
  </div>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";
import EditOnlineRequestProcedure from "./EditOnlineRequestProcedure.vue";
// import {online_procedure_fields} from '../../../table_fields'
export default {
  components: { EditOnlineRequestProcedure },
  name: "online-request-procedure-table",
  props: {
    procedures: {
      type: Array,
      require: true,
    },
    index: {
      type: Number,
      require: true,
      description: "it is for purpose of identifying the currect row of table",
    },
  },
  data() {
    return {
      // online_procedure_fields,
      online_procedure_fields: [
        { key: "id", label: "#" },
        // { key: "online_request_id", label: "Online Request" },
        { key: "responsible_bureau_id", label: "Responsible Bureau" },
        { key: "description", label: "Description" },
        { key: "step_number", label: "Step" },
        { key: "created_at", label: "Created At" },
        { key: "users", label: "User(Responsible)" },
        { key: "actions", label: "Actions" },
      ],
      editProcedureData: {
        name: "",
        description: "",
      },
    };
  },
  computed: {
    ...mapGetters(["bureaus", "online_requests"]),
  },
  methods: {
    searchBureau(id) {
      let bureau = this.bureaus.filter((bureau) => bureau.id == id)[0];
      return `${bureau.office_number}, ${bureau.building_number}, ${bureau.name}`;
    },
    deleteProcedure(procedure_id, request_id) {
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
            .delete(`/api/online-procedures/${procedure_id}`)
            .then((resp) => {
              if (resp.status == 200) {
                let index = this.procedures.findIndex(
                  (pro) => pro.id == procedure_id
                );
                this.$emit("remove-procedure", request_id, index);
              }
            })
            .catch((err) => console.log(err));
        }
      });
    },
    updateProcedure() {
      console.log(this.editProcedureData);
    },
  },
};
</script>
<style scoped>
.user-list{
  list-style: none;
}
.user-list:hover {
  background-color:#141212;
}
</style>