<template>
  <div class="mt-1">
    <div v-for="(procedure, index) in procedures" :key="index">
      <base-card>
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
    </div>
  </div>
</template>

<script>
export default {
  props: {
    procedures: {
      type: Array,
      require: true,
    },
  },
  computed: {
    isEven() {
      return 'danger'
    },
  },
};
</script>
