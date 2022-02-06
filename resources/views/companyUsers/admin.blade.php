@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-user-friends"></i>
                Zarządzaj użytkownikami
            </h1>
        </div>
    </div>
</div>
<hr><br>
    <div class="container-fluid">
        <div class="row ms-3">
            <div>
                <button style="margin-right: 5px;" type="button" title="Zaproś użytkownika" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_user" >
                    <i class="far fa-plus-square"></i>
                </button>
                <!-- Początek modala dodawania listy -->
                    <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Dodaj nowego użytkownika</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <!-- Początek body modala -->
                            <form action="{{ route('companyUsers.add') }}">
                                <label for="email" class="col-12">
                                    Adres e-mail
                                    <input type="email" class="form-control" name="email" value="" tabindex="1"/>
                                </label>
                            <!-- Koniec body modala -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" title="Zamknij" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <button type="submit" title="Zaproś" class="btn btn-primary">
                                    <i class="far fa-plus-square"></i>
                                </button>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                <!-- Koniec modala dodającego listę -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="company_users_table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th class="col-sm-8">Użytkownik</th>
                            <th class="col-sm-2">Uprawnienie</th>
                            <th class="col-sm-1" style="text-align: center">Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        {{-- If zaznaczający na czerwono uzytkowników zablokowanych --}}
                        @if (!isset($user->deleted_at))
                            <tr>
                        @else
                            <tr class="table-danger">
                        @endif
                        {{-- Koniec If zaznaczającego na czerwono użytkowników zablokowanych --}}
                                <td class="col-sm-8">{{ $user->email }}</td>
                                <td class="col-sm-2">{{ $user->name }}</td>
                                <td style="text-align: center" width="5%" class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    {{-- If określający akcje dostępne dla kategorii (inne dla aktywnych) --}}
                                        @if (!isset($user->deleted_at))
                                            <a type="button" style="margin-right: 5px;" title="Wyświetl" class="btn btn-secondary" href="{{ route('companyUsers.show' ,$user->id) }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <br>
                                            <a type="button" style="margin-right: 5px;" title="Zmień uprawnienia" class="btn btn-primary" href="{{ route('companyUsers.edit' ,$user->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <br>
                                            <form action="{{ route('companyUsers.destroy' ,$user->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Dezaktywuj" style="margin-right: 5px;" class="btn btn-danger"
                                                    type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @else
                                        {{-- Akcje dla dezaktywowanej kategorii --}}
                                            <a type="button" title="Wyświetl" style="margin-right: 5px;" class="btn btn-secondary" href="{{ route('companyUsers.show' ,$user->id) }}">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <br>
                                            <a type="button" title="Przywróć" style="margin-right: 5px;" class="btn btn-success" href="{{ route('companyUsers.restore' ,$user->id) }}">
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
            $('#company_users_table').DataTable({
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


@endsection
