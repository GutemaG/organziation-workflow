
<template>
  <b-container fluid class="bg-primary">
    <b-row>
      <b-col cols="2">
        <b-nav vertical class="mt-5">
          <b-nav-item> </b-nav-item>
          <b-nav-text v-for="(faq, index) in faqs" :key="index">
            <a href="#"> {{ faq.name }}-{{ faq.id }}</a>
          </b-nav-text>
        </b-nav>
      </b-col>
      <b-col cols="8" xl="8" class="mt-2 bg-gradiant-danger opacity-8">
        <h2>Request Name</h2>
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
          <b-button variant="primary" type="submit">Send</b-button>
        </b-form>
      </b-col>
    </b-row>
  </b-container>
  <!-- bd-toc col-xl-2 d-none d-xl-block -->
  <!-- // row flex-xl-nowrap2 -->
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Search",
  data() {
    return {
      faqs: [
        { name: "online affair Name", id: 1 },
        { name: "online affair Name", id: 2 },
        { name: "online affair Name", id: 3 },
        { name: "online affair Name", id: 4 },
      ],
      file: null,
      file2: null,
      file3: null,
    };
  },
  computed: {
    ...mapGetters(["affairs"]),
  },
  methods: {
    handleSubmit() {
      console.log("sending request");
    },
  },
};
</script>