<!doctype html>
<html>

<head>
    @include('includes.head')
</head>

<body>
    @include('includes.header')

    <div id="main" class="row">
        @yield('content')
    </div>
    <footer class="row">
        @include('includes.footer')
    </footer>
</body>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/aos/aos.js') }}"></script>
<script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('vendor/nouislider/nouislider.min.js') }}"></script>
<script src="{{ asset('vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>

</html>
