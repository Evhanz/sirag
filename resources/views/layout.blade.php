<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sistema Integral de Reportes AgroGrace </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">

    <!-- Ionicons -->
    <link href="{{asset('css/ionicons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('css/AdminLTE.css')}}" rel="stylesheet" type="text/css" />
    <!-- customize css -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- jQuery 2.0.2 -->
    <script src="{{ asset('js/jquery-2.0.2.min.js')}}"></script>

    <!--Angular JS 1.2.19 -->
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->



    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/AdminLTE/ej.js')}}" type="text/javascript"></script>


</head>
<body class="skin-black">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="{{ URL::route('home') }}" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Agro Grace
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{Auth::user()->USR}} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                         <!--   <img src="{{ asset('img/avatar3.png') }}" class="img-circle" alt="User Image" /> -->
                            <p>
                                @if (Auth::guest())
                                    oublic
                                @else
                                    Usuario:{{Auth::user()->USR}}
                                @endif

                                <small>  * Agro Exportaciones Grace</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <a href="{{ URL::route('outLogin') }}" class="btn btn-default btn-flat">Desconectar</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>


        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('img/avatar3.png')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>Bienvenido ,Usuario</p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <!--Menu right: option list-->
            <ul class="sidebar-menu">

                @if(Auth::user()->hasAnyRole(['ADMIN','COMERCIAL']))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cubes"></i>
                        <span>Comercial</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li><a href="{{ URL::route('viewRepProductos') }}" class="item sub"><i class="fa fa-angle-double-right"></i> Costo de Productos </a></li>
                        <li><a href="{{ URL::route('viewOrdenCompra') }}" class="item sub"><i class="fa fa-angle-double-right"></i> Ordenes Compra </a></li>

                         <li><a href="{{ URL::route('viewControlOrdenCompraComercial') }}" class="item sub"><i class="fa fa-angle-double-right"></i> Reporte de Control Orden Compra</a></li>
                    </ul>
                </li><!--Comercial-->
                @endif


                @if(Auth::user()->hasAnyRole(['ADMIN','CONTABILIDAD']))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <span>Contabilidad</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li><a href="{{ URL::route('viewCentroCosto') }}" class="item sub"><i class="fa fa-angle-double-right"></i> Reporte Centro Costo</a></li>
                        <li><a href="{{ URL::route('viewControlOrdenCompra') }}" class="item sub"><i class="fa fa-angle-double-right"></i> Reporte de Control Orden Compra</a></li>
                        <li><a href="{{ URL::route('viewPDB') }}"><i class="fa fa-angle-double-right"></i> Exportados PDB</a></li>

                    </ul>
                </li><!--Contabilidad-->
                @endif


                @if(Auth::user()->hasAnyRole(['ADMIN','RH']))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-universal-access" aria-hidden="true"></i>
                        <span>Recursos Humanos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li><a href="{{ URL::route('viewPersonal') }}" class="item sub"><i class="fa fa-angle-double-right"></i> Reporte Personal</a></li>
                        <li><a href="{{ URL::route('viewTelecredito') }}" class="item sub"><i class="fa fa-angle-double-right"></i> Telecrédito</a></li>



                    </ul>
                </li><!--RECURSOS HUMANOS-->
                @endif
                



            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        @yield('content-header')
        @yield('content')
        <!-- Content Header (Page header) -->
        <!--
        <section class="content-header">
            <h1>
                Blank page
                <small>it all starts here</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>
        -->
        <!-- Main content -->
        <!--
        <section class="content">
            <div class="row">
                <h2>Hola</h2>
            </div>
        </section>
        -->
        <!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->





</body>
</html>


