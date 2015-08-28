<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>durumum.NET | Hayatı Kolaylaştıran Uygulamar</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-black-light layout-top-nav">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="/" class="navbar-brand"><b>durumum</b>.NET</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li><a href="{{action('Weather\Home@index')}}" class="left-space-30"><i class="ion ion-ios-rainy iconic-font-big-navigate";></i> Hava</a></li>
                <!--<li><a href="#">Link</a></li> -->
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <!--<h1>
              Top Navigation
              <small>Example 2.0</small>
            </h1>
            -->
            <ol class="breadcrumb">
              <li><a href="/"><i class="fa fa-home"></i> Anasayfa</a></li>
              <!--<li><a href="#">Layout</a></li>
              <li class="active">Top Navigation</li>-->
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">

          <div class="row">
            <div class="col-md-12">
                <center>
                <ul class="flatflipbuttons">
                    <li>
                        <a href="{{action('Weather\Home@index')}}" title="Hava Durumu">
                            <i class="ion ion-ios-rainy homepage-big-ion-font";></i>
                        </a> 
                                    
                    </li> 
                    <a href="{{action('Weather\Home@index')}}"><h1>Hava Durumu </h1></a> 
                </ul>
            </center>
                </div>
              </div>
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <!--<div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
          </div> -->
          <strong>Copyright &copy; 2015 <a href="http://durumum.net">durumum.NET</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    @include('front._cdn_boostrap_font_awesome_jquery');

    <!-- Theme style and Other independent css files -->
    <link rel="stylesheet" href="{{ elixir('assets/front/main/css/all.css') }}">   
    <!-- JS -->
    <!-- SlimScroll, FastClick, AdminLTE App -->    
    <script src="{{ elixir('assets/front/main/js/libs.js') }}"></script>   
    <!-- END OF JS -->
    @include('_ga')
  </body>
</html>
