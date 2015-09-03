			<h1>
              {{ $city->name }}             
            </h1>
            <span class="direct-chat-timestamp ">güncelleme: {{ $data['currentStat']->updated_at->diffForHumans()}}</span>
            <ol class="breadcrumb">
              <li><a href="http://{{config('app.domain')}}"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
              <li><a href="{{action('Home@index')}}">Hava Durumu</a></li>  
              <li><a href="{{action('Weather\Forecast@show', $city->slug)}}">{{$city->name}}</a></li>              
            </ol>