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
                          {{ $hList->hourMinute() }}
                        </td>
                        <td>
                          <img src="http://openweathermap.org/img/w/{{$hList->conditions[0]->icon}}d.png" alt="{{ $hList->conditions[0]->description }}">                        
                        </td>
                        <td>
                          <div class="description-block border-right">
                            <ul class="list-group group-termal">
                              <li class="list-group-item list-group-termal bg-red">{{ $hList->main->temp_max}} °C</li>
                              <li class="list-group-item list-group-termal bg-gray">{{  $hList->main->temp }} °C</li>
                              <li class="list-group-item list-group-termal bg-aqua-active">{{ $hList->main->temp_min}} °C</li>
                            </ul>
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