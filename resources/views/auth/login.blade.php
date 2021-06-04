@extends('../layouts.front-second')

@section('css')
<style>
  
.omb_login .omb_authTitle {
    text-align: center;
	line-height: 300%;
}
	
.omb_login .omb_socialButtons a {
	color: white; // In yourUse @body-bg 
	opacity:0.9;
}
.omb_login .omb_socialButtons a:hover {
    color: white;
	opacity:1;    	
}
.omb_login .omb_socialButtons .omb_btn-facebook {background: #3b5998;}
.omb_login .omb_socialButtons .omb_btn-line {background: #2dc519;}
.omb_login .omb_socialButtons .omb_btn-google {background: #c32f10;}


.omb_login .omb_loginOr {
	position: relative;
	font-size: 1.5em;
	color: #aaa;
	margin-top: 1em;
	margin-bottom: 1em;
	padding-top: 0.5em;
	padding-bottom: 0.5em;
}
.omb_login .omb_loginOr .omb_hrOr {
	background-color: #cdcdcd;
	height: 1px;
	margin-top: 0px !important;
	margin-bottom: 0px !important;
}
.omb_login .omb_loginOr .omb_spanOr {
	display: block;
	position: absolute;
	left: 50%;
	top: -0.6em;
	margin-left: -1.5em;
	background-color: white;
	width: 3em;
	text-align: center;
}			

.omb_login .omb_loginForm .input-group.i {
	width: 2em;
}
.omb_login .omb_loginForm  .help-block {
    color: red;
}
</style>
@endsection

@section('content')
<div class="container">
    
    

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Login') }}</div> --}}
                    
                <div class="card-body">
                    <div class="omb_login">
                        <h3 class="omb_authTitle">Login or <a href="{{ url('register') }}" class=" btn-link"><font color="" size="6">Sign up</font></a></h3>
                        <div class="row  omb_socialButtons">
                            <div class="col-md-4 p-1">
                                <a href="{{ url('auth/faebook') }}" class="btn btn-lg btn-block omb_btn-facebook">
                                    <i class="fab fa-facebook-square"></i>
                                    <span class="hidden-xs">Facebook</span>
                                </a>
                            </div>
                            <div class="col-md-4 p-1">
                                <a href="{{ url('auth/line') }}" class="btn btn-lg btn-block omb_btn-line">
                                    <i class="fab fa-line"></i>
                                    <span class="hidden-xs">Line</span>
                                </a>
                            </div>	
                            <div class="col-md-4 p-1">
                                <a href="{{ url('auth/google') }}" class="btn btn-lg btn-block omb_btn-google">
                                    <i class="fab fa-google-plus-square"></i>
                                    <span class="hidden-xs">Google+</span>
                                </a>
                            </div>	
                        </div>
                
                        <div class="row  omb_loginOr">
                            <div class="col-md-12 col-lg-12">
                                <hr class="omb_hrOr">
                                <span class="omb_spanOr">or</span>
                            </div>
                        </div>
                
                        

                    
                    @if(Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                    @if(Session::has('info'))
                        <p class="alert alert-info">{{ Session::get('info') }}</p>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <input type="hidden" name="url" id="url" value="{{ url()->previous() }}">

                        <div class="form-group row">
                            
                            <label for="username" class="col-md-4 col-form-label text-md-right"><span class="input-group-addon"><i class="fa fa-user"></i></span> {{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="@if(Session::has('username_old')){{Session::get('username_old')}}@endif" required autocomplete="username" autofocus>


                                

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            
                            <label for="password" class="col-md-4 col-form-label text-md-right"><span class="input-group-addon"><i class="fa fa-lock"></i></span> {{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        {{-- <a href="{{ url('auth/faebook') }}" style="margin-top: 0px !important;background: blue;color: #ffffff;padding: 5px;border-radius:7px;" class="ml-2">
                            <strong>Facebook Login</strong>
                          </a> 
                          <a href="{{ url('auth/line') }}" style="margin-top: 0px !important;background: green;color: #ffffff;padding: 5px;border-radius:7px;" class="ml-2">
                            <strong>Line Login</strong>
                          </a> 
                          <a href="{{ url('auth/google') }}" style="margin-top: 0px !important;background: red;color: #ffffff;padding: 5px;border-radius:7px;" class="ml-2">
                            <strong>Google Login</strong>
                          </a>  --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary pl-3 pr-3">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
