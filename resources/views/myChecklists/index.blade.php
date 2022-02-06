@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="far fa-calendar-check"></i>
                Moje listy
            </h1>
        </div>
    </div>
</div>
<hr><br>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group ms-4" role="group">
                <button type="button" style="margin-right: 5px;" title="Wybierz kolumny" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checklist_columns">
                    <i class="fas fa-columns"></i>
                </button>
                <!-- Początek modala zarządzającego kolumnami -->
                <div class="modal fade" id="checklist_columns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <label class="form-check-label" for="flexCheckDisabled">
                                        Opis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showCategory()" id="category_checkbox">
                                    <label class="form-check-label" for="flexCheckCheckedDisabled">
                                        Kategoria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showAddedBy()" id="added_by_checkbox">
                                    <label class="form-check-label" for="flexCheckCheckedDisabled">
                                        Przydzielił
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showRealization()" id="realization_checkbox" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Realizacja
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showTerm()" id="term_checkbox">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Termin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showDaysToRealization()" id="daysToRealization_checkbox" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Dni do realizacji
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showAllowAfterTerm()" id="allowAfterTerm_checkbox">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Pozwól po terminie
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showStatus()" id="status_checkbox">
                                    <label class="form-check-label" for="flexCheckChecked">
                                    Status
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
                <button type="button" style="margin-right: 5px;" title="Filtruj" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category_columns" >
                    <i class="fas fa-filter"></i>
                </button>
                <!-- Początek modala zarządzającego filtrami -->
                    <div class="modal fade" id="category_columns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">Filtry</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <!-- Początek body modala -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showRealized()" id="realized_checkbox">
                                    <label class="form-check-label" for="flexCheckCheckedDisabled">
                                        Zrealizowane
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" onclick="showExpired()" id="expired_checkbox">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Przeterminowane
                                    </label>
                                </div>
                                        <!-- Koniec body modala -->
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- Koniec modala zarządzającego filtrami -->
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <table id="my_checklists_table" class="table">
                <thead class="table-primary">
                    <tr>
                        <th class="col-sm-5">Nazwa</th>
                        <th class="description_class col-sm-5">Opis</th>
                        <th class="category_class col-sm-2" style="display: none">Kategoria</th>
                        <th class="added_by_class col-sm-2" style="display: none">Przydzielił</th>
                        <th class="realization_class col-sm-1">Realizacja</th>
                        <th class="term_class col-sm-1" style="display: none">Termin</th>
                        <th class="daysToRealization_class col-sm-1">Pozostało</th>
                        <th class="allowAfterTerm_class col-sm-1" style="display: none">Pozwól po terminie</th>
                        <th class="status_class col-sm-1" style="display: none">Status</th>
                        <th style="width: 3%;">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checklists as $checklist)
                    {{-- If zaznaczający na zielono listy zrealizowane --}}
                    @if ($checklist->term < $currentDate && $checklist->allowAfterTerm == false)
                        <tr class="table-danger expired_class" style="display: none">
                    @elseif ($checklist->status == 1)
                        <tr class="table-success realized_class" style="display: none">
                    @elseif ($checklist->term < $currentDate && $checklist->allowAfterTerm == true)
                        <tr class="table-warning">
                    @else
                        <tr>
                    @endif
                    {{-- Koniec If zaznaczającego na zielono --}}

                        <td class="col-sm-5">{{ $checklist->name }}</td>
                        <td class="description_class col-sm-5">{{ $checklist->description }}</td>
                        <td class="category_class col-sm-2" style="display: none">{{ $checklist->checklist_category_relation->name}}</td>
                        <td class="added_by_class col-sm-2" style="display: none">{{ $checklist->allocated_by_relation->email}}</td>
                        <td class="realization_class col-sm-1">{{ $checklist->realization}}%</td>
                        <td class="term_class col-sm-1" style="display: none">{{ $checklist->term}}</td>
                        @if ($checklist->dateOfRealization != null)
                            <td class="daysToRealization_class col-sm-1">Zrealizowano {{$checklist->dateOfRealization}}</td>
                        @elseif($checklist->daysToRealization != null)
                            <td class="daysToRealization_class col-sm-1">{{ $checklist->daysToRealization}} dni</td>
                        @else
                            <td class="daysToRealization_class col-sm-1">0 dni</td>
                        @endif

                        @if($checklist->allowAfterTerm == true)
                            <td class="allowAfterTerm_class col-sm-1" style="display: none">Tak</td>
                        @else
                            <td class="allowAfterTerm_class col-sm-1" style="display: none">Nie</td>
                        @endif
                        @if($checklist->status == 0)
                            <td class="status_class col-sm-1" style="display: none">Nie zamknięto</td>
                        @else
                            <td class="status_class col-sm-1" style="display: none">Zamknięto</td>
                        @endif
                        <td style="text-align: center" width="3%" class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                            @if ($checklist->status == 0)
                            <a type="button" title="Realizuj listę" style="margin-right: 5px;" class="btn btn-success" href="{{ route('mychecklists.realization' ,$checklist->id) }}">
                                <i class="fas fa-check-square"></i>
                            </a>
                            <br>
                            <a type="button" title="Drukuj" style="margin-right: 5px;" class="btn btn-primary" href="{{ route('mychecklists.createPDF', $checklist->id) }}">
                                <i class="fas fa-print"></i>
                            </a>
                                @if($checklist->file != null)
                                    <br>
                                    <a type="button" style="margin-right: 5px;" title="Pobierz" class="btn btn-primary" href="{{ route('mychecklists.download', $checklist->id) }}">
                                        <i class="fas fa-file-download"></i>
                                    </a>
                                @endif
                            @else
                            <a type="button" title="Drukuj" style="margin-right: 5px;" class="btn btn-primary" href="{{ route('mychecklists.createPDF', $checklist->id) }}">
                                <i class="fas fa-print"></i>
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
            $('#my_checklists_table').DataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                "order": [[ 3, "desc" ]],
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
                    element.style.display = "";
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
                    element.style.display = "";
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
                    element.style.display = "";
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
    function showTerm() {
        var checkBox_term = document.getElementById("term_checkbox");
        var term = Array.from(document.getElementsByClassName("term_class"));
        term.forEach(element => {
            if (checkBox_term.checked == true) {
                element.style.display = "table-cell";
            } else {
                element.style.display = "none";
            }
        });
    };

