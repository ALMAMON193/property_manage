@php
    $setting = \App\Models\Setting::first();
@endphp


<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset($setting->logo ?? 'logo.png') }}" alt="" height="25">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset($setting->logo ?? 'logo.png') }}" alt="" height="25">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset($setting->logo ?? 'logo.png') }}" alt="" height="25">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset($setting->logo ?? 'logo.png') }}" alt="" height="25">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center gap-2">
                        <img class="rounded header-profile-user" src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                        <span class="text-start">
                            <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                            <span class="d-block fs-14 sidebar-user-name-sub-text"><i class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span class="align-middle">Online</span></span>
                        </span>
                    </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome Anna!</h6>
            <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
            <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
        </div>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">


            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>



                <li class="nav-item">
                    <a class="nav-link menu-link{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"  aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>

                </li> <!-- end Dashboard Menu -->

                {{--=========================== Category START ==================--}}
                {{--<li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.category.*') ? 'active' : '' }}" href="{{ route('admin.category.index') }}" role="button" aria-expanded="false" aria-controls="tips_care">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Categories</span>
                    </a>
                </li>--}} <!-- end Dashboard Menu -->
                {{--=========================== Category END ==================--}}


                {{--=========================== Add Key-feautre START ==================--}}
                {{--<li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.key_feature.*') ? 'active' : 'collapsed' }}" href="#key_feature" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Key Feature</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.key_feature.*') ? 'show' : '' }}" id="key_feature">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('admin.key_feature.index') }}" class="nav-link {{ Request::routeIs('admin.key_feature.index') ? 'active' : '' }}" data-key="t-chat"> All key features </a>
                            </li>

                            <li class="nav-item ">
                                <a href="{{ route('admin.key_feature.create') }}" class="nav-link {{ Request::routeIs('admin.key_feature.create') ? 'active' : '' }}" data-key="t-api-key">Add key features</a>
                            </li>
                        </ul>
                    </div>
                </li>--}} <!-- end Key Feature Menu -->
                {{--=========================== Add Key-feautre END ==================--}}


                {{--=========================== Product START ==================--}}
                {{--<li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.product.*') ? 'active' : 'collapsed' }}" href="#product" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">Products</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.product.*') ? 'show' : '' }}" id="product">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('admin.product.index') }}" class="nav-link {{ Request::routeIs('admin.product.index') ? 'active' : '' }}" data-key="t-chat"> All products </a>
                            </li>

                            <li class="nav-item ">
                                <a href="{{ route('admin.product.create') }}" class="nav-link {{ Request::routeIs('admin.product.create') ? 'active' : '' }}" data-key="t-api-key">Add product</a>
                            </li>
                        </ul>
                    </div>
                </li>--}} <!-- end Key Feature Menu -->
                {{--=========================== Product END ==================--}}


                {{--=========================== Retailer START ==================--}}
                {{--<li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.retailer.*') ? 'active' : '' }}" href="{{ route('admin.retailer.index') }}" role="button" aria-expanded="false" aria-controls="tips_care">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">All Retailer</span>
                    </a>
                </li>--}}
                {{--=========================== Retailer END ==================--}}


                {{--=========================== Contact List START ==================--}}
                {{--<li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.contact.*') ? 'active' : '' }}" href="{{ route('admin.contact.index') }}" role="button" aria-expanded="false" aria-controls="tips_care">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Contact List</span>
                    </a>
                </li>--}} <!-- end Dashboard Menu -->
                {{--=========================== Contact List END ==================--}}

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.user.*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}" role="button" aria-expanded="false" aria-controls="tips_care">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">All users</span>
                    </a>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.subscribe.*') ? 'active' : '' }}" href="{{ route('admin.subscribe.index') }}" role="button" aria-expanded="false" aria-controls="tips_care">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Payments</span>
                    </a>
                </li>

                {{--=========================== Setting START ==================--}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.setting.*') ? 'active' : 'collapsed' }}" href="#setting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-settings-4-line"></i> <span data-key="t-apps">Settings</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::routeIs('admin.setting.*') ? 'show' : '' }}" id="setting">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('admin.setting.appSetting.edit') }}" class="nav-link {{ Request::routeIs('admin.setting.appSetting.edit') ? 'active' : '' }}" data-key="t-chat"> App Setting </a>
                            </li>

                            <li class="nav-item ">
                                <a href="" class="nav-link {{ Request::routeIs('admin.product.create') ? 'active' : '' }}" data-key="t-api-key">Stripe Setting</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Setting Menu -->
                {{--=========================== Setting END ==================--}}







            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
