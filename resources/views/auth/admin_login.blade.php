<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{{\App\Models\SysConfig::set()['system_title']}}} | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/') }}/assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">

     @if(Session::has('message'))
    <div class="alert-container">
        <div class="alert alert-{{{Session::get('flash_type','info')}}} alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa {{{Session::get('flash_icon','fa-ban')}}}"></i> {{{Session::get('flash_type','Alert')}}}!</h4>
          {{{ Session::get('message') }}}.
        </div>
    </div>
   @endif
<div class="login-box">
  <div class="login-logo">
    <img src="/{{{\App\Models\SysConfig::set()['logo']}}}" width="250" height="250"><br>
    {{-- <a href=""><b>{{{\App\Models\SysConfig::set()['system_title']}}}</b></a> --}}

  </div>
  {{-- <p class="login-box-msg">{{{\App\Models\SysConfig::set()['system_description']}}}</p> --}}
  <!-- /.login-logo -->
  <div class="login-box-body">
    {{-- <p class="login-box-msg">Sign in to start your session Admin</p> --}}
     @if ($errors->has('email'))
                  <span class="invalid-feedback text-red" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  <br>
       @endif

    <form method="POST" action="{{ route('management.login') }}">
                        @csrf
      <div class="form-group has-feedback">
        <input type="text" name="email" class="form-control" placeholder="Phone number Or Email" required>
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback">
      @if ($errors->has('password'))
                  <span class="invalid-feedback text-red" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
         </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color: #f39c12 !important;">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
      <div id="append_value_here"></div>

  {{--   <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> --}}
    <!-- /.social-auth-links -->

       @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}" >
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    {{-- <a href="register.html" class="text-center">Register a new membership</a> --}}

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ url('/') }}/assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/') }}/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ url('/') }}/assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>

