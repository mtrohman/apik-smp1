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
  <div id="page-container" class="main-content-boxed remember-theme">
    <!-- Main Container -->
    <main id="main-container">
      @yield('content')
    </main>
    <!-- END Main Container -->
  </div>
  <!-- END Page Container -->

  <!-- Codebase Core JS -->
  <script src="{{ mix('js/codebase.app.js') }}"></script>

  <!-- Laravel Original JS -->
  <!-- <script src="{{ mix('js/laravel.app.js') }}"></script> -->

  @yield('js_after')
</body>

</html>
