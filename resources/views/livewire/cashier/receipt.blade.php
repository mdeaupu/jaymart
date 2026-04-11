<!DOCTYPE html>
<html>
<head>
    <title>Struk Jaymart</title>
</head>

<body onload="window.print()" style="font-family: monospace; width: 300px; font-size:12px;">

    <!-- HEADER -->
    <div style="text-align:center;">
        <strong style="font-size:16px;">JAYMART</strong><br>
        Minimarket Modern<br>
        ------------------------------
    </div>

    <!-- INFO TRANSAKSI -->
    <div style="margin-top:5px;">
        No: {{ $transaction->invoice_number }}<br>
        Tgl: {{ $transaction->created_at->format('d-m-Y H:i') }}<br>
        Kasir: {{ $transaction->user->name ?? '-' }}
    </div>

    <hr>

    <!-- LIST PRODUK -->
    @foreach($transaction->details as $item)
        <div>
            {{ $item->product->name }}
        </div>

        <div style="display:flex; justify-content:space-between;">
            <span>
                {{ $item->qty }} x {{ number_format($item->price_at_transaction,0,',','.') }}
            </span>
            <span>
                {{ number_format($item->qty * $item->price_at_transaction,0,',','.') }}
            </span>
        </div>
    @endforeach

    <hr>

    <!-- TOTAL -->
    <div style="display:flex; justify-content:space-between;">
        <strong>Total</strong>
        <strong>Rp {{ number_format($transaction->total_price,0,',','.') }}</strong>
    </div>

    <!-- OPSIONAL (kalau nanti kamu tambah fitur bayar) -->
    @if(isset($transaction->paid_amount))
        <div style="display:flex; justify-content:space-between;">
            Bayar
            <span>Rp {{ number_format($transaction->paid_amount,0,',','.') }}</span>
        </div>

        <div style="display:flex; justify-content:space-between;">
            Kembali
            <span>Rp {{ number_format($transaction->change_amount,0,',','.') }}</span>
        </div>
    @endif

    <hr>

    <!-- FOOTER -->
    <div style="text-align:center; margin-top:5px;">
        Terima Kasih<br>
        Selamat Berbelanja Kembali
    </div>

</body>
</html>