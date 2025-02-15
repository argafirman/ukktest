<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .struk {
            width: 300px;
            border: 1px solid #000;
            padding: 10px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
        }

        .detail {
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="judul">STRUK TRANSAKSI</div>
        <div class="detail">
            <p><strong>Pelanggan:</strong> {{ $transaksi->pelanggan->NamaPelanggan }}</p>
            <p><strong>Produk:</strong> {{ $transaksi->produk->NamaProduk }}</p>
            <p><strong>Jumlah:</strong> {{ $transaksi->jumlah }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($transaksi->total_harga, 2) }}</p>
            <p><strong>Tanggal:</strong> {{ $transaksi->tanggal_transaksi }}</p>
        </div>
        <div class="footer">Terima kasih atas pembelian Anda!</div>
    </div>
</body>

</html>
