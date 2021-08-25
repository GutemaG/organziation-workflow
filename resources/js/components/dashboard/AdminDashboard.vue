<template>
  <div class="container-fluid mt-3">
    <div class="row">
      <div class="col-8">
      <h3>Users</h3>
      <p>Below is a table with the list of users with thier type of work they are placed.</p>
        <div class="leftside">
          <b-table :items="items" :fields="fields" hover bordered responsive thead-class="text-white bg-dark"></b-table>
        </div>
      </div>
      <div class="col">
        <div class="rightside">
          <div>
            <b-card-group deck>
              <b-card title="Title" header-tag="header" footer-tag="footer">
                <template #header>
                  <h6 class="mb-0">Header Slot</h6>
                </template>
                <b-card-text>Header and footers using slots.</b-card-text>
                <b-button href="#" variant="primary">Go somewhere</b-button>
                <template #footer>
                  <em>Footer Slot</em>
                </template>
              </b-card>
            </b-card-group>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    export default {
    data() {
      return {
        // Note 'isActive' is left out and will not appear in the rendered table
        fields: [
          {
            key: 'user_name',
            sortable: true,
          },
          {
            key: 'type',
            sortable: true,
          },
        ],
        items: [
          { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        ]
      }
    },
    computed: {
      userslist() {
        axios.get("/api/users")
        .then((resp) => {
          let username = resp.data.users[''].type;
          console.log(resp1);
        })
        .catch((error) => console.log(error));
        return 
      }
    },
    methods: {
      fetchUsers() {
        axios.get("/api/users")
        .then((resp) => {
          let resp1 = resp.data.users;
          console.log(resp1);
        })
        .catch((error) => console.log(error));
      }
    },
    created(){
      axios
        .get("/api/users")
        .then((resp) => {
          let resp1 = resp.data.users[''].type;
          console.log(resp1);
        })
        .catch((error) => console.log(error));
    }
  }
</script>

<style scoped>
.leftside, .rightside {
  width: 100%;
}
.bg-dark {
  background-color: rgb(0, 0, 0) ;
  color: rgb(255, 255, 255) ;
}
</style>