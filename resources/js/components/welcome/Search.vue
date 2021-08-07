<template>
  <div>
    <b-container style="margin-top:5rem;">
      <b-row>
        <b-col xl="4" class="order-xl-2 mb-5">
          <h1>Hello</h1>
        </b-col>
        <b-col xl="8" class="order-xl-1">
          <b-form @submit.prevent="handleSubmit">
            <b-form-group label="Full Name">
              <b-form-input required> </b-form-input>
            </b-form-group>
            <b-form-group label="Pre request 1">
              <!-- :state="Boolean(file1)" -->
              <b-form-file
                v-model="file"
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
                required
              >
              </b-form-file>
              <div class="mt-3">Selected file: {{ file ? file.name : "" }}</div>
            </b-form-group>
            <b-form-group label="Pre request 2">
              <b-form-file
                v-model="file2"
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
                required
              >
              </b-form-file>
            </b-form-group>
            <b-form-group label="Pre request 3">
              <b-form-file
                v-model="file3"
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
                required
              >
              </b-form-file>
            </b-form-group>
            <b-button variant="primary" type="submit">{{
              tr("Send")
            }}</b-button>
          </b-form>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        username: "michael23",
        email: "",
        firstName: "Mike",
        lastName: "Andrew",
        address: "Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09",
      },
      file: null,
      file1: null,
      file2: null,
      file3: null,
    };
  },
  methods: {
    updateProfile() {
      alert("Your data: " + JSON.stringify(this.user));
    },
  },
};
</script>
<style scoped>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
