<!DOCTYPE html>
<html>

@inject('carbon', 'Carbon\Carbon')

<head>

    <title>Detail Gaji | {{ Str::ucfirst($employee->call_name) }}</title>

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
        <h1>Detail Gaji {{ Str::ucfirst($employee->users->name) }} ({{ $tanggal_terlama }} &nbsp; - &nbsp; {{ $tanggal_terbaru }})</h1>
    @else
    <h1>Detail Gaji {{ Str::ucfirst($employee->users->name) }} ({{ $from }} &nbsp; - &nbsp; {{ $to }})</h1>
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
                $total = 0;
                $ot_salary = 0;
                $minggu = 0;
                $jumlah_minggu = 0;
            @endphp
           @foreach ($presences as $absen)
           @php
               if ($absen['day'] === "Sun") {
                $minggu += ($employee->daily_salary / 25) * 2;
               }
           @endphp
               <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absen['date'] }}</td>
                    <td>{{ $absen['area'] }}</td>
                    <td>{{ $absen['overtime'] }}</td>
                    <td>
                        @if ($absen['day'] === "Sun")
                            @currency($absen['total_salary'] + $minggu)
                        @else 
                            @currency($absen['total_salary'])
                        @endif
                    </td>
               </tr>
               @php
                   $total += $absen['total_salary'];
                   $ot_salary += $absen['ot_salary'];
               @endphp
           @endforeach
        </tbody>
        <tfoot>
            @if ($employee->salary_method === "Bulanan")    
            <tr>
                <td colspan="3" text-align="center"></td>
                <td class="table-primary" style="text-align: center">Gaji Pokok</td>
                <td class="table-primary" style="text-align: center">@currency($employee->daily_salary)</td>
            </tr>
            <tr>
                <td colspan="3" text-align="center"></td>
                <td class="table-primary" style="text-align: center">Total Lemburan : </td>
                <td class="table-primary" style="text-align: center">@currency($ot_salary)</td>
            </tr>
            <tr>
                <td colspan="3" text-align="center"></td>
                <td class="table-primary" style="text-align: center">Total Allowance : </td>
                <td class="table-primary" style="text-align: center">@currency($total_traveling)</td>
            </tr>
            <tr>
                <td colspan="3" text-align="center"></td>
                <td class="table-primary" style="text-align: center">Minggu : {{ $total_minggu }}x</td>
                <td class="table-primary" style="text-align: center">@currency(($employee->daily_salary / 25) * 2 * $total_minggu)</td>
            </tr>
            <tr>
                <td colspan="3" text-align="center"></td>
                <td class="table-primary" style="text-align: center">Total: </td>
                <td class="table-primary" style="text-align: center">@currency($employee->daily_salary + $ot_salary + $total_traveling + ($employee->daily_salary / 25) * 2 * $total_minggu)</td>
            </tr>
            @else
                <tr>
                    <td colspan="3" text-align="center"></td>
                    <td class="table-primary" style="text-align: center">Total: </td>
                    <td class="table-primary" style="text-align: center">@currency($total)</td>
                </tr>
            @endif
        </tfoot>
    </table>

</body>

</html>
