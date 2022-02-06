@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-user-friends"></i>
                Edytuj uprawnienia
            </h1>
        </div>
    </div>
</div>
<hr><br>
    <div class="container-fluid">
        <div class='row'>
            <div class="col-sm-10 col-lg-8 offset-sm-1 offset-lg-3">
                <div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card">
                    <div class="card-header">Edytuj uprawnienia użytkownika: {{ $editedUser->email }}</div>

                    <div class="card-body">
                        <form id="edit-category-form" method="post" action="{{ route('companyUsers.update', $editedUser->id) }}">
                            @method('PATCH')
                            @csrf
                            @csrf
                            <div class="form-group">
                                <label for="currentRole" class="col-8 ps-1">
                                    Obecne uprawnienie
                                    <input type="text" class="form-control" name="name" value="{{ $role }}" tabindex="1" disabled/>
                                </label>
                                <br>
                                <br>
                                <label for="newRole" class="col-7">
                                    Wybierz nowe uprawnienie
                                    <select class="form-control form-select" name="newRole" tabindex="1">
                                        @foreach ($roles as $roles)
                                        <option value="{{ $roles->id }}">{{ $roles->name }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <br>
                            <div class="ps-0">
                                <a href="{{ route('companyUsers.admin') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="2">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <button type="submit" title="Zapisz" class="btn btn-primary" tabindex="3">
                                    <i class="far fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
