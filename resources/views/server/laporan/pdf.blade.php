<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket - {{ $data->kode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .card-body {
            padding: 10px;
            margin-bottom: 10px;
        }
        .text-center {
            text-align: center;
        }
        .font-weight-bold {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="card-body">
        <div class="font-weight-bold h4 text-center">{{ $data->rute->tujuan }}</div>
        <div style="text-align: center; margin: 10px 0;">
            <span style="font-weight: bold;">{{ $data->rute->start }}</span>
            <span style="margin: 0 10px;">-----</span>
            <span style="font-weight: bold;">{{ $data->rute->end }}</span>
        </div>
    </div>

    <div class="card-body">
        <p>Kode Booking</p>
        <h3 class="font-weight-bold">{{ $data->kode }}</h3>
        <p>Jadwal Berangkat</p>
        <h5 class="font-weight-bold text-center">
            {{ date('l, d F Y', strtotime($data->waktu)) }}<br>
            {{ date('H:i', strtotime($data->waktu)) }} WIB
        </h5>
    </div>

    <div class="card-body">
        <table>
            <tr>
                <td>Nama Transportasi</td>
                <td class="text-right">{{ $data->rute->transportasi->name }} ({{ $data->rute->transportasi->kode }})</td>
            </tr>
            <tr>
                <td>Nama Penumpang</td>
                <td class="text-right">{{ $data->penumpang->name }}</td>
            </tr>
            <tr>
                <td>Kode Kursi</td>
                <td class="text-right">{{ $data->kursi }}</td>
            </tr>
            <tr>
                <td>Harga</td>
                <td class="text-right">Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Status Pembayaran</td>
                <td class="text-right">{{ $data->status }}</td>
            </tr>
        </table>
    </div>
</body>
</html>