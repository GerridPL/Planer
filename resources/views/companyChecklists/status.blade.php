@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-eye"></i>
                Realizacja listy
            </h1>
        </div>
    </div>
</div>
<hr><br>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group" role="group">
                <div>
                    <a style="margin-right: 5px;" title="Cofnij" href="{{ route('companyChecklists.index') }}" type="button" class="btn btn-secondary float-left" tabindex="1">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div>
                    <button type="button" title="Filtruj" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category_columns" >
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
                                    <form method="post" action="{{ route('companyChecklists.filtr', $thisList->id) }}">
                                    @method('POST')
                                    @csrf
                                        <label for="user">
                                            Użytkownik
                                        </label>
                                        <select class="form-control form-select" name="user" tabindex="2">
                                            <option value="0"></option>
                                            @foreach ($allUsersWithChecklist as $user)
                                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                                            @endforeach
                                        </select>
                                        <label for="status">
                                            Status
                                        </label>
                                        <select class="form-control form-select" name="status" tabindex="2">
                                            <option value="3"></option>
                                            <option value="0">Nie zamknięto</option>
                                            <option value="1">Zamknięto</option>
                                        </select>
                                            <!-- Koniec body modala -->
                                    </div>
                                        <div class="modal-footer">
                                            <button type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-arrow-left"></i>
                                            </button>
                                            <button type="submit" title="Zastosuj" class="btn btn-primary">
                                                <i class="far fa-save"></i>
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
    </div>
    <br>
    <div class="row">
        <!-- Tabela z użytkownikami bez list kontronych -->
        <div class="col-md-12">
            <h4>Realizacja listy: {{ $thisList->name }}</h4>
            <table id="company_users_with_checklist_table" class="table">
                <thead  class="table-primary">
                    <tr>
                        <th>Użytkownik</th>
                        <th>Realizacja</th>
                        <th>Status</th>
                        <th>Termin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersWithChecklist as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach ($allLists as $list)
                            <tr>
                                @if($list->user === $user->id)
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $list->name }}</td>
                                    <td>{{ $list->realization }}%</td>
                                    @if($list->status == 0)
                                        <td>Nie zamknięto</td>
                                    @else
                                        <td>Zamknięto</td>
                                    @endif
                                    @if($list->term == null)
                                        <td>Nie podano</td>
                                    @else
                                        <td>{{ $list->term }}</td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
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
    $(document).ready(function() {
        $('#company_users_with_checklist_table').DataTable({
            "bPaginate": false
            , "bLengthChange": false
            , "bFilter": true
            , "bInfo": false
            , "bAutoWidth": false
            , language: {
                url: '{{ asset('
                language / Polish.json ') }}'
            }
        });
    });

</script>
@endsection
