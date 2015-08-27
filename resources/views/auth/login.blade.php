<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Durumum.net | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <!-- <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"> -->
   
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>durumum.</b>NET</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">       
          <p class="login-box-msg">Kullanıcı girişi</p>    

          <!--  FORM FIELD -->
          <form method="POST" action="{{action('Auth\AuthController@getLogin')}}">
                {!! csrf_field() !!}        
                
            <div class="form-group has-feedback {{ (count($errors) > 0) ? 'has-warning' : ''}}"> 
              <!--  Flash Message is listed in here -->
              @if(count($errors) > 0)         
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>          
              @endif   
              <!--  ./Flash Message is listed in here -->            
              <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback {{ \Session::get('errors') ? 'has-warning' : ''}}">           
              <input type="password" name="password" class="form-control" id="password" placeholder="Password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <div class="checkbox icheck">
                  <label>
                    <input type="checkbox" name="remember"> Beni hatırla
                  </label>
                </div>
              </div><!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Giriş</button>
              </div><!-- /.col -->
            </div>
        </form>
         <!--  ./FORM FIELD -->
        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div><!-- /.social-auth-links -->

        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    
    <!--  CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
     <!-- Ionicons -->
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <!--<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">-->
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/front/dist/plugins/iCheck/square/blue.css') }}"> 
    <link rel="stylesheet" href="{{ elixir('assets/back/css/login/all.css') }}">
    <!-- End Of CSS -->
    <!-- Script -->
    <script src="{{ elixir('assets/back/js/libs/login/libs.js') }}"></script> 
    <script src="{{ asset('assets/front/dist/plugins/iCheck/icheck.min.js') }}"></script>    
    <!-- End Of Script-->
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>