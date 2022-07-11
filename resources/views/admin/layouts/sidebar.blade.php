<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link bg-primary text-center">
      <span class="brand-text font-weight-normal">ACTI-INDIA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @hasrole('super-admin')
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @endrole
          @hasrole('Franchise-Admin')
          <li class="nav-item">
            <a href="{{ url('/customer/dashboard') }}" class="nav-link {{ Request::routeIs('customer.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('customer.franchises') }}" class="nav-link {{ Request::routeIs('customer.franchises') ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Franchises
              </p>
            </a>
          </li>
          
          @endrole
          @hasrole('Student-Admin')
          <li class="nav-item">
            <a href="{{ url('/student/dashboard') }}" class="nav-link {{ Request::routeIs('student.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('student.joinedcourse') }}" class="nav-link {{ Request::routeIs('student.joinedcourse') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Joined Courses
              </p>
            </a>
          </li>
          
          @endrole
          @canany('franchise-list','franchise-add')
          <li class="nav-item has-treeview {{ Request::routeIs('franchises.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Franchises
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('franchise-add')
              <li class="nav-item">
                <a href="{{ route('franchises.create') }}" class="nav-link {{ Request::routeIs('franchises.create') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>
                    Add
                  </p>
                </a>
              </li>
              @endcan
              @can('franchise-list')
              <li class="nav-item">
                <a href="{{ route('franchises.index') }}" class="nav-link {{ Request::routeIs('franchises.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-list"></i>
                  <p>
                    List
                  </p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @canany('course-list','course-add')
          <li class="nav-item has-treeview {{ Request::routeIs('courses.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Courses
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('course-add')
              <li class="nav-item">
                <a href="{{ route('courses.create') }}" class="nav-link {{ Request::routeIs('courses.create') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>
                    Add
                  </p>
                </a>
              </li>
              @endcan
              @can('course-list')
              <li class="nav-item">
                <a href="{{ route('courses.index') }}" class="nav-link {{ Request::routeIs('courses.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-list"></i>
                  <p>
                    List
                  </p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @canany('customer-list','customer-add')
          <li class="nav-item has-treeview {{ Request::routeIs('customers.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Customers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('customer-add')
              <li class="nav-item">
                <a href="{{ route('customers.create') }}" class="nav-link {{ Request::routeIs('customers.create') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>
                    Add
                  </p>
                </a>
              </li>
              @endcan
              @can('customer-list')
              <li class="nav-item">
                <a href="{{ route('customers.index') }}" class="nav-link {{ Request::routeIs('customers.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-list"></i>
                  <p>
                    List
                  </p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @canany('student-list','student-add')
          <li class="nav-item has-treeview {{ Request::routeIs('students.*') || Request::routeIs('customer.students.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Students
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('student-add')
              <li class="nav-item">
                <a href="@if(auth()->user()->hasRole('Franchise-Admin')){{ route('customer.students.create') }} @else {{route('students.create')}} @endif" class="nav-link {{ Request::routeIs('students.create') || Request::routeIs('customer.students.create') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>
                    Add 
                  </p>
                </a>
              </li>
              @endcan
              @can('student-list')
              <li class="nav-item">
                <a href="@if(auth()->user()->hasRole('Franchise-Admin')){{ route('customer.students.index') }} @else {{route('students.index')}} @endif" class="nav-link {{ Request::routeIs('students.index') || Request::routeIs('customer.students.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-list"></i>
                  <p>
                    List
                  </p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @canany('user-list','user-create')
          <li class="nav-item has-treeview {{ Request::routeIs('users.*')  ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('user-create')
              <li class="nav-item">
                <a href="{{ route('users.create') }}" class="nav-link {{ Request::routeIs('users.create') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>
                    Add
                  </p>
                </a>
              </li>
              @endcan
              @can('user-list')
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ Request::routeIs('users.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-list"></i>
                  <p>
                    List
                  </p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          
          @endcan
          @canany('notification-list','notification-add')
          <li class="nav-item has-treeview {{ (Request::routeIs('admin.notifications.*') || Request::routeIs('customer.notifications.*') || Request::routeIs('student.notifications.*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                  Notifications
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
              
              
              @hasanyrole('super-admin|Franchise-Admin')
              @can('notification-add')
              <li class="nav-item">
                <a href="@if(auth()->user()->hasRole('Franchise-Admin')) {{route('customer.notifications.create')}} @else {{route('notifications.create')}} @endif" class="nav-link {{ (Request::routeIs('notifications.create') || Request::routeIs('customer.notifications.create')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>
                    Create
                  </p>
                </a>
              </li>
              @endcan
              <li class="nav-item">
                <a href="@if(auth()->user()->hasRole('Franchise-Admin')) {{route('customer.notifications.sent')}} @else {{route('notifications.sent')}} @endif" class="nav-link {{ (Request::routeIs('notifications.sent') || Request::routeIs('customer.notifications.sent')) ? 'active' : '' }}">
                  <i class="nav-icon far fa-envelope"></i>
                  <p>
                    Sent
                  </p>
                </a>
              </li>
              @endhasanyrole
              <li class="nav-item">
                <a href="@if(auth()->user()->hasRole('Student-Admin')) {{route('student.notifications.index')}} @elseif(auth()->user()->hasRole('Franchise-Admin')) {{route('customer.notifications.index')}} @else {{route('notifications.index')}} @endif" class="nav-link {{ (Request::routeIs('notifications.index') || Request::routeIs('customer.notifications.index') || Request::routeIs('student.notifications.index')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-inbox"></i>
                  <p>
                    Inbox
                  </p>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          @role('Student-Admin')
          <li class="nav-item">
            <a href="{{ route('student.centers') }}" class="nav-link {{ Request::routeIs('student.centers') ? 'active' : '' }}">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Contact to center
              </p>
            </a>
          </li>
          @endrole
          @role('super-admin')
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
          @endrole
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>