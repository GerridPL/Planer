@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-eye"></i>
                Listy kontrolne
            </h1>
        </div>
    </div>
</div>
<hr><br>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group ms-4" role="group">
                <div>
                    <button type="button" title="Wybierz kolumny" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checklist_columns">
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
                                        <input class="form-check-input" type="checkbox" value="" onclick="showCategory()" id="category_checkbox" checked>
                                        <label class="form-check-label" for="flexCheckCheckedDisabled">
                                            Kategoria
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" onclick="showAuthor()" id="author_checkbox" checked>
                                        <label class="form-check-label" for="flexCheckCheckedDisabled">
                                            Autor
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table id="company_checklists_table" class="table">
                <thead class="table-primary">
                    <tr>
                        <th class="col-sm-5">Nazwa</th>
                        <th class="category_class col-sm-2">Kategoria</th>
                        <th class="author_class col-sm-2">Autor</th>
                        <th class="created_at_class col-sm-2" style="display: none">Data utworzenia</th>
                        <th class="updated_at_class col-sm-2" style="display: none">Data edycji</th>
                        <th style="width: 4%">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($globalChecklists as $checklist)
                    <tr>
                        <td class="col-sm-5">{{ $checklist->name }}</td>
                        <td class="category_class col-sm-2">{{ $checklist->category->name}}</td>
                        <td class="author_class col-sm-2">{{ $checklist->user->email}}</td>
                        <td class="created_at_class col-sm-2" style="display: none">{{ $checklist->created_at}}</td>
                        <td class="updated_at_class col-sm-2" style="display: none">{{ $checklist->updated_at}}</td>
                        <td style="text-align: center" width="100" class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                <a type="button" style="margin-right: 5px;" title="Realizacja listy" class="btn btn-secondary" href="{{ route('companyChecklists.status' ,$checklist->id) }}">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a type="button" style="margin-right: 5px;" title="Zarządzaj" class="btn btn-primary" href="{{ route('companyChecklists.users' ,$checklist->id) }}">
                                    <i class="far fa-edit"></i>
                                </a>
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
            $('#company_checklists_table').DataTable({
                "bPaginate": false,
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
    function showAuthor() {
        var checkBox_author = document.getElementById("author_checkbox");
        var author = Array.from(document.getElementsByClassName("author_class"));
        author.forEach(element => {
            if (checkBox_author.checked == true) {
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
