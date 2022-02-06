@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-building"></i>
                Firmy
            </h1>
        </div>
    </div>
</div>
<hr><br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 ms-4">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <div>
                        <a style="margin-right: 5px;" title="Dodaj firmę" href="{{ route('companies.create')}}" class="btn btn-success float-left">
                            <i class="far fa-plus-square"></i>
                        </a>
                    </div>
                    <div>
                        <button type="button" title="Wybierz kolumny" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#companies_columns" >
                            <i class="fas fa-columns"></i>
                        </button>
                        <!-- Początek modala zarządzającego kolumnami -->
                            <div class="modal fade" id="companies_columns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">Wybierz kolumny</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <!-- Początek body modala -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="name_checkbox" checked disabled>
                                            <label class="form-check-label" for="flexCheckDisabled">
                                            Nazwa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="tax_number_checkbox" checked disabled>
                                            <label class="form-check-label" for="flexCheckCheckedDisabled">
                                            NIP
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="sub_exp_date_checkbox" checked disabled>
                                            <label class="form-check-label" for="flexCheckCheckedDisabled">
                                            Subskrybcja do
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" onclick="showCity()" id="city_checkbox">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Miasto
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" onclick="showPostcode()" id="postcode_checkbox">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Kod pocztowy
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" onclick="showEmail()" id="email_checkbox">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            E-mail
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" onclick="showPhone()" id="phone_checkbox">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Telefon
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" onclick="showCreatedAt()" id="created_at_checkbox">
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Data utworzenia
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" onclick="showUpdatedAt()" id="updated_at_checkbox">
                                            <label class="form-check-label" for="flexCheckChecked">
                                            Data edycji
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" onclick="showDeletedAt()" id="deleted_at_checkbox">
                                            <label class="form-check-label" for="flexCheckChecked">
                                            Data usunięcia
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="action_checkbox" checked disabled>
                                            <label class="form-check-label" for="flexCheckCheckedDisabled">
                                            Akcja
                                            </label>
                                        </div>
                                    <!-- Koniec body modala -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <!-- Koniec modala zarządzającego kolumnami -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="companies_table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th class="col-sm-3">Nazwa</th>
                            <th class="col-sm-1">NIP</th>
                            <th class="col-sm-1">Subskrybcja do</th>
                            <th class="city_class col-sm-1" style="display: none">Miasto</th>
                            <th class="postcode_class col-sm-1" style="display: none">Kod pocztowy</th>
                            <th class="email_class col-sm-1" style="display: none">E-mail</th>
                            <th class="phone_class col-sm-1" style="display: none">Telefon</th>
                            <th class="created_at_class col-sm-1" style="display: none">Data utworzenia</th>
                            <th class="updated_at_class col-sm-1" style="display: none">Data edycji</th>
                            <th class="deleted_at_class col-sm-1" style="display: none">Data usunięcia</th>
                            <th style="text-align: center; width: 4%;">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                        {{-- If zaznaczający na czerwono firmy dezaktywowane --}}
                        @if (!isset($company->deleted_at))
                            <tr>
                        @else
                            <tr class="table-danger">
                        @endif
                        {{-- Koniec If zaznaczającego na czerwono firmy dezaktywowane --}}
                                <td class="col-sm-3">{{ $company->name }}</td>
                                <td class="col-sm-1">{{ $company->tax_number }}</td>
                                @if ($company->sub_exp_date < Carbon\Carbon::now())
                                <td class="col-sm-1 table-danger">{{ $company->sub_exp_date }}</td>
                                @elseif ($company->sub_exp_date < Carbon\Carbon::now()->addDays(30))
                                <td class="col-sm-1 table-warning">{{ $company->sub_exp_date }}</td>
                                @else
                                <td class="col-sm-1">{{ $company->sub_exp_date }}</td>
                                @endif
                                <td class="city_class col-sm-1" style="display: none">{{ $company->city}}</td>
                                <td class="postcode_class col-sm-1" style="display: none">{{ $company->postcode}}</td>
                                <td class="email_class col-sm-1" style="display: none">{{ $company->email}}</td>
                                <td class="phone_class col-sm-1" style="display: none">{{ $company->phone}}</td>
                                <td class="created_at_class col-sm-1" style="display: none">{{ $company->created_at}}</td>
                                <td class="updated_at_class col-sm-1" style="display: none">{{ $company->updated_at}}</td>
                                <td class="deleted_at_class col-sm-1" style="display: none">{{ $company->deleted_at}}</td>
                                <td style="text-align: center" width="4%" class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        {{-- If określający akcje dostępne dla firmy (inne dla aktywnych) --}}
                                        @if (!isset($company->deleted_at))
                                            <a type="button" style="margin-right: 5px;" title="Wyświetl" class="btn btn-secondary" href="{{ route('companies.show' ,$company->id) }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <br>
                                            <a type="button" style="margin-right: 5px;" title="Edytuj" class="btn btn-primary" href="{{ route('companies.edit' ,$company->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <br>
                                            <form action="{{ route('companies.destroy' ,$company->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Dezaktywuj" style="margin-right: 5px;" class="btn btn-danger"
                                                    type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @else
                                            {{-- Akcje dla dezaktywowanej firmy --}}
                                                    <a type="button" style="margin-right: 5px;" title="Wyświetl" class="btn btn-secondary" href="{{ route('companies.show' ,$company->id) }}">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                    <br>
                                                    <a type="button" style="margin-right: 5px;" title="Przywróć" class="btn btn-success" href="{{ route('companies.restore' ,$company->id) }}">
                                                        <i class="fas fa-undo-alt"></i>
                                                    </a>
                                            @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-scripts')
    <script src="{{ asset('js/external/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/external/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#companies_table').DataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                language: {
                    url: '{{ asset('language/Polish.json') }}'
                }
            });
        });
    </script>

    <script>
        function showCity() {
        var checkBox_city = document.getElementById("city_checkbox");
        var city = Array.from(document.getElementsByClassName("city_class"));
            city.forEach(element => {
            if (checkBox_city.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

    <script>
        function showPostcode() {
        var checkBox_postcode = document.getElementById("postcode_checkbox");
        var postcode = Array.from(document.getElementsByClassName("postcode_class"));
            postcode.forEach(element => {
            if (checkBox_postcode.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

    <script>
        function showEmail() {
        var checkBox_email = document.getElementById("email_checkbox");
        var email = Array.from(document.getElementsByClassName("email_class"));
            email.forEach(element => {
            if (checkBox_email.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

    <script>
        function showPhone() {
        var checkBox_phone = document.getElementById("phone_checkbox");
        var phone = Array.from(document.getElementsByClassName("phone_class"));
            phone.forEach(element => {
            if (checkBox_phone.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

    <script>
        function showCreatedAt() {
        var checkBox_created_at = document.getElementById("created_at_checkbox");
        var created_at = Array.from(document.getElementsByClassName("created_at_class"));
            created_at.forEach(element => {
            if (checkBox_created_at.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

    <script>
        function showUpdatedAt() {
        var checkBox_updated_at = document.getElementById("updated_at_checkbox");
        var updated_at = Array.from(document.getElementsByClassName("updated_at_class"));
            updated_at.forEach(element => {
            if (checkBox_updated_at.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

    <script>
        function showDeletedAt() {
        var checkBox_deleted_at = document.getElementById("deleted_at_checkbox");
        var deleted_at = Array.from(document.getElementsByClassName("deleted_at_class"));
            deleted_at.forEach(element => {
            if (checkBox_deleted_at.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>
@endsection
