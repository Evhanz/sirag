<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Producción  | Packing</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('templates/lte2/bootstrap/css/bootstrap.min.css')}} ">
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="{{asset('css/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('templates/lte2/dist/css/AdminLTE.min.css')}} ">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('templates/lte2/dist/css/skins/_all-skins.min.css')}} ">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/iCheck/flat/blue.css')}} ">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/morris/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/datepicker/datepicker3.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->




</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo" title="Agro Exportaciones Grace">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b></b>AEG</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>AGRO</b>GRACE</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" id="togle_navigation">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">


                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('templates/lte2/dist/img/user2-160x160.jpg')}}"  class="user-image" alt="User Image">
                            <span class="hidden-xs">Bienvenido Usuario</span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Cerrar Sesion</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('templates/lte2/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>Bienvenido Usuario</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" >
                <li class="header">Opciones</li>
                <li><a href="{{route('viewAllMP')}}"><i class="fa fa-circle-o text-red"></i> <span>Materia Prima</span></a></li>
                <li><a href="{{route('viewEtapaAll')}}"><i class="fa fa-circle-o text-yellow"></i> <span>E. Seleccion</span></a></li>
                <li><a href="{{route('viewAllPallet')}}"><i class="fa fa-circle-o text-green"></i> <span>Pallet</span></a></li>
                <li><a href="{{route('viewPalletRep')}}"><i class="fa fa-circle-o text-green"></i> <span>Reporte Pallet</span></a></li>
              <!--  <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
                <li class="header">OPCIONES GENERALES</li>
                <span id="opciones">
                </span>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            @yield('header')

        </section>

        <!-- Main content -->
        <section class="content">

            @yield('head_options')
            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class=" hidden-xs main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy;2016 <a href="">Agro Exportaciones Grace</a>.</strong> Todos los derechos son reservados.
    </footer>







</div>
<!-- ./wrapper -->

<!--Main Script-->

<!--Inicio de Scripts-->


<!-- jQuery 2.2.3 -->
<script src="{{asset('templates/lte2/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);

</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('templates/lte2/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('templates/lte2/plugins/morris/morris.min.js')}} "></script>
<!-- Sparkline -->
<script src="{{asset('templates/lte2/plugins/sparkline/jquery.sparkline.min.js')}}  "></script>
<!-- jvectormap -->
<script src="{{asset('templates/lte2/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}} "></script>
<script src="{{asset('templates/lte2/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}  "></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('templates/lte2/plugins/knob/jquery.knob.js')}} "></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('templates/lte2/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('templates/lte2/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('templates/lte2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}} "></script>
<!-- Slimscroll -->
<script src="{{asset('templates/lte2/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('templates/lte2/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('templates/lte2/dist/js/app.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes)
<script src="{{asset('templates/lte2/dist/js/pages/dashboard.js')}}"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="{{asset('templates/lte2/dist/js/demo.js')}}"></script>

<!--Fin de Scripts-->

<script src="{{asset('templates/lte2/dist/js/main.js')}}"></script>

<!-- ./ main Script -->

<!--more Scripts -->
@yield('scripts')

<!-- ./ more scripts -->
</body>
</html>
