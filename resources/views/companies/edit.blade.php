@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-building"></i>
                Edytuj firmę
            </h1>
        </div>
    </div>
</div>
<hr><br>
<div class="container-fluid">
    <div class='row'>
        <div class="col-sm-10 col-lg-8 offset-sm-1 offset-lg-4">
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
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card">
                <div class="card-header">Edytuj firmę</div>

                <div class="card-body" style="margin-left: 3%;">
                    <form id="edit-company-form" method="post" action="{{ route('companies.update', $company->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class='row'>
                            <div class="col-lg-4">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="p-3 col-sm-12">
                                        Nazwa firmy
                                        <input type="text" class="form-control" name="name" value="{{ $company->name }}" placeholder="Firma sp. z o.o." tabindex="1"/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="p-3 col-sm-12">
                                        E-mail kontaktowy
                                        <input type="email" class="form-control" name="email" value="{{ $company->email }}" placeholder="admin@firma.pl" tabindex="6"/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="city" class="p-3 col-sm-12">
                                        Miasto
                                        <input type="text" class="form-control" name="city" value="{{ $company->city }}" placeholder="Miasto" tabindex="4"/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="tax_number" class="p-3 col-sm-12">
                                        NIP
                                        <input type="text" class="form-control" name="tax_number" value="{{ $company->tax_number }}" placeholder="1112223344" tabindex="2"/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="phone" class="p-3 col-sm-12">
                                        Telefon kontaktowy
                                        <input type="text" class="form-control" name="phone" value="{{ $company->phone }}" placeholder="111222333" tabindex="7"/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="postcode" class="p-3 col-sm-12">
                                        Kod pocztowy
                                        <input type="text" class="form-control" name="postcode" value="{{ $company->postcode }}" placeholder="00-000" tabindex="5"/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="sub_exp_date" class="p-3 col-sm-10">
                                        Subskrybcja do
                                        <input type="date" class="form-control" name="sub_exp_date" value="{{ $company->sub_exp_date }}" tabindex="8"/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4 m-3">
                                <a href="{{ route('companies.index') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="9">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <button type="submit" title="Zapisz" class="btn btn-primary" tabindex="10">
                                    <i class="far fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
