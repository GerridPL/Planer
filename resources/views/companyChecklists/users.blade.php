@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-eye"></i>
                Seryjne przypisywanie listy
            </h1>
        </div>
    </div>
</div>
<hr><br>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-5 text-center">

            </h1>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group" role="group">
                <div>
                    <a style="margin-right: 19px;" href="{{ route('companyChecklists.index') }}" type="button" class="btn btn-secondary float-left" tabindex="1">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="term" class="col-12 mt-3 mb-1">
                    Termin
                </label>
                <input type="date" class="form-control" name="term" id="term" tabindex="2" value="{{ date('Y-m-d') }}"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="checklist-name" class="col-12 mt-2">
                    Nazwa szablonu
                </label>
                <input type="text" class="form-control" name="checklist-name" id="name" tabindex="2" value="{{$thisList->name}}" disabled/>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <!-- Tabela z użytkownikami bez list kontronych -->
        <div class="col-md-4">
            <table id="company_users_without_checklist_table" class="table">
                <thead  class="table-primary">
                    <h3>Użytkownicy</h3>
                    <tr>
                        <th class="col-sm-10">Użytkownik</th>
                        <th class="col-sm-1" style="text-align: center">Przypisz</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <input id="user{{$loop->iteration}}" value="{{ $user->id }}" hidden>
                            <input id="thisList{{$loop->iteration}}" value="{{ $thisList->id }}" hidden>
                            <td class="col-sm-10">{{ $user->email }}</td>
                            <td class="col-sm-1">
                                <button title="Przypisz" id="{{$loop->iteration}}" type="button" class="btn btn-success">
                                    <i class="far fa-plus-square"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabela z użytkownikami bez list kontronych -->
        <div class="col-md-8">
            <table id="company_users_with_checklist_table" class="table">
                <thead  class="table-primary">
                    <h3>Przypisane listy</h3>
                    <tr>
                        <th class="col-sm-3">Użytkownik</th>
                        <th class="col-sm-4">Nazwa</th>
                        <th class="col-sm-2">Termin</th>
                        <th class="col-sm-2" style="text-align: center">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checklists as $checklist)
                        <tr>
                            <td class="col-sm-3">{{ $checklist->user_relation->email }}</td>
                            <td class="col-sm-4">{{ $checklist->name }}</td>
                            <td class="col-sm-2">{{ $checklist->term }}</td>
                            <td style="text-align: center" width="100" class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <a type="button" style="margin-right: 5px;" title="Edytuj" class="btn btn-primary" href="{{ route('companyChecklists.edit' ,$checklist->id) }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <br>
                                    <form action="{{ route('companyChecklists.destroy' ,[$checklist->id]) }}"
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
    $(document).ready(function() {
        $('#company_users_without_checklist_table').DataTable({
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

<script>

    $(".btn-success").click(function(e){

        e.preventDefault();

        var term = $("input[name=term]").val();
        var user = $("#user"+this.id).val();
        var list = $("#thisList"+this.id).val();
        console.log(term);
        console.log(user);
        console.log(list);
        $.ajax({
           type:'GET',
           url:"{{ url('companyChecklists') }}"+"/"+user+"/"+list+"/"+term+"/assign",
           success:function(data){
               location.reload(true);
           }
        });

    });
</script>
@endsection
