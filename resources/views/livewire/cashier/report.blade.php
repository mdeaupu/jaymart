<div style="max-width:950px; margin:auto; padding:25px; font-family:Arial, sans-serif;">

    <!-- HEADER -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0;">Laporan Kasir</h2>

        <select wire:model.live="shift" 
            style="padding:8px 12px; border-radius:8px; border:1px solid #ccc; cursor:pointer; width:150px;">
            <option value="Pagi">Shift Pagi</option>
            <option value="Siang">Shift Siang</option>
            <option value="Malam">Shift Malam</option>
        </select>
    </div>

    <!-- CARD SUMMARY -->
    <div style="display:flex; gap:15px; margin-bottom:20px;">

        <!-- TOTAL TRANSAKSI -->
        <div style="flex:1; background:#f8f9fa; padding:20px; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <div style="color:#666; font-size:14px;">Total Transaksi</div>
            <div style="font-size:24px; font-weight:bold; margin-top:5px;">
                {{ $count }}
            </div>
        </div>

        <!-- TOTAL PENJUALAN -->
        <div style="flex:1; background:#e7f5ff; padding:20px; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <div style="color:#666; font-size:14px;">Total Penjualan</div>
            <div style="font-size:22px; font-weight:bold; margin-top:5px;">
                Rp {{ number_format($total,0,',','.') }}
            </div>
        </div>

    </div>

    <!-- LIST TRANSAKSI -->
    <div style="background:white; border-radius:12px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

        <h4 style="margin-bottom:15px;">Daftar Transaksi</h4>

        @forelse($transactions as $trx)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; border-bottom:1px solid #eee;">

                <div>
                    <div style="font-weight:600;">
                        {{ $trx->invoice_number }}
                    </div>
                    <div style="font-size:12px; color:#777;">
                        {{ $trx->created_at->format('d M Y H:i') }}
                    </div>
                </div>

                <div style="font-weight:bold;">
                    Rp {{ number_format($trx->total_price,0,',','.') }}
                </div>

            </div>
        @empty
            <div style="text-align:center; color:#999; padding:20px;">
                Tidak ada transaksi
            </div>
        @endforelse

    </div>

</div>