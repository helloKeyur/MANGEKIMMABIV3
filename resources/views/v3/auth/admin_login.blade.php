@extends('v3.backend.layouts.auth')

@section('title') {{{\App\Models\SysConfig::set()['system_title']}}} | Log in  @endsection

@section('css')
<style type="text/css">
    
</style>
@endsection

@section('content')

<div class="authentication-form mx-auto">
    <div class="logo-centered">
        {{-- <h2><b>S360<font color="#f05138">.</font></b></h2> --}}
        {{-- <img src="/{{\App\Models\SysConfig::set()['logo']}}" width="100" height="100"><br> --}}
        <img src="{{ url('/'.App\Models\SysConfig::set()['logo']) }}" width="100" height="100"><br>
    </div>
    <h3>Sign In to <b>{{{\App\Models\SysConfig::set()['system_title']}}}</b></h3>
    <p>Happy to see you again!</p>
    <br/>
    
    @if(Session::has('message'))
    <p>{{{ Session::get('message') }}}.</p>
    <div class="alert bg-{{{Session::get('flash_type','info')}}} text-light alert-dismissible fade show" role="alert">
        <span>{{{ Session::get('message') }}}.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ik ik-x">X</i>
        </button>
    </div>
    @endif

    <form action="{{ route('management.login') }}" method="post">
        @method('POST')
        @csrf
        <div class="form-group">
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required="" value="mergautam9@gmail.com">
            <i class="ik ik-user"></i>
            @if ($errors->has('email'))
                <small class="text-danger">{{ $errors->first('email') }}</small>
            @endif
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required="" value="Gautam2141">
            <i class="ik ik-lock"></i>
            @if ($errors->has('password'))
              <small class="text-danger">{{ $errors->first('password') }}</small>
            @endif
        </div>
        <div class="row">
            <div class="col text-left">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="item_checkbox">
                    <span class="custom-control-label">&nbsp;Remember Me</span>
                </label>
            </div>
            @if (Route::has('password.request'))
            <div class="col text-right">
                <a href="{{ route('password.request') }}">
                  {{ __('Forgot Password?') }}
                </a>
            </div>
            @endif
        </div>
        <div class="sign-btn text-center">
            <button class="btn btn-theme" type="submit">Sign In</button>
        </div>
    </form>
</div>


@endsection

@section('js')
<script type="text/javascript">
    
</script>
@endsection