@extends('layouts.app')

@section('title', 'Register')
@section('content')

<style>  
    .screen {		
        background: linear-gradient(90deg, #9b4292, #985e92);		
        position: relative;	
        height: 800px;
        width: 400px;	
        box-shadow: 0px 0px 10px #9b4292;
    }
    
    .screen__content {
        z-index: 1;
        position: relative;	
        height: 100%;
    }
    
    .screen__background {		
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);	
    }
    
    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }
    
    .screen__background__shape1 {
        height: 920px;
        width: 620px;
        background: #FFF;	
        top: -50px;
        right: 120px;	
        border-radius: 0 72px 0 0;
    }
    
    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: #d94298;	
        top: -172px;
        right: 0;	
        border-radius: 32px;
    }
    
    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        background: linear-gradient(270deg, #d94298, #c8689e);
        top: 24px;
        right: 0;	
        border-radius: 32px;
    }
    
    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #d94298;	
        top: 520px;
        right: 100px;	
        border-radius: 60px;
    }
    
    .login {
        width: 320px;
        padding: 30px;
        padding-top: 156px;
    }
    
    .login__field {
        padding: 20px 0px;	
        position: relative;	
    }
    
    .login__icon {
        position: absolute;
        top: 35px;
        color: #d94298;
    }
    
    .login__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 75%;
        transition: .2s;
    }
    
    .login__input:active,
    .login__input:focus,
    .login__input:hover {
        outline: none;
        border-bottom-color: #d94298;
    }
    
    .login__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 30px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100%;
        color: #d94298;
        box-shadow: 0px 2px 2px #d94298;
        cursor: pointer;
        transition: .2s;
    }
    
    .login__submit:active,
    .login__submit:focus,
    .login__submit:hover {
        border-color: #d271a8;
        outline: none;
    }
    
    .button__icon {
        font-size: 24px;
        margin-left: auto;
        color: #d94298;
    }
    
    .social-login {	
        position: absolute;
        height: 140px;
        width: 160px;
        text-align: center;
        bottom: 0px;
        right: 0px;
        color: #fff;
    }
    .social-login a{	
        color: #fff; 
    }
    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .social-login__icon {
        padding: 20px 10px;
        color: #fff;
        text-decoration: none;	
        text-shadow: 0px 0px 8px #7875B5;
    }
    
    .social-login__icon:hover {
        transform: scale(1.5);	
    }
    </style>
    <div class="container  ">
        <div class="screen m-auto">
            <div class="screen__content ">
                <form class="login" method="POST" action="{{ route('register') }}">
                    @csrf
    
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input  placeholder="Name" class="login__input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror   
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input  placeholder="Email" id="email" type="email" class="login__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input  placeholder="Password" type="password" class="login__input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input  placeholder="Confirm Password" type="password" class="login__input" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    
                    <button class="button login__submit">
                        <span class="button__text">Register</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
    
                </form> 
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>		
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>		
        </div>
    </div>
    
    
    
{{--

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
@endsection
