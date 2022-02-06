@extends('layouts.app')

@section('content')



<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-list-alt"></i>
                Edytuj szablon
            </h1>
        </div>
    </div>
</div>
<hr><br>


    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-center">
                    <div class="col-sm-12">
                            <div class='row ms-1'>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name" class="col-12 p-3">
                                            Nazwa szablonu
                                            <input type="text" class="form-control" name="name" value="{{ $checklist->name }}" tabindex="1" disabled/>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="email" class="col-12 p-3">
                                            Autor
                                            <input type="email" class="form-control" name="author" value="{{ $checklist->user->email}}" tabindex="2" disabled/>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="category" class="col-12 p-3">
                                            Kategoria
                                            <input type="text" class="form-control" name="category" value="{{ $checklist->category->name}}" tabindex="3" disabled/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class='row ms-1'>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name" class="col-12 p-3 pe-5">
                                            Opis
                                            <textarea type="text" class="form-control" name="name" tabindex="4" disabled/>{{ $checklist->category->description }}</textarea>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr/>

                            <div class='row ms-1'>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="add_date" class="col-12 p-3">
                                            Data dodania
                                            <input type="text" class="form-control" name="created_at" value="{{ $checklist->created_at }}" tabindex="5" disabled/>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="edit_date" class="col-12 p-3">
                                            Data ostatniej edycji
                                            <input type="text" class="form-control" name="updated_at" value="{{ $checklist->updated_at }}" tabindex="6" disabled/>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="delete_date" class="col-12 p-3">
                                            Data usunięcia
                                            <input type="text" class="form-control" name="deleted_at" value="{{ $checklist->deleted_at }}" tabindex="7" disabled/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="btn-group ms-4" role="group">
                                        <div>
                                            <a style="margin-right: 5px;" title="Cofnij" href="{{ route('globalChecklists.index') }}" type="button" class="btn btn-secondary float-left" tabindex="8">
                                                <i class="fas fa-arrow-left"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <a style="margin-right: 5px;" title="Dodaj punkt" href="{{ route('globalpoints.create', $checklistId )}}" class="btn btn-success float-left" tabindex="9">
                                                <i class="far fa-plus-square"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <button style="margin-right: 5px;" type="button" title="Wybierz kolumny" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#globalpoints_columns" >
                                                <i class="fas fa-columns"></i>
                                            </button>
                                            <!-- Początek modala zarządzającego kolumnami -->
                                                <div class="modal fade" id="globalpoints_columns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalLabel">Wybierz kolumny</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <!-- Początek body modala -->
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="index_checkbox" checked disabled>
                                                                <label class="form-check-label" for="flexCheckCheckedDisabled">
                                                                Indeks
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="name_checkbox" checked disabled>
                                                                <label class="form-check-label" for="flexCheckDisabled">
                                                                Nazwa
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" onclick="showOverridingPoint()" id="overriding_point_checkbox">
                                                                <label class="form-check-label" for="flexCheckDisabled">
                                                                Punkt nadrzędny
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
                                                            <button type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-arrow-left"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            <!-- Koniec modala zarządzającego kolumnami -->
                                        </div>
                                        <div>
                                            <a style="margin-right: 5px;" type="button" title="Edytuj nagłówek" class="btn btn-primary" href="{{ route('globalChecklists.edit' ,$checklist->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--div kończący buttony-->
                    </div>
                </div>
            </div>

        <br>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table id="global_points_table" class="card-table table">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 1%">Punkt</th>
                                <th class="col-sm-6">Nazwa</th>
                                <th class="overriding_point_class col-sm-2" style="display: none">Punkt nadrzędny</th>
                                <th class="created_at_class col-sm-2" style="display: none">Data utworzenia</th>
                                <th class="updated_at_class col-sm-2" style="display: none">Data edycji</th>
                                <th class="col-sm-1" style="text-align: center">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($globalPoint as $point)
                                @if (!isset($point->subIndex))
                                    <tr class="font-weight-bold">
                                @else
                                    <tr class="font-weight-light">
                                @endif
                                    <td style="width: 1%">{{ $point->index }}.{{ $point->subIndex }}</td>
                                    {{-- Przesunięcie podpunktów --}}
                                    @if (!isset($point->subIndex))
                                        <td class="col-sm-6">{{ $point->description }}</td>
                                    @else
                                        <td class="col-sm-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $point->description }}</td>
                                    @endif
                                    @if ($point->master_point != null)
                                        <td class="overriding_point_class col-sm-2" style="display: none">{{ $point->master_point->description }}</td>
                                    @else
                                        <td class="overriding_point_class col-sm-2" style="display: none">{{ $point->master_point }}</td>
                                    @endif
                                    <td class="created_at_class col-sm-2" style="display: none">{{ $point->created_at}}</td>
                                    <td class="updated_at_class col-sm-2" style="display: none">{{ $point->updated_at}}</td>
                                    <td style="text-align: center" width="100" class="align-middle">
                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                            <a type="button" style="margin-right: 5px;" class="btn btn-primary" href="{{ route('globalpoints.edit' ,[$point->id, $checklistId]) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ route('globalpoints.destroy' ,$point->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button style="margin-right: 5px;" class="btn btn-danger" title="Usuń"
                                                    type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @if($point->subIndex != null)

                                            @else
                                            <div class="dropdown">
                                                <button style="margin-right: 5px;" title="Pozostałe opcje" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-bars"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" title="Przenieś wyżej" href="{{ route('globalpoints.moveup' ,[$point->id, $checklistId]) }}">Przenieś wyżej</a>
                                                    <a class="dropdown-item" title="Przenieś niżej" href="{{ route('globalpoints.movedown' ,[$point->id, $checklistId]) }}">Przenieś niżej</a>
                                                    <a class="dropdown-item" title="Dodaj punkt powyżej" href="{{ route('globalpoints.createuper' ,[$point->index, $checklistId]) }}">Dodaj powyżej</a>
                                                    <a class="dropdown-item" title="Dodaj podpunkt" href="{{ route('globalpoints.createsubsection' ,[$point->index, $checklistId]) }}">Dodaj podpunkt</a>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-scripts')

    <script src="{{ asset('js/external/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/external/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#global_points_table').DataTable({
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
        function showOverridingPoint() {
        var checkBox_overridint_point = document.getElementById("overriding_point_checkbox");
        var overridingPoint = Array.from(document.getElementsByClassName("overriding_point_class"));
            overridingPoint.forEach(element => {
            if (checkBox_overridint_point.checked == true) {
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
