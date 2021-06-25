<template>
  <div class="dashboard">
    <div class="row">
      <div class="col-8">
        <div class="leftside">
          <div class="header">
            <h2>List Of Buildings</h2>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Block</th>
                <th scope="col">Added By</th>
                <th scope="col">Location</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Larry the Bird</td>
                <td>@twitter</td>
                <td>@twitter</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
          <div class="header">
            <h2>List Of Affairs</h2>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Block</th>
                <th scope="col">Added By</th>
                <th scope="col">Location</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Larry the Bird</td>
                <td>@twitter</td>
                <td>@twitter</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
          <div class="header">
            <h2>List Of bureaucracy</h2>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Block</th>
                <th scope="col">Added By</th>
                <th scope="col">Location</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Larry the Bird</td>
                <td>@twitter</td>
                <td>@twitter</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col">
        <div class="rightside">
          <div class="card">
            <div class="card-header text-white bg-dark text-center">
              Todays Tasks
            </div>
            <div class="card-body">
              <h5 class="card-title">Lists of bureaucracy works involved</h5>
              <p class="card-text">
                <ul>
                  <li>Lorem</li>
                  <li>Lorem</li>
                  <li>Lorem</li>
                </ul>
              </p>
              <p class="card-text">
                With supporting text below as a natural lead-in to additional content.
              </p>
              <div class="text-center">
                <a href="#" class="btn btn-primary">Update</a>
              </div>
            </div>
            <div class="card-footer text-muted text-center">
              2 days ago
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
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
</style>