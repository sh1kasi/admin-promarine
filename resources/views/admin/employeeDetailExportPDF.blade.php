<!DOCTYPE html>
<html>

<head>
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

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        h1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22px;
        }

    </style>
</head>

<body>

    @if ($from == null && $to == null)
        <h1>Detail Komisi {{ Str::ucfirst($employee->users->name) }} ({{ $tanggal_terlama }} &nbsp; - &nbsp; {{ $tanggal_terbaru }})</h1>
    @else
    <h1>Detail Komisi {{ Str::ucfirst($employee->users->name) }} ({{ $from }} &nbsp; - &nbsp; {{ $to }})</h1>
    @endif
    <table id="customers">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Area</th>
                <th>Lemburan</th>
                <th>Total Bayaran Perhari</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0
            @endphp
           @foreach ($presences as $absen)
               <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absen['date'] }}</td>
                    <td>{{ $absen['area'] }}</td>
                    <td>{{ $absen['overtime'] }}</td>
                    <td>@currency($absen['total_salary'])</td>
               </tr>
               @php
                   $total += $absen['total_salary']
               @endphp
           @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" text-align="center"></td>
                <td class="table-primary" style="text-align: center">Total : </td>
                <td class="table-primary" style="text-align: center">@currency($total)</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
