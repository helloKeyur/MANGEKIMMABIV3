@extends('v3.backend.layouts.auth')

@section('title') {{{\App\Models\SysConfig::set()['system_title']}}} | Forgot Password  @endsection

@section('css')
<style type="text/css">
    
</style>
@endsection

@section('content')

<div class="authentication-form mx-auto">
    <div class="logo-centered">
        {{-- <h2><b>S360<font color="#f05138">.</font></b></h2> --}}
        <img src="/{{{\App\Models\SysConfig::set()['logo']}}}" width="100" height="100"><br>
    </div>
    <h3>{{ __('Reset Password') }}</h3>
    <p>Please enter valid email address.</p>
    
    @if(Session::has('message'))
    <div class="alert bg-{{{Session::get('flash_type','info')}}} text-light alert-dismissible fade show" role="alert">
        <span>{{{ Session::get('message') }}}.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ik ik-x"></i>
        </button>
    </div>
    @endif

    <form action="{{ route('password.update') }}" method="post">
        @method('POST')
        @csrf
        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
        <input type="hidden" name="token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email" required="" value="mergautam9@gmail.com">
            <i class="ik ik-user"></i>
            @error('email')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" required="">
            <i class="ik ik-lock"></i>
            @error('password')
                    <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required autocomplete="new-password">
            <i class="ik ik-lock"></i>
        </div>
        <div class="row">
            @if (Route::has('password.request'))
            <div class="col text-left">
                <a href="{{ route('management.showLoginForm') }}" class="text-primary">
                  {{ __('Back to Login!') }}
                </a>
            </div>
            @endif
            <div class="col text-right">
                <button class="btn btn-theme" type="submit">{{ __('Reset Password') }}</button>
            </div>
        </div>
    </form>
</div>


@endsection

@section('js')
<script type="text/javascript">
    
</script>
@endsection