@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-list-alt"></i>
                Dodaj podpunkt
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
                    <div class="card-header">Podpunkt do: "{{ $globalPoint->description }}"</div>
                    <div class="card-body" style="margin-left: 3%;">
                        <form id="create-global-point-form" method="post" action="{{ route('globalpoints.storesubsection', [$index, $checklistId]) }}">
                            @csrf
                            <div class="form-group">
                                <label for="description" class="col-12">
                                    Opis podpunktu
                                    <input type="text" class="form-control" name="description" value="{{ old('description') }}" tabindex="1"/>
                                </label>
                            </div>
                            <br>
                            <a href="{{ route('globalpoints.index', $checklistId) }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="4">
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
