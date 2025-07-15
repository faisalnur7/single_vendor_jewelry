<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('homepage') }}" class="brand-link">
    <span class="brand-text font-weight-light">Stainless Steel Jewelry</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('homepage') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Product Management -->
        <li class="nav-item {{ menuOpen(['product.*', 'category.*', 'subcategory.*', 'childsubcategory.*', 'brand.*', 'attribute.*']) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>
              Product Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('product.list') }}" class="nav-link {{ request()->routeIs('product.*') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Products</p></a></li>
            <li class="nav-item"><a href="{{ route('category.list') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Categories</p></a></li>
            <li class="nav-item"><a href="{{ route('subcategory.list') }}" class="nav-link {{ request()->routeIs('subcategory.*') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Sub Categories</p></a></li>
            <li class="nav-item"><a href="{{ route('childsubcategory.list') }}" class="nav-link {{ request()->routeIs('childsubcategory.*') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Child Sub Categories</p></a></li>
          </ul>
        </li>
        <!-- Supplier Management -->
        <li class="nav-item {{ menuOpen(['supplier.*']) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Suppliers
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('supplier.list') }}" class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Suppliers</p>
              </a>
            </li>
          </ul>
        </li>


        <!-- Orders -->
        <li class="nav-item {{ menuOpen(['order.*']) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Orders
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('orders') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All Orders</p></a></li>
            <li class="nav-item"><a href="{{ route('order.pending') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Pending</p></a></li>
            <li class="nav-item"><a href="{{ route('order.completed') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Completed</p></a></li>
            <li class="nav-item"><a href="{{ route('order.cancelled') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Cancelled</p></a></li>
          </ul>
        </li>

        <!-- Customers -->
        <li class="nav-item {{ menuOpen(['customer.*']) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Customers
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('customer.list') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All Customers</p></a></li>
            <li class="nav-item"><a href="{{ route('customer.group') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Customer Groups</p></a></li>
          </ul>
        </li>

        <!-- Promotions -->
        <li class="nav-item {{ menuOpen(['coupon.*', 'banner.*', 'offer.*']) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tags"></i>
            <p>
              Promotions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('coupon.list') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Coupons</p></a></li>
            <li class="nav-item"><a href="{{ route('banner.list') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Banners</p></a></li>
            <li class="nav-item"><a href="{{ route('offer.list') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Offers</p></a></li>
          </ul>
        </li>

        <!-- Reports -->
        <li class="nav-item {{ menuOpen(['report.*']) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
              Reports
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('report.sales') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Sales Report</p></a></li>
            <li class="nav-item"><a href="{{ route('report.customer') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Customer Report</p></a></li>
            <li class="nav-item"><a href="{{ route('report.product') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Product Report</p></a></li>
          </ul>
        </li>

        <!-- User Management -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              User Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('user.list') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Users</p></a></li>
          </ul>
        </li>

        <!-- Role Management -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>
              Role Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('role.list') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Roles</p></a></li>
          </ul>
        </li>

        <!-- Settings -->
        <li class="nav-item {{ menuOpen(['settings.*']) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="{{ route('settings.general') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>General</p></a></li>
            <li class="nav-item"><a href="{{ route('settings.branding') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Branding</p></a></li>
            <li class="nav-item"><a href="{{ route('settings.email') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Email</p></a></li>
            <li class="nav-item"><a href="{{ route('settings.seo') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>SEO</p></a></li>
          </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a href="{{ route('admin.logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
