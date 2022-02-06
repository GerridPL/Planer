@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card">
                    <div class="card-header">Informacje o szablonie</div>

                    <div class="card-body" style="margin-left: 3%;">
                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">
                                        Nazwa szablonu
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{ $checklist->name }}" tabindex="1" disabled/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">
                                        Autor
                                    </label>
                                    <input type="email" class="form-control" name="author" value="{{ $checklist->user->email}}" tabindex="2" disabled/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="category">
                                        Kategoria
                                    </label>
                                    <input type="text" class="form-control" name="category" value="{{ $checklist->category->name}}" tabindex="3" disabled/>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="add_date">
                                        Data dodania
                                    </label>
                                    <input type="text" class="form-control" name="created_at" value="{{ $checklist->created_at }}" tabindex="4" disabled/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="edit_date">
                                        Data ostatniej edycji
                                    </label>
                                    <input type="text" class="form-control" name="updated_at" value="{{ $checklist->updated_at }}" tabindex="5" disabled/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="delete_date">
                                        Data usunięcia
                                    </label>
                                    <input type="text" class="form-control" name="deleted_at" value="{{ $checklist->deleted_at }}" tabindex="6" disabled/>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class='row'>
                            <a href="{{ route('globalChecklists.index') }}" type="button" class="btn btn-secondary" tabindex="7">
                                Cofnij
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
