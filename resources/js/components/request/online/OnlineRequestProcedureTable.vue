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
        <ul v-for="user in user_row.item.users" :key="user.id">
          <li
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
            {{ user.user_name }}
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
        <b-button variant="primary" size="sm" >
          <i class="fa fa-edit"></i>
          Edit</b-button
        >
        <b-button variant="danger" size="sm" @click="deleteProcedure(procedure_row.item)">
          <i class="fa fa-trash"></i>
        </b-button>
      </template>
    </b-table>
  </div>
</template>
<script>
import axios from 'axios';
import { mapGetters } from "vuex";
// import {online_procedure_fields} from '../../../table_fields'
export default {
  name: "online-request-procedure-table",
  props: {
    procedures: {
      type: Array,
      require: true,
    },
    index: {
      type: Number,
      require: true,
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
    };
  },
  computed: {
    ...mapGetters(["bureaus"]),
  },
  methods: {
    searchBureau(id) {
      let bureau = this.bureaus.filter((bureau) => bureau.id == id)[0];
      return `${bureau.office_number}, ${bureau.building_number}, ${bureau.name}`;
    },
    deleteProcedure(id){
      axios.delete(`/api/online-requests/${id}`)
        .then(resp => console.log(resp))
        .catch(err => console.log(err))
    }
  },
};
</script>