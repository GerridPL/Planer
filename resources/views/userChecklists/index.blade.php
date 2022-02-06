@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-users-cog"></i>
                Listy użytkownika
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
                            <a style="margin-right: 5px;" title="Cofnij" href="{{ route('companyUsers.index') }}" type="button" class="btn btn-secondary float-left" tabindex="1">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>

                        <button style="margin-right: 5px;" title="Dodaj listę" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_point" >
                            <i class="far fa-plus-square"></i>
                        </button>
                        <!-- Początek modala dodawania listy -->
                            <div class="modal fade" id="add_point" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">Wybierz listę</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <!-- Początek body modala -->
                                    <form action="{{ route('userchecklists.add', $userId) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <label for="new_checklist" class="col-sm-12 p-3">
                                            Lista
                                            <select class="form-control form-select" name="new_checklist">
                                                @foreach ($checklists as $checklist)
                                                    <option value="{{ $checklist->id }}">{{ $checklist->name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <div class="form-group">
                                            <label for="sub_exp_date" class="col-sm-12 p-3">
                                                Termin
                                                <input type="date" class="form-control" name="term" value="{{ date('Y-m-d') }}"/>
                                            </label>
                                        </div>
                                        <label for="description" class="col-sm-12 p-3">Opis listy konrtolnej
                                            <textarea class="form-control" name="description" data-validation="custom" data-validation-regexp="^[a-zA-Z ]{2,30}$" row="3" col="200" tabindex="2"></textarea>
                                        </label>
                                        <div class="form-check form-switch ms-3">
                                            <input class="form-check-input" type="checkbox" name="realizationAfterTerm" id="realizationAfterTerm">
                                            <label class="form-check-label" for="realizationAfterTerm">Realizacja po terminie</label>
                                        </div>

                                        <div class="form-group p-2 ms-2">
                                            <input type="file" name="file" placeholder="Dodaj załącznik" id="chooseFile">
                                                @error('file')
                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                @enderror
                                        </div>

                                    <!-- Koniec body modala -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                        <button type="submit" title="Zapisz" class="btn btn-primary">
                                            <i class="far fa-save"></i>
                                        </button>
                                    </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        <!-- Koniec modala dodającego listę -->
                        <div>
                            <button type="button" title="Wybierz kolumny" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category_columns" >
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
                                                <input class="form-check-input" type="checkbox" value="" onclick="showDescription()" id="description_checkbox">
                                                <label class="form-check-label" for="flexCheckDisabled">
                                                Opis
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="showCategory()" id="category_checkbox">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                Kategoria
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="showAddedBy()" id="added_by_checkbox">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                Przydzielił
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="showTemplate()" id="template_checkbox">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                Szablon
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="showRealization()" id="realization_checkbox" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                Realizacja
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="showStatus()" id="status_checkbox" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                Status
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="showTerm()" id="term_checkbox" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                Termin
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" onclick="showAllowAfterTerm()" id="allowAfterTerm_checkbox">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                Pozwól po terminie
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
                <br>
                <h4 style="margin-left: 1%">Listy użytkownika: {{ $companyUser->email  }}</h4>
                <table id="user_checklists_table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th class="col-sm-5">Nazwa</th>
                            <th class="description_class col-sm-5" style="display: none">Opis</th>
                            <th class="category_class col-sm-2" style="display: none">Kategoria</th>
                            <th class="added_by_class col-sm-2" style="display: none">Przydzielił</th>
                            <th class="template_class col-sm-2" style="display: none">Szablon</th>
                            <th class="realization_class col-sm-2">Realizacja</th>
                            <th class="status_class col-sm-2">Status</th>
                            <th class="term_class col-sm-2">Termin</th>
                            <th class="allowAfterTerm_class col-sm-2" style="display: none">Pozwól po terminie</th>
                            <th class="col-sm-1" style="text-align: center">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userChecklists as $checklist)
                        {{-- If kolorujący nagłówki zgodnie z poziomem realizacji --}}
                        @if($checklist->status==0 && $checklist->realization==0)
                            <tr>
                        @elseif($checklist->status==0 && $checklist->realization!=0)
                            <tr class="table-warning">
                        @elseif($checklist->status==1)
                            <tr class="table-success">
                        @else
                            <tr>
                        @endif
                        {{-- Koniec If zaznaczającego na czerwono nagłówki dezaktywowane --}}
                                <td class="col-sm-5">{{ $checklist->name }}</td>
                                <td class="description_class col-sm-5" style="display: none">{{ $checklist->description }}</td>
                                <td class="category_class col-sm-2" style="display: none">{{ $checklist->checklist_category_relation->name}}</td>
                                <td class="added_by_class col-sm-2" style="display: none">{{ $checklist->allocated_by_relation->email}}</td>
                                @if($checklist->global_checklist_relation != null)
                                    <td class="template_class col-sm-2" style="display: none">{{ $checklist->global_checklist_relation->name}}</td>
                                @else
                                    <td class="template_class col-sm-2" style="display: none">Dezaktywowany</td>
                                @endif
                                <td class="realization_class col-sm-2">{{ $checklist->realization }}%</td>
                                @if($checklist->status == 0)
                                    <td class="status_class col-sm-2">Nie zamknięto</td>
                                @else
                                    <td class="status_class col-sm-2">Zamknięto</td>
                                @endif
                                @if($checklist->term != null)
                                    <td class="term_class col-sm-2">{{ $checklist->term}}</td>
                                @else
                                    <td class="term_class col-sm-2">Nie przypisano</td>
                                @endif
                                @if($checklist->allowAfterTerm == true)
                                    <td class="allowAfterTerm_class col-sm-2" style="display: none">Tak</td>
                                @else
                                    <td class="allowAfterTerm_class col-sm-2" style="display: none">Nie</td>
                                @endif
                                <td style="text-align: center" width="100" class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <a type="button" style="margin-right: 5px;" title="Edytuj" class="btn btn-primary" href="{{ route('userchecklists.edit' ,$checklist->id) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <br>
                                        <a type="button" style="margin-right: 5px;" title="Drukuj" class="btn btn-primary" href="{{ route('userchecklists.createPDF', $checklist->id) }}">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <br>
                                        @if($checklist->file != null)
                                        <a type="button" style="margin-right: 5px;" title="Pobierz" class="btn btn-primary" href="{{ route('userchecklists.download', $checklist->id) }}">
                                            <i class="fas fa-file-download"></i>
                                        </a>
                                        @endif
                                        <br>
                                        <form action="{{ route('userchecklists.destroy' ,[$checklist->id, $userId]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button style="margin-right: 5px;" title="Usuń" class="btn btn-danger"
                                                type="submit">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
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
            $('#user_checklists_table').DataTable({
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
        function showCategory() {
        var checkBox_category = document.getElementById("category_checkbox");
        var category = Array.from(document.getElementsByClassName("category_class"));
            category.forEach(element => {
            if (checkBox_category.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

    <script>
        function showAddedBy() {
        var checkBox_added_by = document.getElementById("added_by_checkbox");
        var added_by = Array.from(document.getElementsByClassName("added_by_class"));
            added_by.forEach(element => {
            if (checkBox_added_by.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

<script>
    function showTemplate() {
    var checkBox_template = document.getElementById("template_checkbox");
    var template = Array.from(document.getElementsByClassName("template_class"));
        template.forEach(element => {
        if (checkBox_template.checked == true) {
            element.style.display = "table-cell";
        } else {
            element.style.display = "none";
        }
        });
    };
</script>

    <script>
        function showRealization() {
        var checkBox_realization = document.getElementById("realization_checkbox");
        var realization = Array.from(document.getElementsByClassName("realization_class"));
            realization.forEach(element => {
            if (checkBox_realization.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
            });
        };
    </script>

<script>
    function showStatus() {
    var checkBox_status = document.getElementById("status_checkbox");
    var status = Array.from(document.getElementsByClassName("status_class"));
        status.forEach(element => {
        if (checkBox_status.checked == true) {
            element.style.display = "table-cell";
        } else {
            element.style.display = "none";
        }
        });
    };
</script>

<script>
    function showAllowAfterTerm() {
    var checkBox_allowAfterTerm = document.getElementById("allowAfterTerm_checkbox");
    var allowAfterTerm = Array.from(document.getElementsByClassName("allowAfterTerm_class"));
        allowAfterTerm.forEach(element => {
        if (checkBox_allowAfterTerm.checked == true) {
            element.style.display = "table-cell";
        } else {
            element.style.display = "none";
        }
        });
    };
</script>

@endsection
