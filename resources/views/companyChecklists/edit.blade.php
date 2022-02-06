@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-eye"></i>
                Edytuj listę
            </h1>
        </div>
    </div>
</div>
<hr><br>


<div class="container-fluid">
    <div class='row'>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row justify-content ms-1">
                <div class="col-sm-12 col-md-8 col-lg-6 col-xl-5">
                    <h5 style="margin-left: 2%">Lista użytkownika: {{ $companyUser->email  }}</h5>
                    <form id="edit-checklists-form" method="post" action="{{ route('companyChecklists.save', $checklist->id) }}">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-sm-12 p-3">
                                Nazwa listy
                                <input type="text" class="form-control" name="name" value="{{ $checklist->name }}" tabindex="1"/>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="sub_exp_date" class="col-sm-11 p-3">
                                Termin
                                <input type="date" class="form-control" name="term" value="{{ $checklist->term }}" tabindex="2"/>
                            </label>
                        </div>
                        <label for="description" class="col-sm-11 p-3">Opis listy konrtolnej
                            <textarea class="form-control" name="description" data-validation="custom" data-validation-regexp="^[a-zA-Z ]{2,30}$" row="3" col="200" tabindex="2">{{ $checklist->description }}</textarea>
                        </label>
                        <div class="form-check form-switch m-3">
                            @if ($checklist->allowAfterTerm == true)
                                <input class="form-check-input" type="checkbox" name="realizationAfterTerm" id="realizationAfterTerm" checked>
                            @else
                                <input class="form-check-input" type="checkbox" name="realizationAfterTerm" id="realizationAfterTerm">
                            @endif
                            <label class="form-check-label" for="realizationAfterTerm">Realizacja po terminie</label>
                        </div>
                        <div class="m-3">
                            <a href="{{ route('companyChecklists.users', $checklist->global_checklist) }}" title="Cofnij" type="button" class="btn btn-secondary" tabindex="4">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <button type="submit" title="Zapisz" class="btn btn-primary" tabindex="3">
                                <i class="far fa-save"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="user_points_table" class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th>Punkt</th>
                                    <th class="col-9">Nazwa</th>
                                    <th class="col-3">Realizacja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userPoints as $point)
                                    @if (!isset($point->subIndex))
                                        <tr class="font-weight-bold">
                                    @else
                                        <tr class="font-weight-light">
                                    @endif
                                    <td style="width: 5%">{{ $point->index }}.{{ $point->subIndex }}</td>
                                    {{-- Przesunięcie podpunktów --}}
                                    @if (!isset($point->subIndex))
                                        <td>{{ $point->description }}</td>
                                    @else
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $point->description }}</td>
                                    @endif

                                    {{-- Opisanie poziomu realizacji --}}
                                    @if ($point->confirmed == 0)
                                        <td style="width: 10%">Nie zrealizowano</td>
                                    @else
                                        <td style="width: 10%">Zrealizowano</td>
                                    @endif
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
            $('#user_points_table').DataTable({
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
