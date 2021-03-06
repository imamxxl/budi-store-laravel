<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('template') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('template') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('template') }}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/iCheck/all.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('template') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('template') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- add icon link -->
    <link rel="icon" href="{{ url('logo/logo-unp.png') }}" type="image/x-icon">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('template') }}/dist/css/skins/_all-skins.min.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="{{ asset('template') }}/dist/css/googleapis.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="#" class="logo">
                <span class="logo-mini">BDS</span>
                <span class="logo-lg"><b>Budi</b>Store</span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src=" {{ url('avatar/' . Auth::user()->avatar) }}" class="user-image"
                                    alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->nama }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src=" {{ url('avatar/' . Auth::user()->avatar) }}" class="img-circle"
                                        alt="User Image">
                                    <p>
                                        {{ Auth::user()->nama }}
                                        <small>{{ Auth::user()->username }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            <button type="submit" class="btn btn-default btn-flat">Log out</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>


        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ url('avatar/' . Auth::user()->avatar) }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->nama }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> {{ Auth::user()->level }}</a>
                    </div>
                </div>

                @yield('bagian-nav')
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    @yield('judul-halaman')
                    <small>Budi Store</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">@yield('navigasi-satu')</a></li>
                    <li><a href="#">@yield('navigasi-dua')</a></li>
                    <li class="#">@yield('navigasi-tiga')</li>
                </ol>
            </section>


            <section class="content">
                @yield('isi-konten')
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.15
            </div>
            <strong>Copyright &copy; 2022 <a href="https://github.com/imamxxl">Ahmad Imam (16076040)</a>.</strong>
            Mediatama Web
        </footer>
    </div>

    @include('layout.js')

</body>

</html>
