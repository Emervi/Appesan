{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembayaran</title>
    <style>
        * {
            margin: 0%;
            padding: 0%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body {
            text-align: center;
            font-family: sans-serif;
            margin: 5%
        }

        .menuList {
            border-bottom: 1px solid black;
            background-color: red;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .orderData {
            background-color: purple;

        }

        .subTotal {
            background-color: green;
        }
    </style>
</head>

<body>

    <p>Terima Kasih Sudah Memesan Menu Menggunakan Aplikasi</p>
    <h2 style="text-align: center">Appesan</h2>
    <span>=============================</span>
    @foreach ($orders as $order)
        <div class="menuList">
            <div class="orderData">
                <span>{{ $order->name }}</span>
                <span>{{ $order->quantity }} x {{ $order->price }}</span>
            </div>
            <span class="subTotal">{{ $order->sub_total }}</span>
        </div>
    @endforeach

</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembayaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            text-align: center;
            font-family: sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        .menuList {
            border-bottom: 1px solid black;
            padding: 10px 0;
            text-align: left;
        }

        .nominals {
            text-align: left;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div>
        <header>
            <p>Terima Kasih Sudah Memesan Menu Menggunakan Aplikasi</p>
            <h2>Appesan</h2>
        </header>
        <span>---------------------------------------------------</span>
        <div style="text-align: left">
            <span>Kasir: {{ $cashier_name }}</span>
            <br>
            <span>{{ $printDate }}</span>
        </div>
        <span>---------------------------------------------------</span>

        @foreach ($orders as $order)
            <div class="menuList">
                <span>{{ $order->name }}</span>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $order->quantity }} x {{ number_format($order->price, 0, ',', '.') }}</span>
                    <span style="float: right">Rp {{ number_format($order->sub_total, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        {{-- <span>=============================</span> --}}
        <span>---------------------------------------------------</span>
        <footer class="nominals">
            <p>Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
            <p>Uang Pembayaran: <br>
                Rp {{ number_format($payment, 0, ',', '.') }}
            </p>
            <p>Kembalian: Rp {{ number_format($change, 0, ',', '.') }}</p>
        </footer>
    </div>

</body>

</html>
