@extends('layouts.weather.master')

{{-- AngularJS App --}}
@section('html_attribute', 'xmlns:ng="http://angularjs.org" ng-app="weatherHome"')

{{-- Title --}}
@section('title')Hava Durumu | durumum.NET | Hayatı Kolaylaştıran Uygulamalar @endsection

{{-- BREADCRUMB--}}
@section('breadcrumb')
  @include('front.weather._home_breadcrumb')
@endsection

{{-- Meta --}}
@section('meta')
  <meta content="Türkiye'de bulunan 1300'e aşkın konumun hava durumu bilgilerini sunuyoruz. Hava Durumları, anlık, saatlik ve günlük olarak yayınlanır." name="description">
  <meta content="hava durumu, meteoroloji, istanbul hava durumu, ankara hava durumu, anlık,saatlik, günlük, şehirler, ilçeler, sıcaklık, rüzgar, hava basıncı, yağış miktarı" name="keywords">
  <meta name='subject' content='Hava Durumu'>
@endsection

{{-- Content --}}
@section('content')
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
                    <input type="text" name="message" placeholder="Şehir, konum, yer.." class="form-control" ng-model="search.selected" typeahead="city.name for city in search.cities | filter:$viewValue | limitTo:8" ng-change="callCities()" ng-keypress="($event.which === 13) ? findCity() : 0" >
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
@endsection

@section('cssScript')
    {{-- CDN Boostrap Font Awesome jQuery --}}
    @parent
   
    @include('front._cdn_angular')
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-animate.min.js"></script>
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
    @include('_ga', ['gaID' => env('GA_HAVA', null)] )    
@endsection