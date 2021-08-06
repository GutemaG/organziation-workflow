<template>
  <b-container>
    <router-link to="/requests" class="m-2">
      <b-button size="sm" class="mr-1" variant="primary">back</b-button>
    </router-link>
    <b-form @submit="handleSubmit">
      <b-card
        class="m-1"
        border-variant="primary"
        :header="'Edit Affair-' + $route.params.id"
        header-bg-variant="secondary"
      >
        <b-form-group
          label="Affair Name"
          label-for="selected-affair-name-input"
        >
          <b-form-input
            id="selected-affair-name-input"
            v-model="selectedAffair.name"
            placeholder="Enter Affair Name"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label="Affair Type"
          class="mb-1 mt-1"
          label-for="description-input"
        >
          <b-form-select v-model="selectedAffair.type" id="affair-type-input">
            <b-form-select-option value=""
              >Selecte affair type
            </b-form-select-option>
            <b-form-select-option value="student">Student</b-form-select-option>
            <b-form-select-option value="staff">Staff</b-form-select-option>
            <b-form-select-option value="teacher">Teacher</b-form-select-option>
            <b-form-select-option value="other">Other</b-form-select-option>
          </b-form-select>
        </b-form-group>

        <b-form-group
          label="Description"
          lableFor="affair-description"
          class="mb-1 mt-1"
          label-for="procedure-description-input"
        >
          <b-form-textarea
            rows="3"
            v-model="selectedAffair.description"
            id="'affair-description'"
            placeholder="description for current procedure(optional)"
          ></b-form-textarea>
        </b-form-group>
        <div class="m-2">
          <div
            v-for="(procedure, procedure_index) in selectedAffair.procedures"
            :key="procedure_index"
          >
            <b-card class="m-1" border-variant="light">
              <b-card-header header-bg-variant="dark">
                <b-row>
                  <b-col cols="10" md="9"
                    >Procedure - {{ procedure_index }}</b-col
                  >
                  <b-col cols="3">
                    <b-button
                      v-if="procedureLength > 1"
                      @click="deleteProcedure(procedure_index, procedure.id)"
                      variant="danger"
                    >
                      <i class="fa fa-trash"></i>
                    </b-button>
                  </b-col>
                </b-row>
              </b-card-header>

              <b-row>
                <b-col cols="12" md="6">
                  <b-form-group
                    label="Procedure Name"
                    :label-for="'procedure-' + procedure_index + '-description'"
                  >
                    <b-form-input
                      :id="'procedure-' + procedure_index + '-description'"
                      v-model="procedure.name"
                      placeholder="Enter Procedure Name"
                      required
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    label="Description"
                    class="mb-1 mt-1"
                    :label-for="
                      'procedure-' + procedure_index + '-description-input'
                    "
                  >
                    <b-form-textarea
                      rows="3"
                      v-model="procedure.description"
                      :id="
                        'procedure-' + procedure_index + '-description-input'
                      "
                      placeholder="description for current procedure(optional)"
                    ></b-form-textarea>
                  </b-form-group>
                  <b-form-group
                    label="Step"
                    :label-for="'procedure-' + procedure_index + 'step-input'"
                  >
                    <b-form-input
                      :id="
                        'procedure-' +
                        procedure.id +
                        '-' +
                        procedure_index +
                        '-description'
                      "
                      v-model="procedure.step"
                      placeholder="Enter Procedure Step number"
                      type="number"
                      required
                    ></b-form-input>
                  </b-form-group>
                </b-col>

                <b-col>
                  <div
                    v-for="(pre_request, pre_index) in selectedAffair
                      .procedures[procedure_index].pre_requests"
                    :key="pre_index"
                  >
                    <b-card class="m-1" border-variant="light">
                      <b-card-header
                        header-bg-variant="info"
                        header-border-variant="success"
                      >
                        <b-row>
                          <b-col cols="8"> Pre Request </b-col>
                          <b-col cols="4">
                            <b-button
                              @click="
                                deletePreRequest(
                                  procedure_index,
                                  pre_index,
                                  pre_request.id,
                                  procedure.id
                                )
                              "
                              variant="outline-danger"
                            >
                              <i class="fa fa-trash"></i>
                            </b-button>
                          </b-col>
                        </b-row>
                      </b-card-header>
                      <b-form-group
                        label="Pre Request Name"
                        :label-for="
                          'pre_request-' +
                          procedure_index +
                          '-' +
                          pre_index +
                          'name-input'
                        "
                      >
                        <b-form-input
                          :id="
                            'pre_request-' +
                            pre_request.id +
                            '-' +
                            pre_index +
                            '-name-input'
                          "
                          v-model="pre_request.name"
                          placeholder="Enter Pre Request Name"
                          required
                        ></b-form-input>
                      </b-form-group>

                      <b-form-group
                        label="Pre Request Description"
                        class="mb-1 mt-1"
                        :label-for="
                          'pre_request-' +
                          pre_request.id +
                          '-' +
                          pre_index +
                          '-description'
                        "
                      >
                        <b-form-textarea
                          rows="3"
                          v-model="pre_request.description"
                          :id="
                            'pre_request-' +
                            pre_request.id +
                            '-' +
                            pre_index +
                            '-description'
                          "
                          placeholder="description for current procedure(optional)"
                        ></b-form-textarea>
                      </b-form-group>
                      <b-form-group
                        id="pre-request-affair"
                        label="Select Affair"
                        :label-for="
                          'pre-request-affair-input-' +
                          procedure_index +
                          '-' +
                          pre_index
                        "
                      >
                        <!-- label-for="pre-request-affair-input" -->
                        <b-form-select
                          v-model="pre_request.affair_id"
                          :options="affair_ids"
                          :id="
                            'pre-request-affair-input-' +
                            procedure_index +
                            '-' +
                            pre_index
                          "
                          v-bind:disabled="
                            pre_request.name.length !== 0 ||
                            pre_request.description.length !== 0
                          "
                        >
                          <b-form-select-option
                            value=""
                            v-bind:selected="
                              pre_request.name.length !== 0 ||
                              pre_request.description.length !== 0
                            "
                            >Select Affair: if pre request is
                            affair(optional)</b-form-select-option
                          >
                        </b-form-select>
                      </b-form-group>
                    </b-card>
                  </div>

                  <b-button
                    @click="addPreRequest(procedure.id)"
                    variant="primary"
                    class="m-1"
                  >
                    +Pre Request
                  </b-button>
                </b-col>
              </b-row>
            </b-card>
          </div>
          <b-button @click="addProcedure" class="form-control" variant="dark">
            +Procedure
          </b-button>
        </div>
      </b-card>
      <b-button type="submit" class="form-control" variant="outline-primary"
        >Submit</b-button
      >
    </b-form>

    <add-pre-request
      v-if="isAddingPreRequest"
      :procedure_id="selected_procedure_id"
      :affair_id="selectedAffair.id"
    ></add-pre-request>
    <add-procedure :affair_id="selectedAffair.id"></add-procedure>
  </b-container>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import AddProcedure from "./AddProcedure.vue";
