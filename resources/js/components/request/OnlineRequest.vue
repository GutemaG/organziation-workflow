<template>
  <div>
    <router-link to="/add-online-request" class="m-2">
      <b-button size="sm" class="mr-1" variant="primary"> + Add </b-button>
    </router-link>
    <div>
      <b-list-group v-for="(request, index) in online_requests" :key="index">
        <b-row>
          <b-col class="cols-8">
            <b-list-group-item class="m-1">
              {{ request.name }}
            </b-list-group-item>
          </b-col>
          <b-col class="cols-4" md="4">
            <b-row>
              <b-button size="sm" class="m-1" variant="secondary">
                Show Detail
              </b-button>

              <router-link :to="'/online-request/edit/' + request.id" class="">
                <b-button size="sm" class="m-1" variant="primary">
                  Edit
                </b-button>
              </router-link>
              <b-button
                size="sm"
                class="m-1"
                variant="danger"
                @click="deleteRequest(request.id)"
              >
                Delete
              </b-button>
            </b-row>
          </b-col>
        </b-row>
        
      </b-list-group>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  methods: {
    ...mapActions(["fetchOnlineRequests", "fetchBureaus", "fetchUsers", "removeOnlineRequest"]),
    deleteRequest(id){
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
          this.removeOnlineRequest(id);
        }
      });
    }
  },
  computed: {
    ...mapGetters(["online_requests"]),
  },
  created() {
    this.fetchOnlineRequests();
    this.fetchBureaus();
    this.fetchUsers();
  },
};
</script>