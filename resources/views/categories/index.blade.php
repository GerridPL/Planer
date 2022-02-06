@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-clipboard-list"></i>
                Zarządzaj kategoriami
            </h1>
        </div>
    </div>
</div>
<hr><br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 ms-4">
                <div class="btn-group" role="group">
                    <div>
                        <a style="margin-right: 5px;" href="{{ route('categories.create')}}"
                            class="btn btn-success float-left">
                            <i class="far fa-plus-square"></i>
                        </a>
                    </div>
                    <div>
                        <button type="button" style="margin-right: 5px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category_columns" >
                            <i class="fas fa-columns"></i>
                        </button>
                        <!-- Początek modala zarządzającego kolumnami -->
                            <div class="modal fade" id="category_columns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <input class="form-check-input" type="checkbox" value="" onclick="showDescription()" id="description_checkbox" checked>
                                            <label class="form-check-label" for="flexCheckDefault">
                                            Opis
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
                                            <input class="form-check-input" type="checkbox" value="" id="action_checkbox" checked disabled>
                                            <label class="form-check-label" for="flexCheckCheckedDisabled">
                                            Akcja
                                            </label>
                                        </div>
                                    <!-- Koniec body modala -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" title="Zamknij" class="btn btn-secondary" data-bs-dismiss="modal">
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
                <table id="categories_table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th class="col-sm-4">Nazwa</th>
                            <th class="description_class col-sm-5">Opis</th>
                            <th class="created_at_class col-sm-2" style="display: none">Data utworzenia</th>
                            <th class="updated_at_class col-sm-2" style="display: none">Data edycji</th>
                            <th style="text-align: center; width: 5%">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        {{-- If zaznaczający na czerwono kategorie dezaktywowane --}}
                        @if ($category->deactivated == false)
                            <tr>
                        @else
                            <tr class="table-danger">
                        @endif
                        {{-- Koniec If zaznaczającego na czerwono kategorie dezaktywowane --}}
                                <td class="col-sm-4">{{ $category->name }}</td>
                                <td class="description_class col-sm-5">{{ $category->description }}</td>
                                <td class="created_at_class col-sm-2" style="display: none">{{ $category->created_at}}</td>
                                <td class="updated_at_class col-sm-2" style="display: none">{{ $category->updated_at}}</td>
                                <td style="text-align: center" width="100" class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    {{-- If określający akcje dostępne dla kategorii (inne dla aktywnych) --}}
                                        @if ($category->deactivated == false)
                                            <a type="button" style="margin-right: 5px;" title="Wyświetl" class="btn btn-secondary" href="{{ route('categories.show' ,$category->id) }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <br>
                                            <a type="button" style="margin-right: 5px;" title="Edytuj" class="btn btn-primary" href="{{ route('categories.edit' ,$category->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <br>
                                            <a type="button" style="margin-right: 5px;" title="Dezaktywuj" class="btn btn-danger" href="{{ route('categories.destroy' ,$category->id) }}">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        @else
                                        {{-- Akcje dla dezaktywowanej kategorii --}}
                                            <a type="button" style="margin-right: 5px;" title="Wyświetl" class="btn btn-secondary" href="{{ route('categories.show' ,$category->id) }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a type="button" style="margin-right: 5px;" title="Przywróć" class="btn btn-success" href="{{ route('categories.restore' ,$category->id) }}">
                                                <i class="fas fa-undo-alt"></i>
                                            </a>
                                        @endif
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
            $('#categories_table').DataTable({
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
        function showDescription() {
        var checkBox_description = document.getElementById("description_checkbox");
        var description = Array.from(document.getElementsByClassName("description_class"));
            description.forEach(element => {
            if (checkBox_description.checked == true) {
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

@endsection
