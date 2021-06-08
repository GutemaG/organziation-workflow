
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/dashboard" class="brand-link">
      <img src="{{ asset('/images/astu.jpg') }}" alt="The Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </router-link>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
     <router-link to="/profile">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
          <img src="{{ asset('/images/astu.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          {{ Auth::user()->name }}
          <span class="d-block text-muted">
            {{ Ucfirst(Auth::user()->type) }}
          </span>
          {{-- <a href="#" class="d-block">Alexander Pierce</a> --}}
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item menu-open">
            //TODO: You can delte this li item 
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li> --}}

          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>
            Some Link
          </p>
        </router-link>
      </li>

      @can('is-admin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Users</p>
          </router-link>
        </li>
      @endcan

      @can('is-admin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Link
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                Other Link
              </p>
            </router-link>
          </li>
          
            <li class="nav-item">
              <router-link to="/" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                    also another
                  </p>
              </router-link>
            </li>
        </ul>
      </li>
      @endcan

      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>

      
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>