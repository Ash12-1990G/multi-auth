<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link bg-primary">
      <span class="brand-text font-weight-normal center-text">Franchise Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
          <li class="nav-item">
            <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('franchises.index') }}" class="nav-link {{ Request::routeIs('franchises.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Franchise
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link {{ Request::routeIs('customers.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-store-alt"></i>
              <p>
                Customers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('students.index') }}" class="nav-link {{ Request::routeIs('students.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Students
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('courses.index') }}" class="nav-link {{ Request::routeIs('courses.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Courses
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ Request::routeIs('users.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ Request::routeIs('roles.*') || Request::routeIs('permissions.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Configuration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{ Request::routeIs('roles.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>
                    Roles
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::routeIs('permissions.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-lock"></i>
                  <p>
                    Permissions
                  </p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>