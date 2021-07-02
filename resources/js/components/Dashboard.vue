<template>
  <div class="dashboard">
    <div class="row">
      <div class="col-8">
        <div class="leftside">
          <b-table :items="items" :fields="fields" hover bordered responsive thead-class="text-white bg-dark"></b-table>
          <b-table :items="items" :fields="fields" hover bordered responsive thead-class="text-white bg-dark"></b-table>
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
            key: 'first_name',
            sortable: true,
          },
          {
            key: 'last_name',
            sortable: true,
          },
          {
            key: 'age',
            label: 'Person age',
            sortable: true,
            // Variant applies to the whole column, including the header and footer
            
          }
        ],
        items: [
          { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
          { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
          { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
          { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
        ]
      }
    }
  }
</script>

<style scoped>
.dashboard {
  padding: 0%;
  margin-top: 1%;
}
.row {
  margin-left: 12px;
}
.leftside, .rightside {
  width: 100%;
}
.bg-dark {
  background-color: rgb(0, 0, 0) ;
  color: rgb(255, 255, 255) ;
}
</style>