@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-clipboard-list"></i>
                Dodaj kategorię
            </h1>
        </div>
    </div>
</div>
<hr><br>
    <div class="container-fluid">
        <div class='row'>
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
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-5">
                <div class="card">
                    <div class="card-header">Dodaj kategorię</div>
                        <div class="card-body" style="margin-left: 3%;">
                            <form id="create-category-form" method="post" action="{{ route('categories.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="col-10 p-3">
                                        Nazwa kategorii
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" tabindex="1"/>
                                    </label>
                                </div>
                                <label for="description" class="col-9 p-3">Opis kategorii
                                <textarea class="form-control" name="description" data-validation="custom" data-validation-regexp="^[a-zA-Z ]{2,30}$" row="3" col="200" tabindex="2"></textarea>
                                </label>
                                <div class="p-3">
                                    <a href="{{ route('categories.index') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="3">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    <button type="submit" title="Zapisz" class="btn btn-primary" tabindex="4">
                                        <i class="far fa-save"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
