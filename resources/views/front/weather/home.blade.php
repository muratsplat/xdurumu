<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org" ng-app="weatherHome">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hava Durumu | durumum.NET | Hayatı Kolaylaştıran Uygulamalar</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">   
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--[if lte IE 8]><link rel="stylesheet" href="http://leaflet.cloudmade.com/dist/leaflet.ie.css" /><![endif]-->
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav" ng-controller="HomeCtrl">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="http://{{config('app.domain')}}" class="navbar-brand"><b>durumum</b>.NET</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li>
                  <a href="{{action('Weather\Home@index')}}" class="active left-space-30">
                    <i class="ion ion-ios-rainy iconic-font-big-navigate";></i> Hava</a>
                </li>                
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-area-chart"></i> İstatislikler <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="divider"></li>
                    <li><a href="#">Meraklısına İstatislikler</a></li>
                    <li class="divider"></li>
                    <li><a href="#">En Sıcak Şehirler</a></li>
                    <li><a href="#">En Yağışlı Şehirler</a></li>
                    <li><a href="#">En Rüzgarlı Şehirler</a></li>
                    <li><a href="#">En Soğuk Şehirler</a></li>
                    <li class="divider"></li>                   
                  </ul>
                </li>
               <li>
                  <a href="#">
                    <i class="fa fa-fw fa-map-marker"></i>Hava Haritası</a>
                </li>  
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

             <!-- COLOR PALETTE -->
          <div class="box box-info color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-fw fa-cloud"></i> Tükiye'nin Anlık Hava Durumu</h3>
            </div>
            <div class="box-body">
            <!-- Search Field -->
              <div class="row">
                <div class="col-md-4  col-md-offset-4">  
                  <div class="location-search">   
                    <p class="text-center">
                      <br>
                      <p>Bulunduğunuz konumu, il ve içle bazında arayabilirsiniz.</p>
                    </p>         


                    <div id="autocomlate-list-location" class="input-group" >                     
                      <input type="text" name="message" placeholder="Şehir, konum, yer.." class="form-control" ng-model="search.selected" typeahead="city.name for city in search.cities | filter:$viewValue | limitTo:8" ng-change="callCities()" ng-keypress="($event.which === 13)?findCity():0" >
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" ng-click="findCity()">Ara</button>
                      </span>                     
                    </div>  

                                  
                  </div>
                 </div><!-- /.col -->             
               </div><!-- /.row -->
                <!-- ./Search Field -->

                <!-- ./Search Field -->
              <div class="row">
                <div class="col-md-12">                   
                  <!--  Google Map-->
                  <div  id="map_canvas" go-map=""></div>
                   <p class="text-center">
                      <br>
                      <i>Türkiye resmi sınırları içinde <b>1300</b>'ü aşkın konumun hava durumum bilgisine ulaşabilirsiniz.</i>
                    </p>         

                   <!--  ./ Google Map-->
                </div><!-- /.col -->             
              </div><!-- /.row -->
            </div><!-- /.box-body -->
              <!-- Loading (remove the following to stop the loading)-->
                 <div class="overlay" ng-if="process">
                    <i class="fa fa-refresh fa-spin"></i>
                 </div>
          </div><!-- /.box -->

          <!-- COLOR PALETTE -->
          <div class="box box-success color-palette-box ">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-fw fa-bar-chart"></i> Rastgele seçilmiş <b>[[conditions.length ]]</b> konumun Hava Durumu</h3>
            </div>
            <div class="box-body ">
                  <div class="row">
                    <div class="col-sm-2 col-xs-4">
                      <div class="description-block border-right">
                        <img src="http://openweathermap.org/img/w/01[[iconSuffix]].png">
                        <h5 class="description-header">[[ conditionCounter('01') ]]</h5>
                        <span class="description-text">Açık</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-2 col-xs-4">
                      <div class="description-block border-right">
                        <img src="http://openweathermap.org/img/w/02[[iconSuffix]].png">
                        <h5 class="description-header">[[ conditionCounter('02') ]]</h5>
                        <span class="description-text">Az Bulutlu</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-2 col-xs-4">
                      <div class="description-block border-right">
                        <img src="http://openweathermap.org/img/w/03[[iconSuffix]].png">
                        <h5 class="description-header">[[ conditionCounter('03') ]]</h5>
                        <span class="description-text">Parçalı Az Bulutlu</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-2 col-xs-4">
                      <div class="description-block border-right">
                        <img src="http://openweathermap.org/img/w/04[[iconSuffix]].png">
                        <h5 class="description-header">[[ conditionCounter('04') ]]</h5>
                        <span class="description-text">Kapalı</span>
                      </div><!-- /.description-block -->
                    </div>
                   <div class="col-sm-2 col-xs-4">
                      <div class="description-block border-right">
                        <img src="http://openweathermap.org/img/w/10[[iconSuffix]].png">
                        <h5 class="description-header">[[ conditionCounter('10') ]]</h5>
                        <span class="description-text">Orta Şiddetli Yağmur</span>
                      </div><!-- /.description-block -->
                    </div>
                    <div class="col-sm-2 col-xs-4">
                      <div class="description-block">
                        <img src="http://openweathermap.org/img/w/11[[iconSuffix]].png">
                        <h5 class="description-header">[[ conditionCounter('11') ]]</h5>
                        <span class="description-text">Sağanak</span>
                      </div><!-- /.description-block -->
                    </div>
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
              <!-- Loading (remove the following to stop the loading)-->
                 <div class="overlay" ng-if="process">
                    <i class="fa fa-refresh fa-spin"></i>
                 </div>
          </div><!-- /.box -->
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Sürüm</b> 0.0.1a
          </div>
          <strong>Copyright &copy; 2015 <a href="http://durumum.net">durumum.NET</a>.</strong> Tum Hakları Saklıdır.          
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- ALL CDN  -->
    @include('front._cdn_boostrap_font_awesome_jquery')
    @include('front._cdn_angular')
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-animate.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/angular.ng-notify/0.6.3/ng-notify.min.css">
    <!-- Angular Notify Pugin -->
    <script src="//cdn.jsdelivr.net/angular.ng-notify/0.6.3/ng-notify.min.js"></script>
    <!-- END OF ALL CDN -->
    <!-- Theme style and Other independent css files -->
    <link rel="stylesheet" href="{{ elixir('assets/front/weather/css/all.css') }}">   
    <!-- JS -->
    <!-- SlimScroll, FastClick, AdminLTE App -->    
    <script src="{{ elixir('assets/front/weather/js/libs.js') }}"></script>    
    <!-- JS Application -->
    <script src="{{ elixir('assets/front/weather/js/home/libs.js') }}"></script>    
    <script src="{{ elixir('assets/front/weather/js/home/bundle.js') }}"></script>
    <!-- ./JS Application -->
    @include('_ga')    
  </body>
</html>