@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1>
                    Lista: "{{ $userChecklist->name }}"
                </h1>
                <div>
                    <a style="margin-right: 19px;" href="{{ route('mychecklists.index') }}" type="button" class="btn btn-secondary float-left" tabindex="1">
                        Cofnij
                    </a>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <table id="my_points_table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th>Punkt</th>
                            <th>Nazwa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userPoints as $point)
                            {{-- If od tr warunkujące całe wiersze--}}
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
                            {{-- Koniec if od tr warunkującego całe wiersze --}}

                                <td class="col-sm-1">{{ $point->index }}.{{ $point->subIndex }}</td>

                                {{-- If od kolumny opis --}}
                                @if (!isset($point->subIndex))
                                    <td>{{ $point->description }}</td>
                                @else
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $point->description }}</td>
                                @endif


                                @if ($point->confirmed == 0)
                                    <td>Nie zrealizowano</td>
                                @else
                                    <td>Zrealizowano</td>
                                @endif
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
            $('#my_points_table').DataTable({
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
