<template>
  <div>
    <div class="m-2">
      <b-input-group>
        <b-form-input
          id="filter-input"
          type="search"
          v-model="filterKey"
          placeholder="Type to Search"
          style="max-width: 24rem;"
        ></b-form-input>

        <b-input-group-append>
          <button type="button" class="btn btn-dark" style="border-radius: none;" @click="filterKey = ''">{{ tr("Clear") }}</button>
        </b-input-group-append>
      </b-input-group>
      <hr />
    </div>
    <b-row>
      <b-col
        style="height: 80vh; overflow-y: scroll"
      >
        <h3 v-if="!filteredAffairs">Oops, No result found Please try other</h3>
        <div v-for="affair in filteredAffairs" :key="affair.id">
          <div class="accordion" role="tablist">
            <div class="card collapsed-card  online_affair_name">
              <div class="card-header border-0 ui-sortable-handle" data-card-widget="collapse" style="cursor: move;">
                <h3 class="card-title" block
                @click="selectAffair(affair)">
                  <b-icon icon="check2-circle" class="mr-3" scale="2" variant="primary"></b-icon>
                  <b>{{ affair.name }}</b>
                  <br><br>
                  <span style="font-size: .8rem; ">{{affair.description.substring(0, 250)}}....</span>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn text-white" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus blue"></i>
                  </button>
                </div>
                <!-- card tools -->
                
                <!-- /.card-tools -->
              </div>
              <div v-if="affair.description.length != 0" class="card-body" style="display: none;">
                <h4><b>Description</b></h4>
                <hr>
                <p>{{affair.description}}</p>
                <p v-if="affair.prerequisite_labels !=0">Prerequisite required are: </p>
                <div v-for="(prerequisite_labels, prerequisite_labels_id) in affair.prerequisite_labels" :key="prerequisite_labels_id">
                  <div class="timeline">
                    <div class="d-flex align-items-center">
                      <i class="fas bg-blue">{{ prerequisite_labels_id + 1 }}</i>
                      <!-- style="overflow-y: scroll" -->
                      <div class="timeline-item" style="border-radius: .7rem;">
                        <!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
                        <div class="timeline-body shadow pre_request_name online_prerequest_name text-white" style="border-radius: .6rem .6rem 0 0;" v-b-toggle="['prerequisite_labels - '+prerequisite_labels_id+''+affair.id]">
                          {{ prerequisite_labels.label }}
                        </div>
                        <b-collapse :id="'prerequisite_labels - '+prerequisite_labels_id+''+affair.id">
                          <b-card-body class="online_prerequest_name text-white">
                            <h4><b>Description</b></h4>
                            <hr>
                            <p>{{prerequisite_labels.label}}</p>
                          </b-card-body>
                        </b-collapse>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="">
                  <router-link
                  :to="{
                    name: 'apply-online-affair2',
                    params: { slug: affair.name,request:affair }}"
                  style="text-decoration: none;">
                    <b-button pill block variant="primary" class="form-control"> Send Request </b-button>
                  </router-link>
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
import { mapGetters } from "vuex";
export default {
  name: "online-affair-by-category",
  props: {
    tabIndex: {
      type: Number,
      require: true,
      default: 0,
    },
  },
  data() {
    return {
      selectedAffair: null,
      filterKey: "",
      online_affairs: this.online_requests,
    };
  },
  computed: {
    ...mapGetters(["online_requests"]),
    filteredAffairs() {
      let key = this.filterKey.toLowerCase();
      let filtered = this.online_requests.filter((affair) => {
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
        return this.online_affairs;
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

 .online_affair_name{
  background:#f4f4f4;
  }
 .online_affair_name:hover{
  background:#e4e4e4cc;
  }
.online_prerequest_name{
  background:#d4d4d4;
  background: linear-gradient(90deg, rgba(61,88,115,1) 33%, rgba(61,88,115,1) 65%); 
}
.online_prerequest_name:hover {
  background:#c7c4c4;
  cursor: pointer;
  transform: scale(1.01);
  border-radius: .7rem;
}
</style>
