@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-clipboard-list"></i>
                Wyświetl kategorię
            </h1>
        </div>
    </div>
</div>
<hr><br>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Wyświetl kategorię: {{ $category->name }}</div>

                    <div class="card-body" style="margin-left: 3%;">
                        <div class='row'>
                            <div class="col-md-7 col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="col-12">
                                        Nazwa kategorii
                                        <input type="text" class="form-control" name="name" value="{{ $category->name }}" tabindex="1" disabled/>
                                    </label>
                                    </div>
                            </div>
                            <div class="col-md-7 col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="col-11">
                                        Opis
                                        <textarea type="text" class="form-control" name="description" tabindex="2" disabled/>{{ $category->description }}</textarea>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class='row'>

                            <div class="col-md-7 col-lg-6">
                                <div class="form-group">
                                    <label for="postcode" class="col-12">
                                        Data dodania
                                        <input type="text" class="form-control" name="created_at" value="{{ $category->created_at }}" tabindex="3" disabled/>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-7 col-lg-6">
                                <div class="form-group">
                                    <label for="postcode" class="col-12">
                                        Data ostatniej edycji
                                        <input type="text" class="form-control" name="updated_at" value="{{ $category->updated_at }}" tabindex="4" disabled/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div>
                            <a href="{{ route('categories.index') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="6">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