<style>

    /*todo esto pasar a un css externo*/
    #alert-success{
        position: absolute;
        right: 25px;
        top: 50px;
        width: 300px;
        z-index: 5;
    }
    #alert-error{
        position: absolute;
        right: 25px;
        top: 50px;
        width: 300px;
        z-index: 5;
    }
    .bs-callout {
        background-color: white;
        border-width: 1px 1px 1px 5px;
        border-style: solid;
        border-color: #EEE;
        -moz-border-top-colors: none;
        -moz-border-right-colors: none;
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        border-image: none;
        border-radius: 3px;
        padding: 20px;
        
    }
    .bs-callout-info {
        border-left-color: #1B809E;
    }

    .bs-callout-info h4 {
        color: #1B809E;
    }
    .bs-callout h4 {
        margin-top: 0px;
        margin-bottom: 5px;
    }

    /*Pagination*/
    
    #pagination > ul{

        display: inline-block;
        padding-left: 0px;
        margin: 20px 0px;
        border-radius: 4px;
        
    }

    #pagination >ul >li{
        display: inline;

    }

    #pagination > ul > li:first-child > a, .pagination > li:first-child > span {
    margin-left: 0px;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    }
    #pagination > ul > li > a, 
    #pagination > ul > li > span {
        cursor: pointer;
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857;
        color: #337AB7;
        text-decoration: none;
        background-color: #FFF;
        border: 1px solid #DDD;
    }

    #pagination > ul > .disabled > a,
    #pagination > ul > .disabled > a:focus, 
    #pagination > ul > .disabled > a:hover, 
    #pagination > ul > .disabled > span, 
    #pagination > ul > .disabled > span:focus, 
    #pagination > ul > .disabled > span:hover {
        color: #777;
        cursor: not-allowed;
        background-color: #FFF;
        border-color: #DDD;
    }

    #pagination > ul > .active > a,
    #pagination > ul> .active > a:focus,
    #pagination > ul > .active > a:hover,
    #pagination > ul > .active > span,
    #pagination > ul > .active > span:focus,
    #pagination > ul > .active > span:hover {
        z-index: 2;
        color: #FFF;
        cursor: default;
        background-color: #337AB7;
        border-color: #337AB7;
    }




    /*End - Pagination*/

    /*para el boton cargando*/
    .circle {
        background-color: rgba(0,0,0,0);
        border: 5px solid rgba(0,183,229,0.9);
        opacity: .9;
        border-right: 5px solid rgba(0,0,0,0);
        border-left: 5px solid rgba(0,0,0,0);
        border-radius: 50px;
        box-shadow: 0 0 35px #2187e7;
        width: 50px;
        height: 50px;
        margin: 0 auto;
        -moz-animation: spinPulse 1s infinite ease-in-out;
        -webkit-animation: spinPulse 1s infinite linear;
    }

    .circle1 {
        background-color: rgba(0,0,0,0);
        border: 5px solid rgba(0,183,229,0.9);
        opacity: .9;
        border-left: 5px solid rgba(0,0,0,0);
        border-right: 5px solid rgba(0,0,0,0);
        border-radius: 50px;
        box-shadow: 0 0 15px #2187e7;
        width: 30px;
        height: 30px;
        margin: 0 auto;
        position: relative;
        top: -40px;
        -moz-animation: spinoffPulse 1s infinite linear;
        -webkit-animation: spinoffPulse 1s infinite linear;
    }

    @-moz-keyframes spinPulse {
        0% {
            -moz-transform: rotate(160deg);
            opacity: 0;
            box-shadow: 0 0 1px #2187e7;
        }

        50% {
            -moz-transform: rotate(145deg);
            opacity: 1;
        }

        100% {
            -moz-transform: rotate(-320deg);
            opacity: 0;
        }
    }

    @-moz-keyframes spinoffPulse {
        0% {
            -moz-transform: rotate(0deg);
        }

        100% {
            -moz-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spinPulse {
        0% {
            -webkit-transform: rotate(160deg);
            opacity: 0;
            box-shadow: 0 0 1px #2187e7;
        }

        50% {
            -webkit-transform: rotate(145deg);
            opacity: 1;
        }

        100% {
            -webkit-transform: rotate(-320deg);
            opacity: 0;
        }
    }

    @-webkit-keyframes spinoffPulse {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    /*end cargando*/

        

</style>


