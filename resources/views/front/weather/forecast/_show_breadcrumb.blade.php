			<h1>
              {{ $city->name }}   
              <img src="//openweathermap.org/img/w/{{$data['currentStat']->conditions[0]->icon}}d.png" alt="{{$data['currentStat']->conditions[0]->name}}" style="left:{{ (strlen($city->name) *10) +10 . 'px' }};">          
            </h1>           
            <span class="direct-chat-timestamp ">güncelleme: {{ $data['currentStat']->updated_at->diffForHumans()}}</span>
            <ol class="breadcrumb">
              <li><a href="{{action('Home@index')}}"><i class="fa fa-dashboard"></i> Anasayfa</a></li>
              <li><a href="{{action('Weather\Forecast@index')}}">Hava Durumu</a></li>  
              <li><a href="{{action('Weather\Forecast@show', $city->slug)}}">{{$city->name}}</a></li>              
            </ol>