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
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user-circle"></i> {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          @if(auth()->user()->hasRole('Student-Admin'))
            <a href="{{ route('student.profile') }}" class="dropdown-item">
              <!-- <i class="fas fa- mr-2"></i> Profile -->Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('student.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form1').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form1" action="{{ route('student.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            @endif
            @if(auth()->user()->hasRole('super-admin'))
            <div class="dropdown-divider"></div>
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