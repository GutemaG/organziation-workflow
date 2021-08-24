<template>
  <div>
    <div class="m-2">
      <b-input-group>
        <b-form-input
          id="filter-input"
          type="search"
          v-model="filterKey"
          placeholder="Type to Search"
          style="max-width: 24rem"
        ></b-form-input>

        <b-input-group-append>
          <button
            type="button"
            class="btn btn-dark"
            style="border-radius: none"
            @click="filterKey = ''"
          >
            {{ tr("Clear") }}
          </button>
        </b-input-group-append>
      </b-input-group>
      <hr />
    </div>
    <b-row>
      <b-col style="height: 80vh; overflow-y: scroll">
        <h3 v-if="!filteredAffairs">Oops, No result found Please try other</h3>
        <div v-for="(affair, affair_id) in filteredAffairs" :key="affair_id">
          <div class="accordion" role="tablist">
              <div class="card collapsed-card  affair_name">
                <div class="card-header border-0 ui-sortable-handle" data-card-widget="collapse" style="cursor: move;">
                  <h3 class="card-title">
                    <b-icon icon="info-circle-fill" class="mr-3" scale="2" variant="info"></b-icon>
                    <b>{{ affair.name }}</b>
                    <br><br>
                    <span style="font-size: .8rem; ">{{affair.description.substring(0, 250)}}....</span>
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn text-white" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <!-- card tools -->
                  
                  <!-- /.card-tools -->
                </div>
                <div class="card-body" style="display: none;">
                  <h4><b>Description</b></h4>
                  <hr>
                  <p>{{affair.description}}</p>
                  <div v-for="(procedure,procedure_id) in affair.procedures" :key="procedure_id">
                    <b-card no-body class="mb-2" style="background: rgb(42,104,90); background: linear-gradient(90deg, rgba(42,104,90,1) 75%, rgba(42,104,90,1) 100%);">
                      <b-card-header class="p-0" role="tab">
                        <b-button block v-b-toggle="['procedure - '+ procedure_id+'-'+affair_id]" variant="transparent" class="p-2 text-left  procedure_name">
                          <small class="badge badge-dark">Step {{procedure.step}}</small>
                          {{procedure.name}}
                        </b-button>
                      </b-card-header>
                      <b-collapse class="text-white" :id="'procedure - '+ procedure_id+'-'+affair_id" role="tabpanel">
                        <b-card-body>
                          <div class="d-grid">
                            <h4><b>Description</b></h4>
                            <span v-if="procedure.bureau">
                              Building No: {{procedure.bureau.building_number}}
                              <br>
                              Office No: {{procedure.bureau.office_number}} 
                            </span>
                          </div>
                          <hr>
                          <p>{{procedure.description}}</p>
                          <p v-if="procedure.pre_requests.length != 0">The pre-request(s) required: </p>
                          <!-- v-if="procedure.pre_request != null" -->
                          <div v-for="(pre_request, pre_request_id) in procedure.pre_requests" :key="pre_request_id">
                            <div class="timeline">
                              <div class="d-flex align-items-center">
                                <i class="fas bg-blue">{{ pre_request_id + 1 }}</i>
                                <!-- style="overflow-y: scroll" -->
                                <div class="timeline-item" style="border-radius: .7rem; width: 100%;">
                                  <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                                  <div class="timeline-body shadow pre_request_name bg-dark" style="border-radius: .6rem .6rem 0 0;" v-b-toggle="['pre_request - '+pre_request_id+'-'+procedure_id+'-'+affair_id]">
                                    {{pre_request.name}}
                                  </div>
                                  <b-collapse :id="'pre_request - '+pre_request_id+'-'+procedure_id+'-'+affair_id">
                                    <b-card-body body-bg-variant="dark">
                                      <h4><b>Description</b></h4>
                                      <hr>
                                      <p>{{pre_request.description}}</p>
                                    </b-card-body>
                                  </b-collapse>
                                </div>
                              </div>
                            </div>
                          </div>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                  </div>
                </div>
                <!-- /.card-body-->
              </div>
          </div>
        </div>
      </b-col>
    </b-row>
   
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "info-by-category",
  props: {
    tabIndex: {
      type: Number,
      required: true,
      default: 0,
    },
  },
  data() {
    return {
      selectedAffair: null,
      //   tabIndex: 0,
      filterKey: "",
    };
  },
  computed: {
    ...mapGetters(["affairs"]),
    filteredAffairs() {
      let key = this.filterKey.toLowerCase();
      let filtered = this.affairs.filter((affair) => {
        return (
          affair.name.toLowerCase().indexOf(key) != -1 ||
          affair.description.toLowerCase().indexOf(key) != -1
        );
      });
      if (filtered.length != 0) {
        if (this.tabIndex == 0) {
          return filtered;
        }
        if (this.tabIndex == 1) {
          return filtered.filter((student) => student.type === "student");
        }
        if (this.tabIndex == 2) {
          return filtered.filter((staff) => staff.type === "staff");
        }
        if (this.tabIndex == 3) {
          return filtered.filter((teacher) => teacher.type === "teacher");
        }
        if (this.tabIndex == 4) {
          return filtered.filter((other) => other.type === "other");
        }
      } else {
        return this.filtered;
      }
    },
  },
  methods: {
    selectAffair(affair) {
      this.selectedAffair = affair;
    },
    selectedListIndex(id) {
      if (this.selectedAffair) {
        if (this.selectedAffair.id == id) {
          return true;
        }
      }
      return false;
    },
  },
};
</script>

<style scoped>
/* .affair_name{
  background: rgb(0,119,92);
  background: linear-gradient(0deg, rgba(0,119,92,1) 22%, rgba(0,119,92,1) 47%); 
} */
.affair_name{
  background:#F5F5F5;
  /* color:black; */
}
.affair_name:hover{
  background:#F0F8FF;
  /* color:black; */
}
/* .affair_name:hover{
   background: rgb(0,129,100);
background: linear-gradient(0deg, rgba(0,129,100,1) 22%, rgba(0,129,100,1) 47%); 
} */
.procedure_name{
  background: rgb(0,113,88);
  background: linear-gradient(0deg, rgba(0,113,88,1) 22%, rgba(0,113,88,1) 47%); 
}
.procedure_name:hover{
  background: rgb(48,119,103);
  background: linear-gradient(0deg, rgba(48,119,103,1) 22%, rgba(48,119,103,1) 47%); 
  color: #fff !important;
  cursor: pointer;
}
.pre_request_name:hover {
  background: rgb(75,82,89);
  background: linear-gradient(0deg, rgba(75,82,89,1) 22%, rgba(75,82,89,1) 47%); 
  color: #fff !important;
  transform: scale(1.01);
  border-radius: .7rem;
}
.items:hover {
  background-color: #3490dc !important;
  color: #fff !important;
  transform: scale(1.02);
}
</style>
