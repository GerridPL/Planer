@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <h1 class="display-3 text-center">
                <i class="fas fa-key"></i>
                Zmiana hasła
            </h1>
        </div>
    </div>
</div>
<hr><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Zmiana hasła</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('changePassword.update') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Stare hasło</label>

                            <div class="col-md-6">
                                <input id="password" type="password" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-new" class="col-md-4 col-form-label text-md-right">Nowe hasło</label>

                            <div class="col-md-6">
                                <input id="password-new" type="password" name="password-new" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Potwierdź nowe hasło</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" name="password-confirm" required autocomplete="new-password">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                                <button type="submit" title="Zmień hasło" class="btn btn-primary">
                                    <i class="far fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