import AddPreRequest from "./AddPreRequest.vue";
// import store from '@/'
export default {
  components: {
    "add-procedure": AddProcedure,
    "add-pre-request": AddPreRequest,
  },
  props: ["id"],
  data() {
    return {
      affair_id: this.$route.params.id,
      selectedAffair: {},
      selected_procedure_id: "",
      isAddingPreRequest: false,
    };
  },
  computed: {
    ...mapGetters(["affairs", "affair_ids"]),
    selectedAffair2() {
      return this.selectedAffair;
    },
    procedureLength() {
      return this.selectedAffair.procedures.length;
    },
  },
  methods: {
    ...mapActions([
      "addAffair",
      "fetchAffairs",
      "updateAffair",
      "removePreRequest",
      "removeProcedure",
    ]),
    submitHandler() {
      alert(`Thank you for your order!`);
    },
    handleSubmit(event) {
      event.preventDefault();
      let data = {
        affair: this.selectedAffair,
      };
      this.updateAffair(data);
      this.$router.go(-1);
      // console.log(JSON.stringify(data));
    },
    addProcedure() {
      console.log("adding Procedurrrrre");
      this.$root.$emit("bv::show::modal", "add-procedure");
    },
    deleteProcedure(procedure_index, procedure_id) {
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
          let affair_id = this.selectedAffair.id;
          this.removeProcedure({ procedure_id, affair_id });
          console.log(this.selectedAffair.id, procedure_id);
          let pro = this.selectedAffair.procedures;
          pro.splice(procedure_index, 1);
        }
      });
    },
    addPreRequest(procedure_id) {
      this.selected_procedure_id = procedure_id;
      this.isAddingPreRequest = true;
      this.$root.$emit("bv::show::modal", "add-pre-request");
    },
    deletePreRequest(procedure_index, pre_index, pre_request_id, procedure_id) {
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
          this.removePreRequest({ pre_request_id, procedure_id });
          let pre =
            this.selectedAffair.procedures[procedure_index].pre_requests;
          pre.splice(pre_index, 1);
        }
      });
    },
  },
  created() {
    if (this.affairs.length === 0) {
      this.$router.push("/requests");
      console.log(this.$route.path);
    } else {
      if (this.selectedAffair) {
        this.selectedAffair = this.affairs.filter(
          (affair) => affair.id == this.affair_id
        )[0];
      }
    }
  },
};
</script>
