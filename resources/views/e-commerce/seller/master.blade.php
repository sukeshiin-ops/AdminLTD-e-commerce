<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Top Navigation</title>

    <!-- ✅ ADD THIS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('admin2/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin2/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition layout-top-nav layout-footer-fixed">
    <div class="wrapper d-flex flex-column min-vh-100">

        @include('e-commerce.nav-bar')

        <div class="content-wrapper flex-grow-1">
            @yield('product-content')
            @yield('cart-content')
            @yield('invoice-content')
            @yield('stock-content')
            @yield('attribute-content')
            @yield('edit-product-seller')
            @yield('add-seller-product-content')



        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021
                <a href="https://adminlte.io">AdminLTE.io</a>.
            </strong> All rights reserved.
        </footer>

    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    {{-- <footer class="main-footer">
            <!-- To the right -->

            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer> --}}
    </div>
    <!-- ./wrapper -->

    <!-- jQuery (needed by AdminLTE) -->
    <script src="{{ asset('admin2/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Bootstrap 5 JS Bundle CDN (includes Popper for modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('admin2/dist/js/adminlte.min.js') }}"></script>

    <!-- AdminLTE demo purposes -->
    {{-- <script src="{{ asset('admin2/dist/js/demo.js') }}"></script> --}}

</body>

</html>
