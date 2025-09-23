<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('homepage') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ $general_settings->site_name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Product Management -->
                <li
                    class="nav-item {{ menuOpen(['product.*', 'stock', 'category.*', 'subcategory.*', 'childsubcategory.*', 'brand.*', 'attribute.*']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Product Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ route('product.list') }}"
                                class="nav-link {{ request()->routeIs('product.*') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('category.list') }}"
                                class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('subcategory.list') }}"
                                class="nav-link {{ request()->routeIs('subcategory.*') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Sub Categories</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('childsubcategory.list') }}"
                                class="nav-link {{ request()->routeIs('childsubcategory.*') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Child Sub Categories</p>
                            </a></li>
                        <li class="nav-item">
                            <a href="{{ route('stock') }}"
                                class="nav-link {{ request()->routeIs('stock') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- Purchase Management -->
                <li class="nav-item {{ menuOpen(['supplier.*', 'purchase.*']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Purchase Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('purchase.create') }}"
                                class="nav-link {{ request()->routeIs('purchase.create') ? 'active' : '' }}">
                                <i class="fas fa-plus-square nav-icon"></i>
                                <p>Purchase Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchase.list') }}"
                                class="nav-link {{ request()->routeIs('purchase.list') ? 'active' : '' }}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>Purchase History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier.list') }}"
                                class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                                <i class="fas fa-industry nav-icon"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <!-- Orders -->
                <li class="nav-item {{ menuOpen(['orders']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Orders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ route('orders') }}"
                                class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>All Orders</p>
                            </a></li>
                    </ul>
                </li>

                <!-- Shipping Management -->
                <li class="nav-item {{ menuOpen(['shipping-methods.*']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shipping-fast"></i>
                        <p>
                            Shipping Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('shipping-methods.index') }}"
                                class="nav-link {{ request()->routeIs('shipping-methods.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Shipping Methods</p>
                            </a>
                        </li>
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
                        <li class="nav-item"><a href="{{ route('customer.list') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>All Customers</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('customer.group') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Customer Groups</p>
                            </a></li>
                    </ul>
                </li>

                <!-- Promotions -->
                <li
                    class="nav-item {{ menuOpen(['coupon.*', 'banner.*', 'offer.*']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Promotions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ route('coupon.list') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Coupons</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('banner.list') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Banners</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('offer.list') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Offers</p>
                            </a></li>
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
                        <li class="nav-item"><a href="{{ route('report.sales') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Sales Report</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('report.customer') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Customer Report</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('report.product') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Product Report</p>
                            </a></li>
                    </ul>
                </li>

                {{-- <!-- User Management -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ route('user.list') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a></li>
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
                        <li class="nav-item"><a href="{{ route('role.list') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a></li>
                    </ul>
                </li> --}}

                <!-- Settings -->
                <li
                    class="nav-item {{ menuOpen(['faq.*', 'return_policy.*', 'shipping_policy.*', 'privacy_policy.*', 'homepage_banner.*', 'settings.*', 'admin.general-settings.*', 'contact-settings.edit', 'social.edit', 'homepage.edit']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ route('admin.general-settings.edit') }}"
                                class="nav-link {{ request()->routeIs('admin.general-settings.edit') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>General</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('contact-settings.edit') }}"
                                class="nav-link {{ request()->routeIs('contact-settings.edit') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Contact & Company Info</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('social.edit') }}"
                                class="nav-link {{ request()->routeIs('social.edit') ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Social Links</p>
                            </a></li>

                        <li
                            class="nav-item {{ menuOpen(['homepage_banner.*']) ? 'menu-is-opening menu-open' : '' }}">
                            <a href="{{ route('homepage.edit') }}"
                                class="nav-link {{ request()->routeIs(['homepage.edit', 'homepage_banner.*']) ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Homepage Settings</p>
                                <i class="right fas fa-angle-left"></i>
                            </a>

                            <ul class="nav nav-treeview">
                                <!-- Location Setting Parent -->
                                <li
                                    class="nav-item {{ menuOpen(['homepage_banner.*', 'district.*', 'police-station.*', 'post-office.*', 'homepage_trending.*']) ? 'menu-is-opening menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ request()->routeIs(['homepage_banner.*', 'district.*', 'police-station.*', 'post-office.*']) ? 'bg-gray-800' : '' }}">
                                        <i class="fas fa-map-marked-alt nav-icon"></i>
                                        <p>
                                            Page Section Setting
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('homepage_banner.index') }}"
                                                class="nav-link {{ request()->routeIs('homepage_banner.*') ? 'active' : '' }}">
                                                <i class="fas fa-map nav-icon"></i>
                                                <p>Hero Section</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('homepage.edit') }}"
                                                class="nav-link {{ request()->routeIs('homepage.edit') ? 'active' : '' }}">
                                                <i class="fas fa-map nav-icon"></i>
                                                <p>About Section</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('faq.index') }}"
                                class="nav-link {{ request()->routeIs(['faq.*']) ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>FAQ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('return_policy.index') }}"
                                class="nav-link {{ request()->routeIs(['return_policy.*']) ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Return Policy</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('shipping_policy.index') }}"
                                class="nav-link {{ request()->routeIs(['shipping_policy.*']) ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Shipping Policy</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('privacy_policy.index') }}"
                                class="nav-link {{ request()->routeIs(['privacy_policy.*']) ? 'active' : '' }}"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Privacy Policy</p>
                            </a>
                        </li>

                        <li class="nav-item"><a href="{{ route('settings.branding') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Branding</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('subscribers') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Subscriber Emails</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('settings.seo') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>SEO</p>
                            </a></li>
                        <li class="nav-item"><a href="{{ route('cache.setting') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>
                                <p>Cache</p>
                            </a></li>
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
