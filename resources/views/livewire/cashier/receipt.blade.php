<!DOCTYPE html>
<html>

<head>
    <title>Struk Jaymart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-mono text-black mx-auto bg-white p-4" style="width: 300px; font-size: 12px; line-height: 1.4;">

    <div class="text-center mb-4">
        <h1 class="text-lg font-black tracking-widest uppercase">JAYMART</h1>
        <p class="text-xs font-bold border-b border-dashed border-black pb-2 mt-1">
            Minimarket Modern
        </p>
    </div>

    <div class="text-xs font-semibold mb-3">
        <div class="flex justify-between">
            <span>No:</span>
            <span>{{ $transaction->invoice_number }}</span>
        </div>
        <div class="flex justify-between">
            <span>Tgl:</span>
            <span>{{ $transaction->created_at->format('d-m-Y H:i') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Kasir:</span>
            <span>{{ $transaction->user->name ?? '-' }}</span>
        </div>
    </div>

    <div class="border-t border-dashed border-black my-2"></div>

    <div class="space-y-2 my-3 font-semibold">
        @foreach($transaction->details as $item)
            <div>
                <div class="block truncate">{{ $item->product->name }}</div>
                <div class="flex justify-between items-center text-xs mt-0.5">
                    <span>{{ $item->qty }} x {{ number_format($item->price_at_transaction, 0, ',', '.') }}</span>
                    <span>{{ number_format($item->qty * $item->price_at_transaction, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="border-t border-dashed border-black my-2"></div>

    <div class="flex justify-between items-center text-sm font-black my-2">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
    </div>

    @if(isset($transaction->paid_amount))
        <div class="flex justify-between text-xs font-semibold mt-1">
            <span>Bayar</span>
            <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-xs font-semibold mt-1">
            <span>Kembali</span>
            <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
        </div>
    @endif

    <div class="border-t border-dashed border-black my-2"></div>

    <div class="text-center mt-4 text-xs font-bold">
        <p>Terima Kasih</p>
        <p>Selamat Berbelanja Kembali</p>
    </div>

</body>

</html>