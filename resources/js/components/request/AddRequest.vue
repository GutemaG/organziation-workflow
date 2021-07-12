<template>
  <b-container>
    <b-form @submit="handleSubmit">
      <b-card
        class="m-1"
        border-variant="primary"
        header="Creating Affair"
        header-bg-variant="secondary"
      >
        <base-input
          label="Affair Name"
          labelFor="affair-name-input"
          id="affair-name-input"
          placeholder="Enter Affair Name"
          v-model="affair.name"
          required
        >
        </base-input>
        <b-form-group
          label="Description"
          lableFor="affair-description"
          class="mb-1 mt-1"
          label-for="procedure-description-input"
        >
          <b-form-textarea
            rows="3"
            v-model="affair.description"
            id="'affair-description'"
            placeholder="description for current procedure(optional)"
          ></b-form-textarea>
        </b-form-group>
        <div class="m-2">
          <div
            v-for="(procdure, procedure_index) in affair.procedures"
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
                      @click="removeProcedure(procedure_index)"
                      variant="danger"
                    >
                      <i class="fa fa-trash"></i>
                    </b-button>
                  </b-col>
                </b-row>
              </b-card-header>

              <b-row>
                <b-col cols="12" md="6">
                  <base-input
                    label="Procedure Name"
                    placeholder="Enter Procedure Name"
                    v-model="procdure.name"
                    required
                    :id="'procedure-' + procedure_index + '-description'"
                  >
                  </base-input>
                  <b-form-group
                    label="Description"
                    class="mb-1 mt-1"
                    :label-for="
                      'procedure-' + procedure_index + '-description-input'
                    "
                  >
                    <b-form-textarea
                      rows="3"
                      v-model="procdure.description"
                      :id="
                        'procedure-' + procedure_index + '-description-input'
                      "
                      placeholder="description for current procedure(optional)"
                    ></b-form-textarea>
                  </b-form-group>
                  <base-input
                    label="Step"
                    placeholder="Enter Procedure Number"
                    type="number"
                    :labelFor="'procedure-' + procedure_index + 'step-input'"
                    :id="'procedure-' + procedure_index + '-step-input'"
                    v-model="procdure.step"
                    required
                  >
                  </base-input>
                </b-col>

                <b-col>
                  <div
                    v-for="(pre_request, pre_index) in affair.procedures[
                      procedure_index
                    ].pre_requests"
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
                                removePreRequest(procedure_index, pre_index)
                              "
                              variant="outline-danger"
                            >
                              <i class="fa fa-trash"></i>
                            </b-button>
                          </b-col>
                        </b-row>
                      </b-card-header>
                      <base-input
                        label="Pre Request Name"
                        placeholder="Enter Pre request Name"
                        v-model="pre_request.name"
                        :labelFor="
                          'pre_request-' +
                          procedure_index +
                          '-' +
                          pre_index +
                          'name-input'
                        "
                        :id="
                          'pre_request-' +
                          procedure_index +
                          '-' +
                          pre_index +
                          '-name-input'
                        "
                        required
                      >
                      </base-input>
                      <b-form-group
                        label="Pre Request Description"
                        class="mb-1 mt-1"
                        :label-for="
                          'pre_request-' +
                          procedure_index +
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
                            procedure_index +
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
                        label-for="pre-request-affair-input"
                      >
                        <b-form-select
                          v-model="pre_request.affair_id"
                          id="pre-request-affair-input"
                          :options="affair_ids"
                          v-bind:disabled="
                            pre_request.name.length !== 0 ||
                            pre_request.description.length !== 0
                          "
                        >
                              <!-- v-bind:selected="
                                pre_request.name.length !== 0 ||
                                pre_request.description.length !== 0
                              " -->
                          
                          <slot  hidden>
                            <b-form-select-option
                              value=""
                              >Select Affair: if pre request is
                              affair(optional)</b-form-select-option
                            >
                          </slot>
                        </b-form-select>
                      </b-form-group>
                    </b-card>
                  </div>

                  <b-button
                    @click="addPreRequest(procedure_index)"
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
  </b-container>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      affair: {
        name: "",
        description: "",
        procedures: [
          {
            name: "",
            description: "",
            step: "",
            pre_requests: [],
          },
        ],
      },
    };
  },
  computed: {
    ...mapGetters(["affair_ids"]),
    procedureLength() {
      return this.affair.procedures.length;
    },
  },
  methods: {
    ...mapActions(["addAffair"]),
    submitHandler() {
      alert(`Thank you for your order!`);
    },
    addUser() {
      this.users.push({
        username: "",
        first_name: "",
        last_name: "",
      });
    },
    addProcedure() {
      this.affair.procedures.push({
        name: "",
        description: "",
        step: "",
        pre_requests: [],
      });
      console.log("add Procedure");
    },
    addPreRequest(preocdure_index) {
      // console.log(`add preReqeust for ${index}`);
      let pre_request = this.affair.procedures[preocdure_index].pre_requests;
      pre_request.push({
        name: "",
        description: "",
        affair_id: "",
      });
      console.log(pre_request);
    },
    removePreRequest(procedure_index, pre_index) {
      let procedure = this.affair.procedures[procedure_index].pre_requests;
      procedure.splice(pre_index, 1);
      console.log(`removed ${pre_index}`);
    },
    removeProcedure(procedure_index) {
      let procedure = this.affair.procedures;
      if (procedure.length > 1) {
        procedure.splice(procedure_index, 1);
      }
    },
    handleSubmit(event) {
      event.preventDefault();
      let data = {
        affair: this.affair,
      };
      this.addAffair(data);
      console.log(JSON.stringify(this.affair));
    },
  },
};
</script>
