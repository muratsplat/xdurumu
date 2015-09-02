<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $city->name }} Hava Durumu | durumum.NET | Hayatı Kolaylaştıran Uygulamalar</title>
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
                    <i class="ion ion-ios-rainy iconic-font-big-navigate"></i> Hava</a>
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
              {{ $city->name }}             
            </h1>
            <span class="direct-chat-timestamp ">güncelleme: {{ $data['currentStat']->updated_at->diffForHumans()}}</span>
            <ol class="breadcrumb">
              <li><a href="http://{{config('app.domain')}}"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
              <li><a href="{{action('Home@index')}}">Hava Durumu</a></li>  
              <li><a href="{{action('Weather\Forecast@show', $city->slug)}}">{{$city->name}}</a></li>              
            </ol>
          </section>
          <!-- Main content -->
          <section class="content">          
           <!-- Info boxes -->          
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-thermometer"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Sıcaklık</span>
                  <span class="info-box-number"> {{$data['currentStat']->main->temp}} °C</span>
                  <span class="description text-blue" >En Yüksek: {{ $data['currentStat']->main->temp_max }} °C</span><br/>
                  <span class="description text-red" >En Düşük: {{ $data['currentStat']->main->temp_min }} °C</span>             
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-waterdrop"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Nem Oranı</span>
                  <span class="info-box-number"> % {{$data['currentStat']->main->humidity }} </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-flag"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Rüzgar</span>
                  <span class="info-box-number">{{ $data['currentStat']->wind->speed}} m/s</span>
                  <span class="info-box-number">{{ $data['currentStat']->wind->deg }}° </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-speedometer"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Hava Basıncı</span>
                  <span class="info-box-number">{{$data['currentStat']->main->pressure }} hpa</span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

             <!-- COLOR PALETTE -->
          <div class="box box-info color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-fw fa-map"></i> {{$city->name}}</h3>
            </div>
            <div class="box-body">
            <!-- Search Field -->
               <!-- ./Search Field -->
              <div class="row">
                <div class="col-md-12">                   
                  <!--  Google Map-->
                  <div  id="map_canvas" ></div>        

                   <!--  ./ Google Map-->
                </div><!-- /.col -->             
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div><!-- /.box -->
         
          <div class="row">
            <div class="col-xs-12">
             @if( ! $data['hourlyList']->isEmpty() )
              <div class="box box-info">
                <div class="box-header">
                <h3 class="box-title"><span class="glyphicon glyphicon-time"></span> {{ $city->name }} Saatlik Hava Durumu</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="direct-chat-info clearfix">                        
                     <span class="direct-chat-timestamp "> güncelleme: {{ $data['hourlyStat']->updated_at->diffForHumans()}}</span>
                  </div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><i class="fa fa-fw fa-clock-o iconic-font-20"></i>Saat(24)</th>
                        <th><i class="fa fa-fw fa-cloud iconic-font-20"></i>Durum</th>
                        <th><i class="ion ion-thermometer iconic-font-20" style="font-size: 20px;"></i> Sıcaklıklar</th>
                        <th><i class="ion ion-waterdrop iconic-font-20"></i> Nem Oranı</th>
                        <th><i class="ion ion-ios-rainy iconic-font-20" style="font-size: 20px;"></i> Yağış Miktarı</th>                       
                        <th><i class="ion ion-ios-flag iconic-font-20" style="font-size: 20px;"></i> Rüzgar</th>
                        <th><i class="ion ion-speedometer iconic-font-20" style="font-size: 20px;"></i> Basınç</th>                                                
                      </tr>
                    </thead>
                    <tbody>
                    {{-- Weather Hourly Stat List --}}
                    @foreach($data['hourlyList'] as $groupNameAsDayName =>  $hourlyDay)
                      <tr class="well">
                        <td colspan="7">
                          <b>
                            {{$hourlyDay[0]->date}}
                          </b> 
                        </td>
                      </tr>                     
                      @foreach($hourlyDay as $hList)
                      <tr>
                        <td>
                          {{ Carbon\Carbon::createFromTimestampUTC($hList->dt)->toTimeString() }}
                        </td>
                        <td>
                          <img src="http://openweathermap.org/img/w/{{$hList->conditions[0]->icon}}d.png" alt="{{ $hList->conditions[0]->description }}">                        
                        </td>
                        <td>
                          <div class="description-block border-right">
                            <span class="badge bg-red"> {{ $hList->main->temp_max}} °C</span>
                            <span class="badge bg-default"> {{  $hList->main->temp }} °C</span>
                            <span class="badge bg-blue">{{ $hList->main->temp_min}} °C</span>
                          </div>
                        </td>
                      <td>                                               
                        {{$hList->main->humidity }}%</td>
                      </td>
                      <td>                                        
                           <?php 
                              $_rainVal = 0; 
                              
                              if(! is_null($hList->rain)) {

                                $_rainVal = $hList->rain->getAttribute('3h');

                              } elseif ( ! is_null($hList->snow) )   {

                                $_rainVal = $hList->snow->getAttribute('3h');
                              }
                            ?>
                            {{ $_rainVal }} mm
                        </td>
                        <td>                                               
                           {{ $hList->wind->speed }} m/s, <br> <i class="fa fa-fw fa-arrows"></i> {{ $hList->wind->deg}} °
                        </td>                        
                        <td>                                               
                           {{$hList->main->pressure }} hpa
                        </td>
                      </tr>
                      @endforeach              
                    @endforeach
                    {{-- ./Weather Hourly Stat List --}}                
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th><i class="fa fa-fw fa-clock-o iconic-font-20"></i>Saat(24)</th>
                        <th><i class="fa fa-fw fa-cloud iconic-font-20"></i>Durum</th>
                        <th><i class="ion ion-thermometer iconic-font-20" style="font-size: 20px;"></i> Sıcaklıklar</th>
                        <th><i class="ion ion-waterdrop iconic-font-20"></i> Nem Oranı</th>
                        <th><i class="ion ion-ios-rainy iconic-font-20" style="font-size: 20px;"></i> Yağış Miktarı</th>                       
                        <th><i class="ion ion-ios-flag iconic-font-20" style="font-size: 20px;"></i> Rüzgar</th>
                        <th><i class="ion ion-speedometer iconic-font-20" style="font-size: 20px;"></i> Basınç</th>    
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              @endif

              {{-- Daily --}}
              @if( ! $data['dailyList']->isEmpty())
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title"><span class="glyphicon glyphicon-calendar"></span>  {{ $city->name }} Günlük Hava Durumu</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="direct-chat-info clearfix">                        
                      <span class="direct-chat-timestamp ">güncelleme: {{ $data['dailyStat']->updated_at->diffForHumans()}}</span>
                  </div>
                   <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><i class="fa fa-fw fa-calendar-check-o"></i>Gün</th>
                        <th><i class="fa fa-fw fa-cloud iconic-font-20"></i>Durum</th>
                        <th><i class="ion ion-thermometer iconic-font-20" style="font-size: 20px;"></i> Sıcaklıklar</th>
                        <th><i class="ion ion-waterdrop iconic-font-20"></i> Nem Oranı</th>
                        <th><i class="ion ion-ios-rainy iconic-font-20" style="font-size: 20px;"></i> Yağış Miktarı</th>                       
                        <th><i class="ion ion-ios-flag iconic-font-20" style="font-size: 20px;"></i> Rüzgar</th>
                        <th><i class="ion ion-speedometer iconic-font-20" style="font-size: 20px;"></i> Basınç</th>                                                
                      </tr>
                    </thead>
                    <tbody>
                    {{-- Weather Hourly Stat List --}}
                    @foreach($data['dailyList'] as $dList)
                   
                      <tr>
                        <td>
                       
                          {{ Carbon\Carbon::createFromTimestampUTC($dList->dt)->formatLocalized('%A %d %B') }}
                        </td>
                        <td>
                          <img src="http://openweathermap.org/img/w/{{$dList->conditions[0]->icon}}d.png" alt="{{ $dList->conditions[0]->description }}">                        
                        </td>
                        <td>
                          <div class="description-block border-right">
                            <span class="badge bg-red"> {{ $dList->main->temp_max}} °C</span>
                            <span class="badge bg-default"> {{  $dList->main->temp }} °C</span>
                            <span class="badge bg-blue">{{ $dList->main->temp_min}} °C</span>
                          </div>
                        </td>
                      <td>                                               
                        {{$dList->main->humidity }}%</td>
                      </td>
                      <td>                                        
                           <?php 
                              $_rainVal = 0; 
                              
                              if(! is_null($dList->rain) ) {

                                $_rainVal = $dList->rain->getAttribute('3h');

                              } elseif ( ! is_null($dList->snow) )  {

                                $_rainVal = $dList->snow->getAttribute('3h');
                              }
                            ?>
                            {{ $_rainVal }} mm  
                        </td>
                        <td>                                               
                           {{ $dList->wind->speed }} m/s, <br> <i class="fa fa-fw fa-arrows"></i> {{ $dList->wind->deg}} °
                        </td>                        
                        <td>                                               
                           {{$dList->main->pressure }} hpa 
                        </td>
                      </tr>
                               
                    @endforeach
                    {{-- ./Weather Hourly Stat List --}}                
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th><i class="fa fa-fw fa-calendar-check-o"></i>Gün</th>
                        <th><i class="fa fa-fw fa-cloud iconic-font-20"></i>Durum</th>
                        <th><i class="ion ion-thermometer iconic-font-20" style="font-size: 20px;"></i> Sıcaklıklar</th>
                        <th><i class="ion ion-waterdrop iconic-font-20"></i> Nem Oranı</th>
                        <th><i class="ion ion-ios-rainy iconic-font-20" style="font-size: 20px;"></i> Yağış Miktarı</th>                       
                        <th><i class="ion ion-ios-flag iconic-font-20" style="font-size: 20px;"></i> Rüzgar</th>
                        <th><i class="ion ion-speedometer iconic-font-20" style="font-size: 20px;"></i> Basınç</th>    
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              @endif

            </div><!-- /.col -->
          </div><!-- /.row -->

          
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

    <script type="text/javascript">

      var city = {

        lat: {{$city->latitude }}, 
        lng: {{$city->longitude }}, 
        name: "{{$city->name}}",

      };
    </script>
       
    <!-- END OF ALL CDN -->
    <!-- Theme style and Other independent css files -->
    <link rel="stylesheet" href="{{ elixir('assets/front/weather/css/all.css') }}">   
    <!-- JS -->
    <!-- SlimScroll, FastClick, AdminLTE App -->    
    <script src="{{ elixir('assets/front/weather/js/libs.js') }}"></script>    
    <!-- App -->     
    <script src="{{ elixir('assets/front/weather/js/forecast/bundle.js') }}"></script> 
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEOgcVkpgwi7TuYxZqqFultIURU20lyk8&callback=initMap"></script> 
    <!-- ./JS Application -->
    @include('_ga')    
  </body>
  <!-- {{ count(\DB::getQueryLog() ) }}-->
</html>