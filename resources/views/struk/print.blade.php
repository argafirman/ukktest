<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: "Courier New", monospace;
            padding: 20px;
            font-size: 14px;
            text-align: center;
        }
        .container {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            border: 1px dashed #000;
            padding: 15px;
        }
        h3, h4 {
            margin: 5px 0;
        }
        hr {
            border: 1px dashed #000;
        }
        table {
            width: 100%;
            margin-top: 10px;
            text-align: left;
        }
        th, td {
            padding: 4px 0;
        }
        .footer {
            margin-top: 15px;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="container">
    <h3>Toko Kami Ambatukam</h3>
    <p>Jalan Raya Roti Jala Maklima Biadap</p>
    <p>Telp: (0123) 456-789</p>
    <hr>
    <h4>Struk Transaksi</h4>

    <table>
        <tr><th>ID Transaksi</th><td>: {{ $transaksi->id }}</td></tr>
        <tr><th>Pelanggan</th><td>: {{ $transaksi->pelanggan->NamaPelanggan }}</td></tr>
        <tr><th>Produk</th><td>: {{ $transaksi->produk->NamaProduk }}</td></tr>
        <tr><th>Jumlah</th><td>: {{ $transaksi->jumlah }}</td></tr>
        <tr><th>Total Harga</th><td>: Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td></tr>
        <tr><th>Uang Diberikan</th><td>: Rp{{ number_format($transaksi->uang_diberikan, 0, ',', '.') }}</td></tr>
        <tr><th>Kembalian</th><td>: Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</td></tr>
        <tr><th>Tanggal</th><td>: {{ date('d-m-Y', strtotime($transaksi->tanggal_transaksi)) }}</td></tr>
    </table>

    <hr>
    <div class="footer">
        <p>Terima Kasih Telah Berbelanja!</p>
        <p>Silakan datang kembali.</p>
    </div>
</div>

</body>
</html>
