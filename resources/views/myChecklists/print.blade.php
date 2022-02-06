<!doctype html>
<html lang="pl-PL">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        #points {
            font-family: firefly, DejaVu Sans, sans-serif;
            border-collapse: collapse;
            width: 100%;
            page-break-inside: avoid;
        }

        #points td,
        #points th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #points tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #points tr:hover {
            background-color: #ddd;
        }

        #points th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #3b5998;
            color: white;
        }

        #summary {
            font-family: firefly, DejaVu Sans, sans-serif;
            border-collapse: collapse;
            width: 100%;
            page-break-inside: avoid;
            page-break-after: always;
        }

        #summary td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #summary tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #summary tr:hover {
            background-color: #ddd;
        }

        h2 {
            font-family: firefly, DejaVu Sans, sans-serif;
            color: #555;
            text-align: center;
            text-transform: uppercase;
        }

        h3 {
            font-family: firefly, DejaVu Sans, sans-serif;
            color: #555;
            text-align: left;
            text-transform: uppercase;
        }

        hr {
            border: 0;
            height: 1px;
            background: #333;
            background-image: linear-gradient(to right, #ccc, #333, #ccc);
        }

    </style>
</head>
<body>
    <div>
        <h2>
            Raport realizacji listy kontrolnej
        </h2>
    </div>
    <h3>
        Lista kontrolna: "{{ $userChecklist->name }}"
    </h3>
    <h3>
        Użytkownik: "{{ $userChecklist->user_relation->email }}"
    </h3>

    <div>

        <h2>
            Raport ogólny
        </h2>

        <table id="summary">
            <tr>
                <td style="width: 40%">Firma</td>
                <td style="width: 60%">{{ $userChecklist->company_relation->name }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Użytkownik realizujący</td>
                <td style="width: 60%">{{ $userChecklist->user_relation->email }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Lista kontrolna</td>
                <td style="width: 60%">{{ $userChecklist->name }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Opis</td>
                <td style="width: 60%">{{ $userChecklist->description }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Kategoria</td>
                <td style="width: 60%">{{ $userChecklist->checklist_category_relation->name }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Osoba przydzielająca</td>
                <td style="width: 60%">{{ $userChecklist->allocated_by_relation->email }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Data przydzielenia</td>
                <td style="width: 60%">{{ $userChecklist->created_at }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Data ostatniej modyfikacji</td>
                <td style="width: 60%">{{ $userChecklist->updated_at }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Określony termin realizacji</td>
                <td style="width: 60%">{{ $userChecklist->term }}</td>
            </tr>
            <tr>
                <td style="width: 40%">Możliwość realizacji po terminie</td>
                @if($userChecklist->allowAfterTerm == true)
                    <td style="width: 60%">Tak</td>
                @else
                    <td style="width: 60%">Nie</td>
                @endif
            </tr>
            <tr>
                <td style="width: 40%">Procent realizacji</td>
                <td style="width: 60%">{{ $userChecklist->realization }}%</td>
            </tr>
            <tr>
                <td style="width: 40%">Czy lista zamknięta?</td>
                @if ($userChecklist->status == 0)
                <td style="color: #e25353; width: 60%">Nie</td>
                @else
                <td style="color: #04AA6D; width: 60%">Tak: {{$userChecklist->dateOfRealization}}</td>
                @endif
            </tr>
            <tr>
                <td style="width: 40%">Czy zrealizowana w terminie?</td>
                @if (strtotime($userChecklist->updated_at) > strtotime($userChecklist->term) && $userChecklist->status != 0 && (int)(round(strtotime($userChecklist->updated_at) - (strtotime($userChecklist->term))) / (60 * 60 * 24)) != 0)
                <td style="color: #e25353; width: 60%">Nie: {{(int)(round(strtotime($userChecklist->updated_at) - (strtotime($userChecklist->term))) / (60 * 60 * 24))}} dni po terminie</td>
                @elseif ($userChecklist->status != 0)
                <td style="color: #04AA6D; width: 60%">Tak</td>
                @else
                <td style="color: #04AA6D; width: 60%"></td>
                @endif
            </tr>
            <tr>
                <td style="width: 40%">Komentarz użytkownika</td>
                <td style="width: 60%">{{ $userChecklist->user_comment }}</td>
            </tr>

        </table>
    </div>

    <h2>
        Raport szczegółowy
    </h2>
    <br>
    <table id="points">
        <tr>
            <th style="width: 10%">Punkt</th>
            <th>Nazwa</th>
            <th>Status</th>
        </tr>
        @foreach ($userPoints as $point)

        <tr>

            <td>{{ $point->index }}.{{ $point->subIndex }}</td>

            <td>{{ $point->description }}</td>

            @if ($point->confirmed == 0)
            <td style="color: #e25353">Nie zrealizowano</td>
            @else
            <td style="color: #04AA6D">Zrealizowano {{ $point->updated_at }}</td>
            @endif
        </tr>
        @endforeach
    </table>
    <h3>
        Raport wydrukował: "{{ $user->email }}"
    </h3>
    <h3>
        Data i godzina wydruku: "{{ date("Y-m-d\ H:i:s") }}"
    </h3>
</body>
</html>
