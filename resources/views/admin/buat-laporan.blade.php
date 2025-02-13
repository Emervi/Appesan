<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan Transaksi Keuangan</h1>
    <h4>Tanggal {{ $displayStartDate }} hingga {{ $displayEndDate }}.</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kasir</th>
                <th>Tanggal</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>Jon</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') }}</td>
                    <td>Rp {{ number_format($transaction->total_pendapatan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Total Pendapatan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>