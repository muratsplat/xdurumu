<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org" @yield('html_attribute')>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') Hava Durumu | durumum.NET | Hayatı Kolaylaştıran Uygulamalar</title>    
    @section('meta')
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">   
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!--[if lte IE 8]><link rel="stylesheet" href="http://leaflet.cloudmade.com/dist/leaflet.ie.css" /><![endif]-->
    @show   
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav" ng-controller="HomeCtrl">
    <div class="wrapper">
    {{-- HEADER --}}
    @include('front.weather._header')
    {{-- ./HEADER --}}

      <!-- Full Width Column -->
         <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              Türkiye             
            </h1>
            <ol class="breadcrumb">
              <li><a href="http://{{config('app.domain')}}"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
              <li><a href="{{action('Home@index')}}">Hava Durumu</a></li>              
            </ol>
          </section>
          <!-- Main content -->
          <section class="content">
          {{-- Content --}}
          @yield('content')

          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      {{-- FOOTER--}}
      @include('front.weather._footer')
      {{-- ./FOOTER--}}   
    </div><!-- ./wrapper -->

    <!-- ALL CDN  -->
    @section('cssScript')
      @include('front._cdn_boostrap_font_awesome_jquery')
    @show
   
    <!-- ./JS Application -->
    @include('_ga')    
  </body>
</html>