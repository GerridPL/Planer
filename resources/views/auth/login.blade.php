@extends('layouts.app')

@section('content')
<link href="{{ asset('css/external/login.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-lock-open"></i>
                Logowanie
            </h1>
        </div>
    </div>
</div>
<hr><br>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <input type="email" id="email" class="fadeIn second @error('email') is-invalid @enderror" name="email" placeholder="E-mail" autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="password" id="password" class="fadeIn third @error('password') is-invalid @enderror" name="password" placeholder="Hasło" autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="submit" class="fadeIn fourth" value="Zaloguj">
        </div>
    </div>
</form>
@endsection
