@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="far fa-calendar-check"></i>
                Realizacja listy
            </h1>
        </div>
    </div>
</div>
<hr><br>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 ms-4">
            <div>
                <a style="margin-right: 5px;" title="Cofnij" href="{{ route('mychecklists.index') }}" type="button" class="btn btn-secondary float-left" tabindex="1">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <h5 style="margin-left: 1%">Realizacja listy: {{ $userChecklist->name }}</h5>
            @if ($userChecklist->description != null)
            <h5 style="margin-left: 1%">Opis listy: {{ $userChecklist->description }}</h5>
            @endif
            <table id="my_points_table" class="table">
                <thead class="table-primary">
                    <tr>
                        <th class="col-sm-1">Punkt</th>
                        <th class="col-sm-7">Nazwa</th>
                        <th class="col-sm-2">Realizacja</th>
                        <th class="col-sm-2">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userPoints as $point)
                        @if (!isset($point->subIndex))
                            @if($point->skiped == 1)
                                <tr class="font-weight-bold table-warning">
                            @else
                                <tr class="font-weight-bold">
                            @endif
                        @else
                            @if($point->skiped == 1)
                                <tr class="font-weight-light table-warning">
                            @else
                                <tr class="font-weight-light">
                            @endif
                        @endif

                        <td class="col-sm-1">{{ $point->index }}.{{ $point->subIndex }} </td>

                        {{-- Przesunięcie podpunktów --}}
                        @if (!isset($point->subIndex))
                            <td class="col-sm-7">{{ $point->description }}</td>
                        @else
                            <td class="col-sm-7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $point->description }}</td>
                        @endif

                        {{-- Opisanie poziomu realizacji --}}
                        @if ($point->confirmed == 0)
                            <td class="col-sm-2">Nie zrealizowano</td>
                        @else
                            <td class="col-sm-2">Zrealizowano</td>
                        @endif

                        <td class="col-sm-2">
                            @if ($point->active == 1)
                                <a type="button" title="Pomiń" class="btn btn-secondary" href="{{ route('mychecklists.skip',[$point->id,$userChecklist->id]) }}">
                                    <i class="fas fa-forward"></i>
                                </a>
                                <a type="button" title="Realizuj" class="btn btn-success" href="{{ route('mychecklists.realize',[$point->id,$userChecklist->id]) }}">
                                    <i class="fas fa-check-square"></i>
                                </a>
                            @else
                                @if($point->skiped == 1)
                                    <a type="button" title="Realizuj pominięty" class="btn btn-info" href="{{ route('mychecklists.realizeskiped',[$point->id,$userChecklist->id]) }}">
                                        <i class="fas fa-check-square"></i>
                                    </a>
                                @elseif ($point->skiped == 0 && $point->confirmed == 1)
                                <a type="button" title="Cofnij realizowany" class="btn btn-secondary" href="{{ route('mychecklists.undo',[$point->id,$userChecklist->id]) }}">
                                    <i class="fas fa-undo-alt"></i>
                                </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="row ms-3">
        <div class="col-sm-12">
            {{-- Wyświetlenie przycisku "Zamknij listę" w kolorze czerwonym gdy wcale nie zrealizowana, żółtym gdy po części zrealizowana oraz zielonym gdy w 100% zrealizowana --}}
            @if($userChecklist->realization == 100)
                <button type="button" style="margin-right: 5px;" title="Zamknięcie zrealizowanej listy" class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#close_checklist_action-{{ $userChecklist->id }}">
                    <i class="fas fa-check-square"></i>
                </button>
            @elseif($userChecklist->realization == 0)
                <button type="button" style="margin-right: 5px;" title="Zamknięcie nierozpoczętej listy!" class="btn btn-danger float-right" data-bs-toggle="modal" data-bs-target="#close_checklist_action-{{ $userChecklist->id }}">
                    <i class="fas fa-exclamation"></i>
                </button>
            @else
                <button type="button" style="margin-right: 5px;" title="Zamknięcie nieskończonej listy!" class="btn btn-warning float-right" data-bs-toggle="modal" data-bs-target="#close_checklist_action-{{ $userChecklist->id }}">
                    <i class="fas fa-exclamation-triangle"></i>
                </button>
            @endif
        </div>
    </div>
    <!-- Okno modalne Zamknięcia checklisty -->
    <div class="modal fade" id="close_checklist_action-{{ $userChecklist->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Zamknięcie zrealizowanej listy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="close-list-form" method="post" action="{{ route('mychecklists.close', $userChecklist->id) }}">
                    <div class="modal-body center-block">
                        @csrf
                        <label for="userComment">Komentarz zostanie zapisany na liście. Maksymalna długość komentarza to 500 znaków.</label>
                        <textarea class="form-control" name="userComment" data-validation="custom" data-validation-regexp="^[a-zA-Z ]{2,30}$" row="3" col="200"></textarea>
                    </div>
                    <div class="modal-footer">
                        {{-- Akcje gdy lista zrealizowana w 100% --}}
                        @if ($userChecklist->realization == 100)

                            <p>Gratuluję, właśnie próbujesz zamknąć listę zrealizowaną w 100%.</p>
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                <button style="margin-right: 5px;" type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <button style="margin-right: 5px;" title="Zamknij listę" type="submit" class="btn btn-success">
                                    <i class="fas fa-check-square"></i>
                                </button>
                            </div>
                        @elseif($userChecklist->realization == 0)
                            <p>UWAGA! Nie rozpocząłeś realizacji listy kontrolnej! Jesteś pewien że chcesz ją zamknąć?</p>
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                <button style="margin-right: 5px;" type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <button style="margin-right: 5px;" type="submit" title="Zamknij listę" class="btn btn-danger">
                                    <i class="fas fa-check-square"></i>
                                </button>
                            </div>
                        @else
                        {{-- Akcje gdy lista nie jest zrealizowana w 100% --}}
                            <p>UWAGA! Nie zrealizowałeś w 100% listy kontrolnej! Jesteś pewien że chcesz ją zamknąć?</p>
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                <button style="margin-right: 5px;" type="button" title="Cofnij" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <button style="margin-right: 5px;" title="Zamknij listę" type="submit" class="btn btn-warning">
                                    <i class="fas fa-check-square"></i>
                                </button>
                            </div>
                        @endif
                </form>
            </div>
        </div>
    </div>
    <!--Koniec okna modalnego -->
</div>
@endsection

@section('js-scripts')

<script src="{{ asset('js/external/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/external/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#my_points_table').DataTable({
                "order": [[0, "asc"]],
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                "orderFixed": [ 0, 'asc' ],
                "searching": false,
                language: {
                    url: '{{ asset('language/Polish.json') }}'
                }
            });
        });
    </script>

@endsection
