<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Ecommerce Dashboard &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('stisla-assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla-assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('stisla-assets/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla-assets/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla-assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="stisla-assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('stisla-assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla-assets/css/components.css') }}">
<!-- Start GA -->

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

@stack('style')
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')

      <!-- Main Content -->
      <div class="main-content">
      <div class="main-content-inner">
                <div class="main-content-padding">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
      </div>
      @include('layouts.partials.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('stisla-assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('stisla-assets/modules/popper.js') }}"></script>
  <script src="{{ asset('stisla-assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('stisla-assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('stisla-assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('stisla-assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('stisla-assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->
  <script src="{{ asset('stisla-assets/modules/jquery.sparkline.min.js')}}"></script>
  <script src="{{ asset('stisla-assets/modules/chart.min.js')}}"></script>
  <script src="{{ asset('stisla-assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('stisla-assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{ asset('stisla-assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('stisla-assets/js/page/index.js')}}"></script>
  
  <!-- Template JS File -->
  <script src="{{ asset('stisla-assets/js/scripts.js')}}"></script>
  <script src="{{ asset('stisla-assets/js/custom.js')}}"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  @stack('script')
</body>
</html>