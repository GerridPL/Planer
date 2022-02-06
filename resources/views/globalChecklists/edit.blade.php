@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-list-alt"></i>
                Edytuj nagłówek szablonu
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
            <div class="col-sm-12 col-md-7">
                <div class="card">
                    <div class="card-header">Edytuj nagłówek szablonu: {{ $checklist->name }}</div>
                    <div class="card-body" style="margin-left: 3%;">
                        <form id="edit-checklists-form" method="post" action="{{ route('globalChecklists.update', $checklist->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-8 pe-2">
                                    Nazwa szablonu
                                    <input type="text" class="form-control" name="name" value="{{ $checklist->name }}" tabindex="1"/>
                                </label>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="checklist_category" class="col-7">
                                    Kategoria
                                    <select class="form-control form-select" name="checklist_category" tabindex="2">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" title="{{ $category->description }} "
                                            @if(isset($checklist->checklist_category)
                                                && $checklist->checklist_category === $category -> id)
                                            selected
                                            @endif
                                            >{{ $category->name }}</option>
                                            @endforeach
                                    </select>
                                </label>
                            </div>
                            <br>

                            <a href="{{ route('globalpoints.index' ,$checklist->id) }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="4">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <button type="submit" class="btn btn-primary" title="Zapisz" tabindex="3">
                                <i class="far fa-save"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
