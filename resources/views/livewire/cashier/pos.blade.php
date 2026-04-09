<div style="max-width:1200px; margin:auto; padding:20px; font-family:Arial, sans-serif; font-weight:400;">

    <input 
        type="text"
        wire:model.live="search"
        placeholder="Cari produk..."
        style="width:200px; padding:8px; border:1px solid #ccc; border-radius:8px; margin-bottom:20px;"
    >

    @if(session()->has('error'))
        <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:6px; margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:flex; gap:20px; align-items:flex-start;">

        <div style="flex:1; background:white; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

            <h3 style="margin-bottom:15px;">Daftar Produk</h3>

            <table style="width:100%; border-collapse:separate; border-spacing:0 10px; table-layout:fixed;">

                <thead>
                    <tr style="background:#f1f3f5;">
                        <th style="padding:12px; text-align:center; width:60px;">No</th>
                        <th style="padding:12px; text-align:left;">Nama</th>
                        <th style="padding:12px; text-align:left; width:180px;">Harga</th>
                        <th style="padding:12px; text-align:left; width:100px;">Stok</th>
                        <th style="padding:12px; text-align:center; width:100px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $index => $product)
                        <tr style="background:white; box-shadow:0 2px 6px rgba(0,0,0,0.05);">

                            <td style="padding:12px; text-align:center;">
                                {{ $index + 1 }}
                            </td>

                            <td style="padding:12px; font-weight:500;">
                                {{ $product->name }}
                            </td>

                            <td style="padding:12px;">
                                Rp {{ number_format($product->sell_price, 0, ',', '.') }}
                            </td>

                            <td style="padding:12px;">
                                <span style="background:#e9ecef; padding:4px 10px; border-radius:8px; font-size:12px; display:inline-block; min-width:40px;">
                                    {{ $product->stock->quantity ?? 0 }}
                                </span>
                            </td>

                            <td style="padding:12px; text-align:center;">
                                <button 
                                    wire:click="addToCart({{ $product->id }})"
                                    style="width:38px; height:38px; background:#6c757d; color:white; border:none; border-radius:10px; cursor:pointer;"
                                >
                                    +
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div style="width:320px; background:white; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

            <h3 style="margin-bottom:15px; text-align:center;">Transaksi</h3>

            <div style="font-size:14px; color:#666; margin-bottom:10px;">
                Produk yang dipilih
            </div>

            @forelse($cart as $item)
                <div style="border-bottom:1px solid #eee; margin-bottom:10px; padding-bottom:10px;">
                    
                    <div>
                        {{ $item['name'] }}
                    </div>

                    <div style="font-size:13px; color:#666;">
                        Rp {{ number_format($item['price'], 0, ',', '.') }} × {{ $item['qty'] }}
                    </div>

                </div>
            @empty
                <p style="color:#777; font-size:14px;">Kosong</p>
            @endforelse

            <div style="text-align:right; margin-top:10px;">
                Total: Rp {{ number_format($total, 0, ',', '.') }}
            </div>

            <button 
                wire:click="checkout"
                style="width:100%; margin-top:12px; padding:12px; background:#6c757d; color:white; border:none; border-radius:10px; font-size:16px; cursor:pointer;"
            >
                Bayar
            </button>

        </div>

    </div>
</div>