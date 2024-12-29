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
    <h4>Tanggal 20-12-2024 hingga 21-12-2024.</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>Rp {{ number_format($transaction->income, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            {{-- <tr>
                <td>1</td>
                <td>20-12-2024</td>
                <td>Rp. 520.000</td>
            </tr>
            <tr>
                <td>2</td>
                <td>20-12-2024</td>
                <td>Rp. 480.000</td>
            </tr>
            <tr>
                <td>3</td>
                <td>20-12-2024</td>
                <td>Rp. 500.000</td>
            </tr>
            <tr>
                <td>4</td>
                <td>21-12-2024</td>
                <td>Rp. 270.000</td>
            </tr>
            <tr>
                <td>5</td>
                <td>21-12-2024</td>
                <td>Rp. 230.000</td>
            </tr> --}}
            <tr>
                <td colspan="3">Total Pendapatan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
            {{-- @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $tanggalPendapatan[$index] }}</td>
                    <td> Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $item->metode_pembayaran }}</td>
                </tr>
            @endforeach --}}
            {{-- <tr>
                <td colspan="6">Total Pendapatan: Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr> --}}
        </tbody>
    </table>
</body>

</html>