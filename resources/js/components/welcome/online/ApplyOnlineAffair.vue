<template>
  <div class="container">
    <b-alert
      variant="danger"
      class="position-fixed fixed-top m-0 rounded-0"
      :show="error != null"
      style="z-index: 2000"
      dismissible
    >
      <h4>{{ error }}</h4>
    </b-alert>
    <div class="">
      <div class="d-grid justify-content-md-center">
        <div
          class="text-center"
          v-if="selected.online_request_prerequisite_notes.length != 0"
        >
          <h3 class="note font-italic">Important Note</h3>
          <div
            v-for="(note, index) in selected.online_request_prerequisite_notes"
            :key="index"
          >
            <p class="text-danger">{{ note.note }}</p>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <b-card style="width: 80%">
            <b-form
              @submit.prevent="handleSubmit"
            >
              <b-form-group
                id="full-name-input-label"
                label="Full Name"
                label-for="full-name-input"
              >
                <b-form-input
                  id="full-name-input"
                  placeholder="Enter Your full Name"
                  v-model="$v.form.full_name.$model"
                  :state="validateState('full_name')"
                  required
                ></b-form-input>
              </b-form-group>

              <b-form-group
                id="phone-number-label"
                label="Phone number"
                label-for="phone-number-input"
              >
                <b-form-input
                  id="phone-number-input"
                  placeholder="Enter your phone number +2519.. or 09..."
                  v-model="$v.form.phone_number.$model"
                  :state="validateState('phone_number')"
                  required
                ></b-form-input>
              </b-form-group>
              <div v-for="(input, index) in form.prerequisites" :key="index">
                <div class="form-group">
                  <label :for="'perquisite_input-' + index">{{
                    input.name
                  }}</label>
                  <input
                  v-if="input.type!='file'"
                    :type="input.type"
                    class="form-control"
                    v-model="form.prerequisites[index].value"
                    :id="'perquisite_input-' + index"
                    :placeholder="'Enter -' + input.name"
                    :name="input.name"
                    required
                  />
                  <input 
                  v-if="input.type=='file'"
                    type="file"
                    class="form-control"
                    :id="'perquisite_input-' + index"
                    :placeholder="'Enter -' + input.name"
                    v-on:change="uploadFile"
                    :name="input.name"
                    required
                    
                  />
                    <!-- v-on:change="uploadFile" -->
                </div>
              </div>
              <b-button
                type="submit"
                variant="primary"
                :disabled="$v.$invalid || isLoading"
              >
                <span v-if="!isLoading">{{ tr("Send") }}</span>
                <b-spinner v-show="isLoading" label=""></b-spinner>
              </b-button>
            </b-form>
          </b-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { required } from "vuelidate/lib/validators";
// import store from "../../../store";
export default {
  name: "apply-online-affair",
  data() {
    return {
      selected: null,
      form: {
        full_name: "",
        email: "",
        phone_number: "",
        prerequisites: [],
      },
      token: "",
      isLoading: false,
      error: null,
    };
  },
  watch: {
    selected() {
      if (!this.selected) {
        this.$router.go(-1);
      }
    },
  },
  computed: {
    ...mapGetters(["findRequest"]),
    arrangePrerequisites() {
      let prerequisites = this.form.prerequisites.map((pre) => {
        return {
          name: pre.name,
          value: pre.value,
        };
      });
      // return prerequisites
      let mapped = {};
      for (let i = 0; i < prerequisites.length; i++) {
        // let di = {};
        let name = prerequisites[i].name;
        let value = prerequisites[i].value
        if(value instanceof File){
          mapped[name] = value
        }
        else{
          mapped[name] = value
        }
        // mapped[value] = value
        // di[name] = value
        // mapped.push(di)
      }
      // console.log('computed: ',mapped[1])
      return mapped;
    },
  },
  methods: {
    validateState(value) {
      // return true
      const { $dirty, $error } = this.$v.form[value];
      return $dirty ? !$error : null;
    },
    handleSubmit() {
      this.isLoading = true;
      let data = { ...this.form };
      data["prerequisites"] = this.arrangePrerequisites;
      axios
        .post("/api/apply-request", {
          ...data,
          online_request_id: this.selected.id,
        })
        .then((resp) => {
          if (resp.data.status == 200) {
            this.$store.dispatch("setToken", resp.data.token);
            this.$router.go(-1);
          } else {
            this.error = "Something is wrong, please try again";
            this.isLoading = false;
          }
        })
        .catch((err) => console.log(err));
      // this.isLoading = false;
    },
    uploadFile(e) {
        let inputIndex = this.form.prerequisites.findIndex(
          (input) => input.name == e.target.name
        );
        if (inputIndex !== -1) {
          this.form.prerequisites[inputIndex].value = e.target.files[0];
          console.log(e.target.files[0])
        }
        // console.log('upload ',this.form.prerequisites[1].type)
    },
  },
  created() {
    // let req = store.getters.findRequest(this.$route.params.slug);
    // this.selected = this.findRequest(this.$route.params.slug);
    this.selected = this.$route.params.request;
    let pre = this.selected.online_request_prerequisite_inputs;
    if (pre.length != 0) {
      for (let i = 0; i < pre.length; i++) {
        this.form.prerequisites.push({
          name: pre[i].name,
          value: null,
          type: pre[i].type,
          input_id: pre[i].input_id,
        });
      }
    }
    console.log(this.selected);

    // this.selected = result;
  },
  validations: {
    form: {
      full_name: {
        required,
      },
      phone_number: {
        name: required,
      },
    },
  },
};
</script>
<style scoped>
.note {
  color: red;
}
</style>
