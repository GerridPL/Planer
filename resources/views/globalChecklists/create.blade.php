@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-list-alt"></i>
                Dodaj szablon
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
            <div class="col-sm-11 col-md-6">
                <div class="card">
                    <div class="card-header">Dodaj szablon</div>
                    <div class="card-body" style="margin-left: 3%;">
                        <form id="create-checklists-form" method="post" action="{{ route('globalChecklists.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-9">
                                Nazwa
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" tabindex="1"/>
                            </label>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="category" class="col-8">
                                Kategoria
                                <select class="form-control form-select" name="category" tabindex="2">
                                    @foreach ($category as $category)
                                    <option title="{{ $category->description }}" value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <br>
                        <a href="{{ route('globalChecklists.index') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="4">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <button type="submit" title="Zapisz" class="btn btn-primary" tabindex="3">
                            <i class="far fa-save"></i>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
