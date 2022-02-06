@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-building"></i>
                Wyświetl firmę
            </h1>
        </div>
    </div>
</div>
<hr><br>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card">
                    <div class="card-header">Wyświetl firmę</div>
                    <div class="card-body" style="margin-left: 3%;">
                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name" class="p-3 col-sm-12">
                                        Nazwa firmy
                                        <input type="text" class="form-control" name="name" value="{{ $company->name }}" tabindex="1" disabled/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="p-3 col-sm-12">
                                        E-mail kontaktowy
                                        <input type="email" class="form-control" name="email" value="{{ $company->email }}" tabindex="6" disabled/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="sub_exp_date" class="p-3 col-sm-11">
                                        Subskrybcja do
                                        <input type="date" class="form-control" name="sub_exp_date" value="{{ $company->sub_exp_date }}" tabindex="8" disabled/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="tax_number" class="p-3 col-sm-12">
                                        NIP
                                        <input type="text" class="form-control" name="tax_number" value="{{ $company->tax_number }}" tabindex="2" disabled/>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="phone" class="p-3 col-sm-12">
                                        Telefon kontaktowy
                                        <input type="text" class="form-control" name="phone" value="{{ $company->phone }}" tabindex="7" disabled/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="city" class="p-3 col-sm-12">
                                        Miasto
                                        <input type="text" class="form-control" name="city" value="{{ $company->city }}" tabindex="4" disabled/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="postcode" class="p-3 col-sm-12">
                                        Kod pocztowy
                                        <input type="text" class="form-control" name="postcode" value="{{ $company->postcode }}" tabindex="5" disabled/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="id_company" class="p-3 col-sm-12">
                                        Identyfikator firmy
                                        <input type="text" class="form-control" name="id" value="{{ $company->id }}" tabindex="9" disabled/>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="created_at" class="p-3 col-sm-12">
                                        Data dodania
                                        <input type="text" class="form-control" name="created_at" value="{{ $company->created_at }}" tabindex="10" disabled/>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="updated_at" class="p-3 col-sm-12">
                                        Data ostatniej edycji
                                        <input type="text" class="form-control" name="updated_at" value="{{ $company->updated_at }}" tabindex="11" disabled/>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="deleted_at" class="p-3 col-sm-12">
                                        Data usunięcia
                                        <input type="text" class="form-control" name="deleted_at" value="{{ $company->deleted_at }}" tabindex="12" disabled/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-lg-4 m-3">
                                <a href="{{ route('companies.index') }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="9">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
