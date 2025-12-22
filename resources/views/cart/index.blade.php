<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja - {{ config('app.name', 'Laravel') }}</title>

    <style>
        body{ margin:0; font-family:Arial,sans-serif; background:#f5f5f5; }
        .header{ padding:15px; background:#5865D9; color:white; text-align:center; font-size:20px; font-weight:bold; }
        .container{ max-width:900px; margin:30px auto; background:white; padding:20px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,.1); }
        .cart-item{ display:flex; gap:15px; border-bottom:1px solid #eee; padding:15px 0; }
        .cart-item img{ width:100px; height: 100px; object-fit: cover; border-radius:8px; }
        .cart-info{ flex:1; }
        .cart-title{ font-weight:bold; margin-bottom:6px; font-size: 16px; }
        .cart-group{ font-size: 12px; color: #888; margin-bottom: 4px; }
        .cart-price{ color:#444; margin-bottom:10px; font-weight: 500; }
        
        .qty{ display:flex; align-items:center; gap:10px; }
        .qty form { display: inline-block; margin: 0; }
        .qty button{ width:30px; height:30px; border:none; background:#ddd; border-radius:6px; cursor:pointer; font-weight:bold; font-size: 16px; display: flex; align-items: center; justify-content: center; }
        .qty button:hover { background: #ccc; }
        .qty span{ min-width:20px; text-align:center; font-weight: bold; }

        .remove-form { margin-top: 8px; }
        .remove{ background:none; border:none; color:red; cursor:pointer; font-size:14px; padding: 0; }
        .remove:hover { text-decoration: underline; }

        .total{ margin-top:25px; font-size:20px; font-weight:bold; text-align:right; }
        .checkout{ margin-top:20px; text-align:right; }
        .checkout-btn{ padding:12px 25px; font-size:16px; background:#25D366; color:white; border:none; border-radius:8px; cursor:pointer; text-decoration: none; display: inline-block; font-weight: bold; }
        .checkout-btn:hover { background: #1ebc57; }
        
        .empty{ text-align:center; font-size:18px; color:#777; padding: 50px 0; }
        .back{ margin-bottom:15px; display:inline-block; text-decoration:none; color:#5865D9; font-weight: bold; }
        .back:hover { text-decoration: underline; }
        
        /* Alert Message Styling */
        .alert { position: fixed; bottom: 20px; right: 20px; padding: 15px 25px; color: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); z-index: 1000; }
        .alert-success { background-color: #25D366; }
        .alert-error { background-color: #ff4444; }
    </style>
</head>

<body>

    <div class="header">🛒 Keranjang Belanja</div>

    <div class="container">
        <a href="/member" class="back">← Kembali belanja</a>

        @if($cartItems->count() > 0)
            <div id="cart">
                @foreach($cartItems as $item)
                <div class="cart-item">
                    <img src="{{ asset('storage/' . $item->photocard->foto_pc) }}" alt="{{ $item->photocard->nama_pc }}">
                    
                    <div class="cart-info">
                        <div class="cart-title">{{ $item->photocard->nama_pc }}</div>
                        <div class="cart-group">
                            {{ $item->photocard->groupBand ? $item->photocard->groupBand->nama_group : 'General' }}
                        </div>
                        
                        <div class="cart-price">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>

                        <div class="qty">
                            <form action="{{ route('cart.update', $item->idKeranjang) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->jumlah_item - 1 }}">
                                <button type="submit" {{ $item->jumlah_item <= 1 ? 'disabled style=opacity:0.5' : '' }}>−</button>
                            </form>

                            <span>{{ $item->jumlah_item }}</span>

                            <form action="{{ route('cart.update', $item->idKeranjang) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->jumlah_item + 1 }}">
                                <button type="submit" {{ $item->jumlah_item >= $item->photocard->stock_pc ? 'disabled style=opacity:0.5' : '' }}>+</button>
                            </form>
                        </div>

                        <form action="{{ route('cart.destroy', $item->idKeranjang) }}" method="POST" class="remove-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove" onclick="return confirm('Hapus item ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach

                <div class="total">
                    Total: Rp {{ number_format($cartItems->sum('subtotal'), 0, ',', '.') }}
                </div>

                <div class="checkout">
                    @php
                        // Logic Membuat Pesan WhatsApp Otomatis dari Data Database
                        $adminPhone = "6281296724544"; // GANTI NOMOR ADMIN DI SINI
                        $message = "Halo Admin Dreamy 👋\n\nSaya ingin memesan:\n\n";
                        foreach($cartItems as $index => $item) {
                            $message .= ($index + 1) . ". " . $item->photocard->nama_pc . "\n";
                            $message .= "   Qty: " . $item->jumlah_item . "\n";
                            $message .= "   Subtotal: Rp " . number_format($item->subtotal, 0, ',', '.') . "\n\n";
                        }
                        $message .= "Total: Rp " . number_format($cartItems->sum('subtotal'), 0, ',', '.') . "\n";
                        $message .= "Mohon diproses ya! 🙏";
                        
                        $waUrl = "https://wa.me/" . $adminPhone . "?text=" . urlencode($message);
                    @endphp

                    <a href="{{ $waUrl }}" target="_blank" class="checkout-btn">Checkout via WhatsApp</a>
                </div>
            </div>
        @else
            <div class="empty">
                <div>🛒</div>
                Keranjang masih kosong<br>
                <small style="font-size: 14px; color: #999;">Yuk cari bias kamu sekarang!</small>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success" onclick="this.style.display='none'">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" onclick="this.style.display='none'">
            {{ session('error') }}
        </div>
    @endif

</body>
</html>