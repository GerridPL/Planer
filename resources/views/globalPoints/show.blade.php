@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class='row'>
            <div class="col-sm-10 col-lg-8 offset-sm-1 offset-lg-4">
                <h1>
                    Informacje o kategorii
                </h1>
            </div>
        </div>
        <form id="show-company-form">
            <div class='row'>
                <div class="col-sm-10 col-md-5 col-lg-3 offset-lg-1">
                    <div class="form-group">
                        <label for="name">
                            Nazwa kategorii
                        </label>
                        <input type="text" class="form-control" name="name" value="{{ $category->name }}" tabindex="1" disabled/>
                    </div>
                </div>
            </div>

            <hr/>

            <div class='row'>

                <div class="col-sm-10 col-md-5 col-lg-3 offset-lg-1">
                    <div class="form-group">
                        <label for="postcode">
                            Data dodania
                        </label>
                        <input type="text" class="form-control" name="created_at" value="{{ $category->created_at }}" tabindex="2" disabled/>
                    </div>
                </div>

                <div class="col-sm-10 col-md-5 col-lg-3">
                    <div class="form-group">
                        <label for="postcode">
                            Data ostatniej edycji
                        </label>
                        <input type="text" class="form-control" name="updated_at" value="{{ $category->updated_at }}" tabindex="3" disabled/>
                    </div>
                </div>

                <div class="col-sm-10 col-md-5 col-lg-3">
                    <div class="form-group">
                        <label for="postcode">
                            Data usunięcia
                        </label>
                        <input type="text" class="form-control" name="deleted_at" value="{{ $category->deleted_at }}" tabindex="4" disabled/>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class="col-sm-2 offset-5">
                    <a href="{{ route('categories.index') }}" type="button" class="btn btn-secondary" tabindex="5">
                        Cofnij
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
