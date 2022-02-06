@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-user-friends"></i>
                Informacje o użytkowniku
            </h1>
        </div>
    </div>
</div>
<hr><br>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Informacje o użytkowniku: {{ $showUser->email }}</div>

                <div class="card-body" style="margin-left: 3%;">
                    <div class='row'>
                        <div class="col-md-7 col-lg-6">
                            <div class="form-group">
                                <label for="name">
                                    Adres e-mail
                                </label>
                                <input type="text" class="form-control" name="name" value="{{ $showUser->email }}" tabindex="1" disabled/>
                            </div>
                        </div>

                        <div class="col-md-7 col-lg-6">
                            <div class="form-group">
                                <label for="name">
                                    Uprawnienie
                                </label>
                                <input type="text" class="form-control" name="name" value="{{ $role }}" tabindex="2" disabled/>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <div class='row'>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="postcode">
                                    Data dodania
                                </label>
                                <input type="text" class="form-control" name="created_at" value="{{ $showUser->created_at }}" tabindex="3" disabled/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="postcode">
                                    Data ostatniej edycji
                                </label>
                                <input type="text" class="form-control" name="updated_at" value="{{ $showUser->updated_at }}" tabindex="4" disabled/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="postcode">
                                    Data usunięcia
                                </label>
                                <input type="text" class="form-control" name="deleted_at" value="{{ $showUser->deleted_at }}" tabindex="5" disabled/>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div>
                        <a href="{{ route('companyUsers.admin') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="6">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
