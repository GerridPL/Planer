@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-users-cog"></i>
                Użytkownicy
            </h1>
        </div>
    </div>
</div>
<hr><br>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <table id="company_users_table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th class="col-sm-10">Użytkownik</th>
                            <th class="col-sm-1" style="text-align: center">Listy</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="col-sm-10">{{ $user->email }}</td>
                                <td style="text-align: center" width="100" class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <a type="button" title="Wyświetl listy" class="btn btn-secondary" href="{{ route('userchecklists.index', $user->id) }}" >
                                        <i class="far fa-eye"></i>
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


@endsection
