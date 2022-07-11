<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>


    <!-- Right navbar links -->
    @auth
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item">
                            
        @if(isset($notification)) 
        <a class="nav-link" href="@if(auth()->user()->hasRole('Student-Admin')) {{route('student.notifications.index')}} @elseif(auth()->user()->hasRole('Franchise-Admin')) {{route('customer.notifications.index')}} @else {{route('notifications.index')}} @endif"><i class="fa fa-bell"></i>
        @if($notification>0)
          <span class="position-absolute translate-middle badge rounded-pill bg-danger">
          
            @if($notification>99)
            {{$notification}}+
            @else
            {{$notification}}
            @endif
            
          </span>
          @endif
          </a>
          @endif
      
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user-circle"></i> {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          @if(auth()->user()->hasRole('Student-Admin'))
            <a href="{{ route('student.profile') }}" class="dropdown-item">
              <!-- <i class="fas fa- mr-2"></i> Profile -->Profile
            </a>
            <div class="dropdown-divider m-0"></div>
            <a class="dropdown-item" href="{{ route('student.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form1').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form1" action="{{ route('student.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            @endif
            @if(auth()->user()->hasRole('Franchise-Admin'))
            <a href="{{ route('customer.profile') }}" class="dropdown-item">
              <!-- <i class="fas fa- mr-2"></i> Profile -->Profile
            </a>
         
            <div class="dropdown-divider m-0"></div>
            <a class="dropdown-item" href="{{ route('customer.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            @endif
            @if(auth()->user()->hasRole('super-admin'))
            <a href="{{ route('admin.changepassword') }}" class="dropdown-item">
              <!-- <i class="fas fa- mr-2"></i> Profile -->Change Password
            </a>
            <div class="dropdown-divider m-0"></div>
            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            @endif
         
        </div>
      </li>
     
     
    </ul>
    @endauth
  </nav>