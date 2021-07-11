<template>
  <b-container>
    <router-link to="/add-request" class="m-2">
      <b-button size="sm" class="mr-1" variant="primary"> + Add </b-button>
    </router-link>
        
    <div>
      <b-list-group v-for="(affair, index) in affairs" :key="index" >
        <b-row>
          <b-col class="cols-8">
            <b-list-group-item class="m-1" @click="collapse(index)">
              {{ affair.name }}
            </b-list-group-item>
          </b-col>
          <b-col class="cols-4" md="4">
            <b-row>
              <b-button size="sm" class="m-1" variant="secondary">
                Show Detail
              </b-button>

              <router-link :to="'/request/edit/'+affair.id" class="">
                <b-button size="sm" class="m-1" variant="primary">
                  Edit
                </b-button>
              </router-link>
              <b-button size="sm" class="m-1" variant="danger" @click="deleteAffair(affair.id)">
                Delete
              </b-button>
            </b-row>
          </b-col>
        </b-row>
        <b-collapse :id="'affair-' + index">
          <div>
            <b-card-group deck>
              <b-card
                border-variant="primary"
                header="Primary"
                header-bg-variant="primary"
                header-text-variant="white"
                align="center"
              >
                <b-card-text
                  >Lorem ipsum dolor sit amet, consectetur adipiscing
                  elit.</b-card-text
                >
              </b-card>

              <b-card
                border-variant="secondary"
                header="Secondary"
                header-border-variant="secondary"
                align="center"
              >
                <b-card-text
                  >Lorem ipsum dolor sit amet, consectetur adipiscing
                  elit.</b-card-text
                >
              </b-card>

              <b-card border-variant="success" header="Success" align="center">
                <b-card-text
                  >Lorem ipsum dolor sit amet, consectetur adipiscing
                  elit.</b-card-text
                >
              </b-card>
            </b-card-group>
          </div>
        </b-collapse>
      </b-list-group>
    </div>
  </b-container>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      perPage: 10,
      currentPage: 1,
    };
  },
  computed: {
    ...mapGetters(["affairs"]),
    total_affairs() {
      return this.affairs.length;
    },
  },
  methods: {
    ...mapActions(["fetchAffairs", "removeAffair"]),
    collapse(id) {
      this.$root.$emit("bv::toggle::collapse", "affair-" + id);
    },
    edit(affair){
      console.log('editing');
    },
    deleteAffair(id) {
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
          this.removeAffair(id)
        }
      });
    }

  },
  created() {
    this.fetchAffairs();
  },
  // mounted() {
  //   this.$root.$on("bv::collapse::state", (collapseId, isJustShown) => {
  //     console.log("collapseId:", collapseId);
  //     console.log("isJustShown:", isJustShown);
  //   });
  // },
 
 

  /** 
   <b-col sm="7" md="6" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="total_affairs"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
          first-text="First"
          prev-text="Prev"
          next-text="Next"
          last-text="Last"
          aria-controls="itemList"
        ></b-pagination>
      </b-col>
      */
};
</script>
