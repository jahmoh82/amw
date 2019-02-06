@extends('theme::layouts.app')

@section('content')
    <div class="uk-section">
        <div class="uk-container uk-container-center">

            <div class="uk-width-1-2@m uk-align-center">

                <div class="uk-padding uk-box-shadow-large">

                    <h2>Login</h2>

                    <form class="uk-form-stacked" role="form" method="POST" action="{{ route('login') }}">

                        {{ csrf_field() }}

                        <div>

                            @if(setting('auth.email_or_username') && setting('auth.email_or_username') == 'username')
                                <label class="uk-form-label">Username</label>
                                <input id="username" type="text" class="uk-input{{ $errors->has('username') ? ' uk-form-danger' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <div class="uk-alert-danger" uk-alert>
                                        {{ $errors->first('username') }}
                                    </div>
                                @endif
                            @else
                                <label class="uk-form-label">Email Address</label>
                                <input id="email" type="email" class="uk-input{{ $errors->has('email') ? ' uk-form-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <div class="uk-alert-danger" uk-alert>
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            @endif

                        </div>

                        <div class="uk-margin" style="position: relative">
                            <label class="uk-form-label">Password</label>
                            <input id="password" type="password" class="uk-input{{ $errors->has('password') ? ' uk-form-danger' : '' }}" name="password" value="{{ old('password') }}" required>
                            <button class="uk-button uk-button-small uk-float-right" id="show-pass" onclick="showPass()" style="position: absolute;right: 2px;border:0;border-radius: 3px;height: 36px;margin-top: 2px;" type="button">show password</button>
                            @if ($errors->has('password'))
                                <div class="uk-alert-danger" uk-alert>
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <script>
                                function showPass(){
                                    if(document.getElementById("password").getAttribute("type") === 'password'){
                                        document.getElementById("password").setAttribute("type", "text");
                                        document.getElementById("show-pass").innerHTML= "hide password";
                                    }else{
                                        document.getElementById("password").setAttribute("type", "password");
                                        document.getElementById("show-pass").innerHTML= "show password";
                                    }
                                }
                            </script>
                        </div>

                        <div class="uk-margin">
                           <label><input class="uk-checkbox" type="checkbox" name="remember"{{ old('remember') ? ' checked' : '' }}> Remember me</label>
                        </div>

                        <div class="uk-margin">
                            <button class="uk-button uk-button-primary" type="submit" name="button">Login</button>
                            <a class="uk-float-right" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
