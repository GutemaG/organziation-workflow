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
      </b-col>
      <b-col>
        <h1>Result</h1>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
export default {
  data() {
    return {
      token: "",
    };
  },
  methods: {
    handleSubmit(e) {
      console.log(this.token);
    },
  },
};
</script>