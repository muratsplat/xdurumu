@extends('layouts.weather.master')

{{-- AngularJS App --}}
{{-- @section('html_attribute', '') --}}

{{-- Title --}}
@section('title', '1000 Aşkın Konumun Hava Durumu - Günlük, Saatlik, Anlık')

{{-- BREADCRUMB--}}
@section('breadcrumb')
  @include('front.weather.forecast._index_breadcrumb') 
@endsection
{{-- Meta --}}
@section('meta')
  <meta content="Türkiye'de {{$currents->count()}} konumunun hava durumu bilgilerini sunuyoruz. Hava Durumu, anlık, saatlik ve günlük olarak yayınlanır." name="description">
  <meta content="hava durumu, şehirler, ilçeler, meteoroloji, anlık,saatlik, günlük, şehirler, ilçeler, sıcaklık, rüzgar, hava basıncı, yağış miktarı" name="keywords">
  <meta name='subject' content="Türkiye'deki {{$currents->count()}} konumun hava durumu">  
  {{-- http://googlewebmastercentral.blogspot.com.tr/2011/09/pagination-with-relnext-and-relprev.html --}}
  @if(! $currents->isEmpty() && $currents->total() > 6 )     
    @if( $currents->previousPageUrl() ) 
      <link rel="prev" href="{{$currents->previousPageUrl()}}" />
    @endif 
    @if( $currents->nextPageUrl() )
      <link rel="next" href="{{$currents->nextPageUrl()}}" />
    @endif
  @endif
@endsection
{{-- Content --}}
@section('content')
    @if( ! $currents->isEmpty() )
           <!-- COLOR PALETTE -->
        <div class="box box-info color-palette-box">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-fw fa-map-marker"></i> Konumlar</h3>
          </div>
          <div class="box-body">
              <ul class="products-list product-list-in-box">   
                 @foreach($currents as $one)
                  <li class="item" itemscope itemtype="http://schema.org/Place" >
                    <div class="product-img">
                      <img src="//openweathermap.org/img/w/{{$one->conditions[0]->icon}}d.png" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="{{action('Weather\Forecast@show', $one->city->slug)}}" class="product-title" itemprop="name">{{$one->city->name}} <span class="label label-info pull-right" style="font-size: 14px;">{{$one->main->temp}} °C</span></a>
                      <span class="product-description">
                        <dl>
                          <dt>Konum</dt>
                          <dd itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                                Enlem: {{(float)$one->city->latitude}}, Boylam: {{(float)$one->city->longitude}}
                                <meta itemprop="latitude" content="{{$one->city->latitude}}" />
                                <meta itemprop="longitude" content="{{$one->city->longitude}}" />
                          </dd>
                          <dt>Durum:</dt>
                          <dd>{{$one->conditions[0]->description}}</dd>                   
                        </dl>
                      </span>
                       <a href="{{action('Weather\Forecast@show', $one->city->slug)}}" class="btn btn-success">Ayrıntılar</a>                       
                    </div>
                     <div class="direct-chat-info clearfix">
                        <span class="direct-chat-timestamp pull-right"> <i class="fa fa-fw fa-clock-o"></i> {{ $one->updated_at->diffForHumans()}}</span>
                      </div>
                    </li><!-- /.item -->
                  @endforeach
                </ul>
          </div><!-- /.box-body -->
          @if(! $currents->isEmpty() ) 
            <div class="box-footer">
                <div class="col-sm-5">                
                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"> Toplam Kayıt: <b>{{$currents->total()}}</b> @if($currents->total() > $currents->perPage() ),  Gösterilen:  <b>{{ $currents->perPage() }} </b> @endif
                    </div>                  
                </div>
                <div class="col-sm-7">
                    <div class="dataTables_paginate paging_simple_numbers pull-right" id="example1_paginate">
                       {!! $currents->render() !!}                    
                    </div>
                </div>
            </div>
          @endif
        </div><!-- /.box --> 
    @else
      <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Aranan konum bulunamadı !</h3>
              <p>
                Belki yanlış bir konum ismi girdiniz. Aradığınız konumu tekrar girerek arabilirsiniz.
               Tekrar arama yapmak için <a href="{{action('Weather\Home@index')}}"> anasayfaya </a>git.
              </p>
              <form class="search-form" action="" method="GET">
                <div class="input-group">
                  <input type="text" name="name" class="form-control" placeholder="Şehir, il, içe, bölge..">
                  <div class="input-group-btn">
                    <button type="submit" name="" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div><!-- /.input-group -->
              </form>
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
    @endif
@endsection
{{-- CSS SCRIPT --}}

@section('cssScript')
  {{-- CDN Boostrap Font Awesome jQuery --}}
  @parent       
    <!-- END OF ALL CDN -->
    <!-- Theme style and Other independent css files -->
    <link rel="stylesheet" href="{{ elixir('assets/front/weather/css/all.css') }}">   
    <!-- JS -->
    <!-- SlimScroll, FastClick, AdminLTE App -->    
    <script src="{{ elixir('assets/front/weather/js/libs.js') }}"></script>    
    <!-- ./JS Application -->
    @include('_ga', ['gaID' => env('GA_HAVA', null)] )   
@endsection