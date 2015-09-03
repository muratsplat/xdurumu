<!DOCTYPE html>
<html @yield('html_attribute')>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') Hava Durumu | durumum.NET | Hayatı Kolaylaştıran Uygulamalar</title>
    @include('front._meta')    
      @yield('meta')            
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
            @yield('breadcrumb')
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