<!DOCTYPE html>
<html>

<head>

    <title>REKAP KASBON - {{ Str::ucfirst($employee->users->name) }}</title>

    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        /* #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        } */

        #customers #isian th:nth-child(even) {
            background-color: #f2f2f2;
        }
        #judul {
            background-color: #04aa6d   ;
        }

        h1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22px;
        }

    </style>
</head>

<body>
    <table id="customers">
        <tr>
            <th id="judul" colspan="3" style="text-align: center;">REKAP KASBON ({{ Str::ucfirst($employee->users->name) }})</th>
        </tr>
        <tr style="text-align: center;">
            <th id="judul">Tanggal Kasbon</th>
            <th id="isian" colspan="2">{{ $kasbon->date }}</th>
        </tr>
        <tr style="text-align: center;">
            <th id="judul">Jumlah</th>
            <th id="isian" colspan="2">@currency($kasbon->nominal)</th>
        </tr>
        <tr style="text-align: center;">
            <th id="judul" colspan="1">Job</th>
            <th id="isian" colspan="2"><b>{{ $kasbon->job }}</b></th>
        </tr>
        <tr style="text-align: center;">
            <th id="judul">Tanggal</th>
            <th id="judul">Item/barang</th>
            <th id="judul">nominal</th>
        </tr>
        @foreach ($kasbon_detail as $data)    
        <tr style="text-align: center">
            <td>{{ $data->date }}</td>
            <td>{{ $data->item }}</td>
            <td>@currency($data->nominal)</td>
        </tr>
        @endforeach
    </table>

</body>

</html>