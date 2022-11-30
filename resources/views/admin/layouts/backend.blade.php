<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>@yield('title') - {{ env('APP_NAME') }}</title>

  <meta name="description" content="Aplikasi Pencatatan Informasi Keuangan">
  <meta name="author" content="mtrohman">
  <meta name="robots" content="noindex, nofollow">

  <!-- Open Graph Meta -->
  <meta property="og:title" content="Aplikasi Pencatatan Informasi Keuangan">
  <meta property="og:site_name" content="Codebase">
  <meta property="og:description" content="Aplikasi Pencatatan Informasi Keuangan">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Fonts and Styles -->
  @yield('css_before')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap">
  <link rel="stylesheet" id="css-main" href="{{ mix('/css/codebase.css') }}">

  <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
  <!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/corporate.css') }}"> -->
  @yield('css_after')

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
  </script>
</head>

<body>
  <!-- Page Container -->
  <!--
    Available classes for #page-container:

  GENERIC

    'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                                - Theme helper buttons [data-toggle="theme"],
                                                - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                                - ..and/or Codebase.layout('dark_mode_[on/off/toggle]')

  SIDEBAR & SIDE OVERLAY

    'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
    'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
    'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
    'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
    'sidebar-dark'                              Dark themed sidebar

    'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
    'side-overlay-o'                            Visible Side Overlay by default

    'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

    'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

  HEADER

    ''                                          Static Header if no class is added
    'page-header-fixed'                         Fixed Header

  HEADER STYLE

    ''                                          Classic Header style if no class is added
    'page-header-modern'                        Modern Header style
    'page-header-dark'                          Dark themed Header (works only with classic Header style)
    'page-header-glass'                         Light themed Header with transparency by default
                                                (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
    'page-header-glass page-header-dark'        Dark themed Header with transparency by default
                                                (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

  MAIN CONTENT LAYOUT

    ''                                          Full width Main Content if no class is added
    'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
    'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

  DARK MODE

    'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
  -->
  <div id="page-container" class="sidebar-o  side-scroll page-header-modern {{-- main-content-boxed --}} remember-theme">
    

    <!-- Sidebar -->
    <!--
      Helper classes

      Adding .smini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
      Adding .smini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition, just add the .no-transition along with one of the previous 2 classes

      Adding .smini-hidden to an element will hide it when the sidebar is in mini mode
      Adding .smini-visible to an element will show it only when the sidebar is in mini mode
      Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
    -->
    <nav id="sidebar">
      <!-- Sidebar Content -->
      <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header justify-content-lg-center">
          <!-- Logo -->
          <div>
            <span class="smini-visible fw-bold tracking-wide fs-lg">
              <span class="text-primary"></span>
            </span>
            <a class="link-fx fw-bold tracking-wide mx-auto" href="/">
              <span class="smini-hidden">
                <i class="fa fa-file-invoice text-primary"></i>
                <span class="fs-4 text-dual"> SMP N 1</span><span class="fs-4 text-primary"> Demak</span>
              </span>
            </a>
          </div>
          <!-- END Logo -->

          <!-- Options -->
          <div>
            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout" data-action="sidebar_close">
              <i class="fa fa-fw fa-times"></i>
            </button>
            <!-- END Close Sidebar -->
          </div>
          <!-- END Options -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
          
          <div class="content-side content-side-user px-0 py-0">
            <div class="smini-hidden text-center mx-auto">
              {{-- <a> --}}
                <img height="120px" class="" src={{asset('/media/images/logo.png')}} alt="">
              {{-- </a> --}}
              
            </div>
          </div>
          <!-- Side Navigation -->
          <div class="content-side content-side-full">
            <ul class="nav-main">
              
              <li class="nav-main-heading">Main Menu</li>
              <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('admin/dashboard') ? ' active' : '' }}" href="/admin/dashboard">
                  <i class="nav-main-link-icon fa fa-house-user"></i>
                  <span class="nav-main-link-name">Dashboard</span>
                </a>
              </li>
              
              <li class="nav-main-item{{ request()->is('admin/rekening*') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <i class="nav-main-link-icon fa fa-grip-vertical"></i>
                  <span class="nav-main-link-name">Kode Rekening</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/rekening*pendapatans*') ? ' active' : '' }}" href="/admin/rekening-pendapatans">
                      <span class="nav-main-link-name">Rek Pendapatan</span>
                    </a>
                  </li>

                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/rekening*pengeluarans*') ? ' active' : '' }}" href="/admin/rekening-pengeluarans">
                      <span class="nav-main-link-name">Rek Pengeluaran</span>
                    </a>
                  </li>

                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/rekening-kegiatans*') ? ' active' : '' }}" href="/admin/rekening-kegiatans">
                      <span class="nav-main-link-name">Kegiatan</span>
                    </a>
                  </li>
                  
                </ul>
              </li>

              <li class="nav-main-item {{ request()->is('admin/rka-*') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <i class="nav-main-link-icon fa fa-clipboard-check"></i>
                  <span class="nav-main-link-name">RKAS</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/rka-pendapatans*') ? ' active' : '' }}" href="/admin/rka-pendapatans">
                      <span class="nav-main-link-name">Pendapatan</span>
                    </a>
                  </li>

                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/rka-pengeluarans*') ? ' active' : '' }}" href="/admin/rka-pengeluarans">
                      <span class="nav-main-link-name">Pengeluaran</span>
                    </a>
                  </li>
                  
                </ul>
              </li>

              <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <i class="nav-main-link-icon fa fa-wallet"></i>
                  <span class="nav-main-link-name">Saldo</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="/admin/saldo-berjalan">
                      <span class="nav-main-link-name">Saldo Berjalan</span>
                    </a>
                  </li>

                  <li class="nav-main-item">
                    <a class="nav-main-link" href="/admin/saldo-awal">
                      <span class="nav-main-link-name">Saldo Awal</span>
                    </a>
                  </li>
                  
                </ul>
              </li>

              <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/penerimaan">
                  <i class="nav-main-link-icon fa fa-circle-dollar-to-slot"></i>
                  <span class="nav-main-link-name">Penerimaan</span>
                </a>
              </li>

              <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/belanja">
                  <i class="nav-main-link-icon fa fa-shopping-cart"></i>
                  <span class="nav-main-link-name">Belanja</span>
                </a>
              </li>

              <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                  <i class="nav-main-link-icon fa fa-file-lines"></i>
                  <span class="nav-main-link-name">Laporan</span>
                </a>
                
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                      <span class="nav-main-link-name">RKAS</span>
                    </a>
                    <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab3">
                          <span class="nav-main-link-name">BAB 3</span>
                        </a>
                      </li>

                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab4">
                          <span class="nav-main-link-name">BAB 4</span>
                        </a>
                      </li>

                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab5">
                          <span class="nav-main-link-name">BAB 5</span>
                        </a>
                      </li>

                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab6">
                          <span class="nav-main-link-name">BAB 6</span>
                        </a>
                      </li>
                      
                    </ul>
                  </li>

                  <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                      <span class="nav-main-link-name">Realisasi</span>
                    </a>
                    <ul class="nav-main-submenu">
                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab3">
                          <span class="nav-main-link-name">BAB 3</span>
                        </a>
                      </li>

                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab4">
                          <span class="nav-main-link-name">BAB 4</span>
                        </a>
                      </li>

                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab5">
                          <span class="nav-main-link-name">BAB 5</span>
                        </a>
                      </li>

                      <li class="nav-main-item">
                        <a class="nav-main-link" href="laporan/bab6">
                          <span class="nav-main-link-name">BAB 6</span>
                        </a>
                      </li>
                      
                    </ul>
                  </li>
                  
                </ul>
                
              </li>

              {{-- <li class="nav-main-heading">More</li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="/">
                  <i class="nav-main-link-icon fa fa-globe"></i>
                  <span class="nav-main-link-name">Landing</span>
                </a>
              </li> --}}
            </ul>
          </div>
          <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
      </div>
      <!-- Sidebar Content -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
      <!-- Header Content -->
      <div class="content-header">
        <!-- Left Section -->
        <div class="space-x-1">
          <!-- Toggle Sidebar -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
          <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-fw fa-bars"></i>
          </button>
          <!-- END Toggle Sidebar -->

          <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="dark_mode_toggle" href="javascript:void(0)">
            <i class="fa fa-burn"></i>
          </button>

          <!-- Color Themes -->
          <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-themes-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-wrench"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg p-0" aria-labelledby="page-header-themes-dropdown">
              <div class="p-3 bg-body-light rounded-top">
                <h5 class="h6 text-center mb-0">
                  Color Themes
                </h5>
              </div>
              <div class="p-3">
                <div class="row g-0 text-center">
                  <div class="col-2">
                    <a class="text-default" data-toggle="theme" data-theme="default" href="javascript:void(0)">
                      <i class="fa fa-2x fa-circle"></i>
                    </a>
                  </div>
                  <div class="col-2">
                    <a class="text-elegance" data-toggle="theme" data-theme="{{ mix('/css/themes/elegance.css') }}" href="javascript:void(0)">
                      <i class="fa fa-2x fa-circle"></i>
                    </a>
                  </div>
                  <div class="col-2">
                    <a class="text-pulse" data-toggle="theme" data-theme="{{ mix('/css/themes/pulse.css') }}" href="javascript:void(0)">
                      <i class="fa fa-2x fa-circle"></i>
                    </a>
                  </div>
                  <div class="col-2">
                    <a class="text-flat" data-toggle="theme" data-theme="{{ mix('/css/themes/flat.css') }}" href="javascript:void(0)">
                      <i class="fa fa-2x fa-circle"></i>
                    </a>
                  </div>
                  <div class="col-2">
                    <a class="text-corporate" data-toggle="theme" data-theme="{{ mix('/css/themes/corporate.css') }}" href="javascript:void(0)">
                      <i class="fa fa-2x fa-circle"></i>
                    </a>
                  </div>
                  <div class="col-2">
                    <a class="text-earth" data-toggle="theme" data-theme="{{ mix('/css/themes/earth.css') }}" href="javascript:void(0)">
                      <i class="fa fa-2x fa-circle"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END Color Themes -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="space-x-1">
          <button type="button" class="btn btn-sm btn-alt-secondary" id="TA">
              <i class="fa fa-user d-sm-none"></i>
              <span class="d-none d-sm-inline-block fw-semibold">TA : {{ Cookie::get('ta') }}</span>
          </button>
          <!-- User Dropdown -->
          <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user d-sm-none"></i>
              <span class="d-none d-sm-inline-block fw-semibold">Admin</span>
              <i class="fa fa-angle-down opacity-50 ms-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
              <div class="px-2 py-3 bg-body-light rounded-top">
                <h5 class="h6 text-center mb-0">
                  Administrator
                </h5>
              </div>
              <div class="p-2">
                <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="javascript:void(0)">
                  <span>Profile</span>
                  <i class="fa fa-fw fa-user opacity-25"></i>
                </a>
                {{-- <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span>Inbox</span>  
                  <i class="fa fa-fw fa-envelope-open opacity-25"></i>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="javascript:void(0)">
                  <span>Invoices</span>
                  <i class="fa fa-fw fa-file opacity-25"></i>
                </a> --}}
                {{-- <div class="dropdown-divider"></div> --}}
      
                <!-- Toggle Side Overlay -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                  <span>Settings</span>
                  <i class="fa fa-fw fa-wrench opacity-25"></i>
                </a>
                <!-- END Side Overlay -->
      
                <div class="dropdown-divider"></div>
                <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  <span>Sign Out</span>
                  <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </div>
            </div>
          </div>
          <!-- END User Dropdown -->

          <!-- Notifications -->
          {{-- <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-flag"></i>
              <span class="text-primary">&bull;</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications">
              <div class="px-2 py-3 bg-body-light rounded-top">
                <h5 class="h6 text-center mb-0">
                  Notifications
                </h5>
              </div>
              <ul class="nav-items my-2 fs-sm">
                
                <li>
                  <a class="text-dark d-flex py-2" href="javascript:void(0)">
                    <div class="flex-shrink-0 me-2 ms-3">
                      <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                    </div>
                    <div class="flex-grow-1 pe-2">
                      <p class="fw-medium mb-1">Please consider upgrading your plan. You are running out of space.</p>
                      <div class="text-muted">16 hours ago</div>
                    </div>
                  </a>
                </li>
                
              </ul>
              <div class="p-2 bg-body-light rounded-bottom">
                <a class="dropdown-item text-center mb-0" href="javascript:void(0)">
                  <i class="fa fa-fw fa-flag opacity-50 me-1"></i> View All
                </a>
              </div>
            </div>
          </div> --}}
          <!-- END Notifications -->

        </div>
        <!-- END Right Section -->
      </div>
      <!-- END Header Content -->

      <!-- Header Search -->
      {{-- <div id="page-header-search" class="overlay-header bg-body-extra-light">
        <div class="content-header">
          <form class="w-100" action="/dashboard" method="POST">
            @csrf
            <div class="input-group">
              <!-- Close Search Section -->
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                <i class="fa fa-fw fa-times"></i>
              </button>
              <!-- END Close Search Section -->
              <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
              <button type="submit" class="btn btn-secondary">
                <i class="fa fa-fw fa-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div> --}}
      <!-- END Header Search -->

      <!-- Header Loader -->
      <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header">
          <div class="w-100 text-center">
            <i class="far fa-sun fa-spin text-white"></i>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
      <div class="content">
        {{-- <h2 class="content-heading">
            @yield('title')
        </h2> --}}
        
        @yield('content')
      
      </div>
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer">
      <div class="content py-3">
        <div class="row fs-sm">
          <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
            Crafted with <i class="fa fa-bolt text-warning"></i> by <a class="fw-semibold" href="https://siplah.blibli.com/merchant-detail/SSSW-0004" target="_blank">Sultan's Work</a>
          </div>
          <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
            <a class="fw-semibold" href="https://mtrohman.github.io/cv" target="_blank"> Aplikasi Pencatatan Informasi Keuangan </a> SMP N 1 Demak &copy; <span data-toggle="year-copy"></span>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->
  </div>
  <!-- END Page Container -->

  <!-- Codebase Core JS -->
  <script src="{{ mix('js/codebase.app.js') }}"></script>

  <!-- Laravel Scaffolding JS -->
  <!-- <script src="{{ mix('js/laravel.app.js') }}"></script> -->

  @yield('js_after')
</body>

</html>
