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
        <div class="col-md-9 col-lg-8">
            <div class="card">
                <div class="card-header">Informacje o użytkowniku: {{ $user->email }}</div>

                <div class="card-body" style="margin-left: 3%;">
                    <div class='row'>
                        <div class="col-md-7 col-lg-6">
                            <div class="form-group">
                                <label for="email" class="p-3 col-sm-12">
                                    Adres e-mail
                                    <input type="text" class="form-control" name="name" value="{{ $user->email }}" tabindex="1" disabled/>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-7 col-lg-6">
                            <div class="form-group">
                                <label for="role" class="p-3 col-sm-12">
                                    Uprawnienie
                                    <input type="text" class="form-control" name="name" value="{{ $role->name }}" tabindex="2" disabled/>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-md-7 col-lg-6">
                            <div class="form-group">
                                <label for="company" class="p-3 col-sm-12">
                                    Firma
                                    <input type="text" class="form-control" name="name" value="{{ $user->user_company_relation->name }}" tabindex="3" disabled/>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <div class='row'>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="postcode" class="p-3 col-sm-12">
                                    Data dodania
                                    <input type="text" class="form-control" name="created_at" value="{{ $user->created_at }}" tabindex="4" disabled/>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="postcode" class="p-3 col-sm-12">
                                    Data ostatniej edycji
                                    <input type="text" class="form-control" name="updated_at" value="{{ $user->updated_at }}" tabindex="5" disabled/>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="postcode" class="p-3 col-sm-12">
                                    Data usunięcia
                                    <input type="text" class="form-control" name="deleted_at" value="{{ $user->deleted_at }}" tabindex="6" disabled/>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-lg-4 m-3">
                            <a href="{{ route('users.allUsers') }}" title="Cofnij" type="button" class="btn btn-secondary m-3" tabindex="7">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
