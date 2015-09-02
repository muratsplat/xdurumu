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