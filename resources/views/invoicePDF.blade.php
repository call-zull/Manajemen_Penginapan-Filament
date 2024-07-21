<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Penginapan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 2px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo img {
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <img src="{{ public_path('images/logo_penginapan.jpg') }}" alt="Logo Penginapan">
            </div>
            <div class="header-text">
                <h1>Invoice Penginapan</h1>
                <h2>Tanggal Cetak: {{ $date }}</h2>
                <h3>Nomor Invoice: {{ $invoice->invoice_number }}</h3>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Customer</th>
                    <th>Tanggal Check-In</th>
                    <th>Tanggal Check-Out</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->name_customer }}</td>
                    <td>{{ $invoice->check_in }}</td>
                    <td>{{ $invoice->check_out }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>No Kamar</th>
                    <th>Harga Kamar</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->room->No_Kamar }}</td>
                    <td>Rp. {{ number_format($invoice->room->Harga, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($invoice->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tambahkan bagian untuk tanda tangan -->
    <div style="margin-top: 50px;">
        <table>
            <tr>
                <td style="width: 50%; border-bottom: 1px solid #000; padding: 10px;">
                    <p style="text-align: center;">Tamu</p>
                    <br>
                    <br>
                    <p style="text-align: center;"></p>
                </td>
                <td style="width: 50%; border-bottom: 1px solid #000; padding: 10px;">
                    <p style="text-align: center;">Admin</p>
                    <br>
                    <br>
                    <p style="text-align: center;"></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
