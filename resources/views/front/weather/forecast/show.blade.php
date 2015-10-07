@extends('layouts.weather.master')

{{-- AngularJS App --}}
{{-- @section('html_attribute', '') --}}

{{-- Title --}}
@section('title') {{ $city->name }} Hava Durumu @endsection

{{-- BREADCRUMB--}}
@section('breadcrumb')
  @include('front.weather.forecast._show_breadcrumb')
@endsection

{{-- Meta --}}
@section('meta')
    <meta name='date' content="{{ $data['currentStat']->updated_at->toIso8601String()}}">
    <meta name="description" content="{{$city->name}} konumunun hava durumu bilgilerini sunuyoruz. Hava Durumu; anlık, günlük olarak yayınlanır." >
    <meta name="keywords" content="{{$city->name}} hava durumu, meteoroloji, anlık, günlük, şehirler, ilçeler, sıcaklık, rüzgar, hava basıncı, yağış miktarı">
    <meta name='subject' content="{{$city->name}} Hava Durumu">
    <meta name="geography" content="{{$city->name}}, Turkey">
    <meta name="twitter:title" content="{{$city->name}} Hava Durumu">
    <meta name="twitter:description" content="{{$city->name}} konumunun 16 günlük hava durumu bilgisi.">
    <meta name="twitter:image" content="http://openweathermap.org/img/w/{{$data['currentStat']->conditions[0]->icon}}d.png">
    {{-- Open Graph  --}}
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:type" content="place" />
    <meta property="og:title" content="{{$city->name}} Hava Durumu" />
    <meta property="og:description" content="{{$city->name}} konumunun 16 günlük hava durumu bilgisi." />
    <meta property="og:image" content="http://openweathermap.org/img/w/{{$data['currentStat']->conditions[0]->icon}}d.png" />
    <meta property="place:location:latitude"  content="{{$city->latitude}}" /> 
    <meta property="place:location:longitude" content="{{$city->longitude}}" /> 
@endsection

{{-- Content --}}
@section('content')
    <!-- Info boxes -->          
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-thermometer"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Sıcaklık</span>
                  <span class="info-box-number" > {{$data['currentStat']->main->temp}} °C</span>
                  <span class="description text-blue font-size-12px" >Yüksek: {{ $data['currentStat']->main->temp_max }} °C</span><br/>
                  <span class="description text-red font-size-12px" >Düşük: {{ $data['currentStat']->main->temp_min }} °C</span>             
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
                  <span class="info-box-number">{{ is_null($data['currentStat']->wind->deg) ? '' : $data['currentStat']->wind->deg . '°' }} </span>
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

    <div itemscope itemtype="http://schema.org/Place">  
      <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">  
        <meta itemprop="latitude" content="{{$city->latitude}}" />
        <meta itemprop="longitude" content="{{$city->longitude}}" />
      </div>
             <!-- COLOR PALETTE -->
          <div class="box box-info color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title" itemprop="name"><i class="fa fa-fw fa-map"></i> {{$city->name}}</h3>
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
             {{-- Hourly --}}
             {{--@if( ! $data['hourlyList']->isEmpty() )
               @include('front.weather.forecast._hourlyList')
             @endif --}}
              {{-- Daily --}}
              @if( ! $data['dailyList']->isEmpty())

                @include('front.weather.forecast._dailyList') 
                
              @endif
            </div><!-- /.col -->
          </div><!-- /.row -->          
  </div><!--itemtype="http://schema.org/Place" -->
@endsection
{{-- CSS SCRIPT --}}
@section('cssScript')
  {{-- CDN Boostrap Font Awesome jQuery --}}
  @parent   
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
    @include('_ga', ['gaID' => env('GA_HAVA', null)] )   
@endsection