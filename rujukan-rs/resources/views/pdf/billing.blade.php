<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f5f5f5; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="title">NOTA PEMBAYARAN</div>
    <div>No Rawat: {{ $billing->visit->no_rawat }}</div>
    <div>Pasien: {{ $billing->visit->patient->name }}</div>
    <div>Tanggal: {{ optional($billing->closed_at)->format('d-m-Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Tipe</th>
                <th class="right">Harga</th>
                <th class="right">Qty</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billing->items as $it)
                <tr>
                    <td>{{ $it->name }}</td>
                    <td>{{ $it->type }}</td>
                    <td class="right">Rp {{ number_format($it->price, 0, ',', '.') }}</td>
                    <td class="right">{{ $it->qty }}</td>
                    <td class="right">Rp {{ number_format($it->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: 12px;">
        <tr>
            <td class="right" style="border: none;">Subtotal</td>
            <td class="right" style="border: none; width: 150px;">Rp {{ number_format($billing->subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="right" style="border: none;">Diskon</td>
            <td class="right" style="border: none;">Rp {{ number_format($billing->discount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="right" style="border: none; font-weight:bold;">TOTAL</td>
            <td class="right" style="border: none; font-weight:bold;">Rp {{ number_format($billing->total, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>