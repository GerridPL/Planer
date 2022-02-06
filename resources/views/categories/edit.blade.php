@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-clipboard-list"></i>
                Edytuj kategorię
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
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header">Edytuj kategorię: {{ $category->name }}</div>
                        <div class="card-body" style="margin-left: 3%;">
                            <form id="edit-category-form" method="post" action="{{ route('categories.update', $category->id) }}">
                                @method('PATCH')
                                @csrf
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="col-9 p-3">
                                        Nazwa kategorii
                                        <input type="text" class="form-control" name="name" value="{{ $category->name }}" tabindex="1"/>
                                    </label>
                                    <label for="description" class="col-8 p-3">
                                        Opis kategorii
                                        <textarea class="form-control" name="description" data-validation="custom" data-validation-regexp="^[a-zA-Z ]{2,30}$" row="3" col="200"> {{ $category->description }}</textarea>
                                    </label>
                                </div>
                                <div class="p-3">
                                    <a href="{{ route('categories.index') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="2">
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
    </div>
@endsection