</script>

<script>
    function showAllowAfterTerm() {
        var checkBox_AllowAfterTerm = document.getElementById("allowAfterTerm_checkbox");
        var allowAfterTerm = Array.from(document.getElementsByClassName("allowAfterTerm_class"));
        allowAfterTerm.forEach(element => {
            if (checkBox_AllowAfterTerm.checked == true) {
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
    function showDaysToRealization() {
    var checkBox_daysToRealization = document.getElementById("daysToRealization_checkbox");
    var daysToRealization = Array.from(document.getElementsByClassName("daysToRealization_class"));
    daysToRealization.forEach(element => {
        if (checkBox_daysToRealization.checked == true) {
            element.style.display = "table-cell";
        } else {
            element.style.display = "none";
        }
        });
    };
</script>

<script>
    function showRealized() {
    var checkBox_realized = document.getElementById("realized_checkbox");
    var realized = Array.from(document.getElementsByClassName("realized_class"));
        realized.forEach(element => {
        if (checkBox_realized.checked == true) {
            element.style.display = "table-row";
        } else {
            element.style.display = "none";
        }
        });
    };
</script>

<script>
    function showExpired() {
    var checkBox_expired = document.getElementById("expired_checkbox");
    var expired = Array.from(document.getElementsByClassName("expired_class"));
        expired.forEach(element => {
        if (checkBox_expired.checked == true) {
            element.style.display = "table-row";
        } else {
            element.style.display = "none";
        }
        });
    };
</script>
@endsection
