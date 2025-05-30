<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/mycolors.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @isset(Auth::user()->level)    
        @if (Auth::user()->level === 'admin' || Auth::user()->level === 'superadmin')
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
          <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        @endif
    @endisset
    
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- Magnific Popup core JS file -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    
    {{-- script tambahan --}}
    <script src="{{ asset('assets/js/my_script.js') }}"></script>
    
    <title>{{ $title }}</title>
  </head>
  <body class="d-flex flex-column" style="height: fit-content">

    @isset(Auth::user()->level)    
      @if (Auth::user()->level === 'admin' || Auth::user()->level === 'superadmin')
        {{-- @include('partials.navbar') --}}
      @else
        @include('partials.navbar')
      @endif
    @else
    @if (Route::currentRouteName() != 'administrator-login-page')
        @include('partials.navbar')
    @endif
    @endisset

      <div class="container-fluid" id="content">
        @yield('container')
      </div>
    
    @isset(Auth::user()->level)    
      @if (Auth::user()->level === 'admin' || Auth::user()->level === 'superadmin')
        {{-- @include('partials.footer') --}}
      @else
        @include('partials.footer')
        @endif
    @else
      @include('partials.footer')
    @endisset

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    {{-- js untuk sidebar admin/superadmin --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
      function btnConfirmLogout() {
        let text = "Are you sure?";
        if (confirm(text) == true) {
          return true;
        } else {
          return false;
        }
        document.getElementById("demo").innerHTML = text;
      }
      function showPassword() {
        var x = document.getElementById("password");
        var y = document.getElementById("password_confirmation");
        var z = document.getElementById("current_password");
        if (x.type === "password") {
          x.type = "text";
          y.type = "text";
          z.type = "text";
        } else {
          x.type = "password";
          y.type = "password";
          z.type = "password";
        }
      }
      </script>

      {{-- magnific popup --}}
      <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <!-- Magnific Popup core JS file -->
      <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}"></script>

  </body>
</html>