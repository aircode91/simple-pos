<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $setting->name }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="icon" href="{{ url($setting->path_logo) }}" type="image/png">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('argon/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('argon/assets/css/argon-dashboard.css?v=2.0.5') }}" rel="stylesheet" />
</head>

<body
    class="g-sidenav-show bg-gray-100 {{ request()->segment(1) == 'transaksi' && request()->segment(2) == '' ? 'g-sidenav-hidden': '' }}">
    <div class="position-absolute w-100 min-height-300 top-0">
        <span class="mask bg-primary opacity-9"></span>
    </div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">

        {{-- @includeIf('layouts.header') --}}

        @includeIf('layouts.sidebar')
    </aside>
    <div class="main-content position-relative max-height-vh-100 h-100">

        @includeIf('layouts.navbar')
        <nav aria-label="breadcrumb" class="container-fluid py-4">
            <ol class="breadcrumb">
                @section('breadcrumb')
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="fa fa-dashboard"></i>
                        Home </a>
                </li>
                @show
            </ol>
        </nav>
        <!-- Main content -->
        <div class="container-fluid">


            @yield('content')

        </div>
    </div>
    {{-- @includeIf('layouts.footer') --}}


    <!--   Core JS Files   -->
    <script src="{{ asset('argon/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <!-- Kanban scripts -->
    {{-- <script src="{{ asset('argon/assets/js/plugins/dragula/dragula.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/plugins/jkanban/jkanban.js') }}"></script> --}}
    <script src="{{ asset('argon/assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/argon-dashboard.min.js?v=2.0.5') }}"></script>
    <script>
        function preview(selector, temporaryFile, width = 200)  {
            $(selector).empty();
            $(selector).append(`<img src="${window.URL.createObjectURL(temporaryFile)}" width="${width}">`);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"> </script>
    <script src="{{ asset('argon/assets/js/plugins/datatables.js') }}"></script>
    <script>
        $(document).ready(function () {
            
            new simpleDatatables.DataTable(".table", {
                searchable: false,
                fixedHeight: false,
                paging:false,
                fixedColumns:true
            });
        });
    </script>
    @stack('scripts')
</body>

</html>