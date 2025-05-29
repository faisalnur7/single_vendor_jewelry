  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 customer_side_nav">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Right BD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @php
              $affiliate_route = route('kyc.list');
              $affiliate_type = auth()->user()->user_affiliate_type;
              $menu_title = 'Become an Affiliate';
              $show_menu = true;
              $prime_menu = false;
              if(!empty($affiliate_type)){
                if($affiliate_type == App\Models\User::GENERAL){
                  $menu_title = 'Become Prime Affiliate';
                  $affiliate_route = route('kyc.prime');
                }

                if($affiliate_type == App\Models\User::PRIME){
                  $show_menu = false;
                  $prime_menu = true;
                }

              }
          @endphp
          @if($show_menu)
          <li class="nav-item">
            <a href="{{$affiliate_route}}" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                {{$menu_title}}
              </p>
            </a>
          </li>
          @endif

          @if($prime_menu)
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Prime Requests
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('prime_requests')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rejected Requests</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Purchase Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchases</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery Info</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sale/Use Product</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Transfer</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sale Logs</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
            {{-- <i class="fa-solid fa-file-invoice"></i> --}}
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Accounts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Affiliate Wallet</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prime Wallet</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('user.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Role Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('role.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
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