<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.5;
        }

        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #111;
        }

        .branch-info {
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 12px;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9fafb;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">LAPORAN PENJUALAN BULANAN</div>
        <div class="branch-info">
            <strong>Cabang:</strong> {{ $branch->name }}<br>
            <strong>Periode:</strong> {{ $month }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Invoice</th>
                <th>Kasir</th>
                <th class="text-right">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
                <tr>
                    <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                    <td>{{ $trx->invoice_number }}</td>
                    <td>{{ $trx->user->name }}</td>
                    <td class="text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right">Grand Total:</td>
                <td class="text-right">Rp {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>