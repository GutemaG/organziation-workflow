<template>
  <b-container>
    <b-row>
      <b-col>
        <form @submit.stop.prevent="handleSubmit">
          <b-form-group
            id="token-label"
            label="Token Key"
            label-for="token-key-input"
          >
            <b-form-input
              id="token-key-input"
              placeholder="Enter your token key"
              v-model="token"
              required
            ></b-form-input>
          </b-form-group>
          <b-button type="submit">Check</b-button>
        </form>
        <div v-if="applied_request" style="border-radius">
          <b-jumbotron>
            <template #header>
              <h3 style="font-weight: bold">
                {{ applied_request.online_request.name }}
              </h3>
              <hr />
            </template>
            <template #lead>
              {{ applied_request.online_request.description }}
            </template>
            <hr />
            <b-table
              :items="applied_request.online_request_steps"
              :fields="fields"
            >
              <template #cell(id)="row">
                <span>{{ row.index + 1 }}</span>
              </template>
              <template #cell(started_at)="row">
                <span v-if="row.item.started_at">{{
                  row.item.started_at
                }}</span>
                <span v-else>----</span>
              </template>
              <template #cell(ended_at)="row">
                <span v-if="row.item.ended_at">{{ row.item.ended_at }}</span>
                <span v-else>----</span>
              </template>
              <template #cell(is_completed)="row">
                <b-progress
                  v-if="!row.item.ended_at && row.item.started_at
                  "
                >
                  <b-progress-bar
                    :value="100"
                    label="In Progress"
                    striped
                    animated
                  >
                  </b-progress-bar>
                </b-progress>
                <b-progress v-else-if="!row.item.started_at" variant="info">
                  <b-progress-bar :value="100" label="Pending">
                  </b-progress-bar>
                </b-progress>
                <b-progress
                  v-else-if="row.item.started_at && row.item.ended_at"
                >
                  <b-progress-bar
                    :value="100"
                    label="Completed"
                    variant="success"
                    animated
                    striped
                  >
                  </b-progress-bar>
                </b-progress>
                <b-progress-bar
                  v-else
                  :value="100"
                  label="Rejected"
                  variant="danger"
                  striped
                >
                </b-progress-bar>
              </template>
            </b-table>
          </b-jumbotron>
        </div>
        <div v-else-if="error">
          <h3 style="color: red">{{ error }}</h3>
        </div>
        <div v-else>
          <h3>Enter your token key to see the result</h3>
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import moment from "moment";
export default {
  name: "check-online-request-progress",
  data() {
    return {
      token: "",
      applied_request: null,
      error: null,
      fields: [
        { label: "Id", key: "id" },
        { label: "Bureau", key: "bureau.name" },
        {
          label: "Requestd At",
          key: "created_at",
          formatter: (value) => {
            let ago = moment(value).fromNow();
            let date = moment(value).format("MMM Do, YY");
            return `${date}; ${ago}`;
          },
        },
        { label: "Started At", key: "started_at" },
        { label: "Ended At", key: "ended_at" },
        {
          label: "Status",
          key: "is_completed",
          formatter: (value) => {
            return value;
          },
        },
      ],
    };
  },
  methods: {
    handleSubmit(e) {
      this.applied_request = null;
      axios
        .get(`/api/apply-request/${this.token}`)
        .then((resp) => {
          if (resp.status == 200) {
            this.applied_request = resp.data.applied_request;
            console.log(resp.data.applied_request);
          } else {
            this.error = "Something is wrong, please try later";
          }
        })
        .catch((err) => {
          this.error =
            "We don't find your request, Please check your key again";
        });
    },
  },
};
</script>