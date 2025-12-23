<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja - Dreamy Store</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { overflow-y: scroll; }
        body { font-family: Arial, sans-serif; background: #A9AEE6; line-height: 1.5; }

        .topbar {
            background: linear-gradient(135deg, #9FA8DA, #B39DDB);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0; left: 0; right: 0;
            z-index: 100;
            height: 70px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .store-logo { font-size: 1.2rem; font-weight: bold; color: white; text-decoration: none; }
        .icons { display: flex; gap: 15px; align-items: center; }
        .icon-btn { font-size: 20px; cursor: pointer; color: white; text-decoration: none; transition: 0.2s; border: none; background: transparent; }
        .icon-btn:hover { transform: scale(1.1); }

        .container {
            max-width: 680px; 
            width: 90%; 
            margin: 35px auto; 
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .cart-item {
            display: flex;
            gap: 15px;
            border-bottom: 1px solid #f3f4f6;
            padding: 15px 0;
            align-items: center;
        }

        .cart-item img {
            width: 80px; height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .cart-info { flex: 1; }
        .cart-title { font-weight: bold; font-size: 16px; color: #1f2937; }
        .cart-group { font-size: 11px; color: #9ca3af; text-transform: uppercase; margin-bottom: 2px; }
        .cart-price { color: #5865D9; font-weight: bold; font-size: 15px; }

        .qty-control { display: flex; align-items: center; gap: 10px; margin-top: 8px; }
        .qty-btn {
            width: 28px; height: 28px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 6px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .total-section {
            margin-top: 25px;
            text-align: right;
            border-top: 2px solid #f9fafb;
            padding-top: 15px;
        }

        .checkout-area {
            margin: 25px 5px 0 5px;
            background: #fdfdff;
            padding: 20px;
            border-radius: 15px;
            border: 1px dashed #B39DDB;
            text-align: center;
        }

        .btn-whatsapp {
            background: #25D366;
            color: white;
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.3s;
        }
        .btn-whatsapp:hover { background: #1ebc57; transform: translateY(-1px); }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #5865D9;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
            text-decoration: none;
        }

        .alert-box {
            position: fixed;
            top: 85px; right: 20px;
            z-index: 200;
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <header class="topbar">
        <a href="{{ route('home') }}" class="store-logo">✨ DREAMY STORE</a>

        <div class="icons">
            @auth
                <a href="{{ route('profile.index') }}" class="icon-btn" title="Profile Saya">
                    @if(auth()->user()->foto_profil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" style="width:30px; height:30px; border-radius:50%; border:2px solid white; object-fit:cover; vertical-align:middle;">
                    @else
                        <span style="font-size: 24px;">👤</span>
                    @endif
                </a>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="icon-btn" title="Sign Out" onclick="return confirm('Yakin ingin keluar?')">🚪</button>
                </form>
            @endauth
        </div>
    </header>

    <div class="container">
        <a href="{{ route('home') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali Belanja
        </a>

        @if($cartItems->count() > 0)
            @foreach($cartItems as $item)
                <div class="cart-item">
                    <img src="{{ asset('storage/' . $item->photocard->foto_pc) }}" alt="{{ $item->photocard->nama_pc }}">
                    
                    <div class="cart-info">
                        <div class="cart-group">{{ $item->photocard->groupBand ? $item->photocard->groupBand->nama_group : 'General' }}</div>
                        <div class="cart-title">{{ $item->photocard->nama_pc }}</div>
                        <div class="cart-price">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>
                        
                        <div class="qty-control">
                            <form action="{{ route('cart.update', $item->idKeranjang) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->jumlah_item - 1 }}">
                                <button type="submit" class="qty-btn" {{ $item->jumlah_item <= 1 ? 'disabled style=opacity:0.3' : '' }}>−</button>
                            </form>

                            <span class="font-bold text-sm w-6 text-center">{{ $item->jumlah_item }}</span>

                            <form action="{{ route('cart.update', $item->idKeranjang) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->jumlah_item + 1 }}">
                                <button type="submit" class="qty-btn" {{ $item->jumlah_item >= $item->photocard->stock_pc ? 'disabled style=opacity:0.3' : '' }}>+</button>
                            </form>
                        </div>
                    </div>

                    <form action="{{ route('cart.destroy', $item->idKeranjang) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-500 transition" onclick="return confirm('Hapus item ini?')">
                            <i class="fas fa-trash-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            @endforeach

            <div class="total-section">
                <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Pembayaran</span>
                <div class="text-2xl font-extrabold text-[#5865D9]">
                    Rp {{ number_format($cartItems->sum('subtotal'), 0, ',', '.') }}
                </div>
            </div>

            <div class="checkout-area">
                <div class="text-left mb-4">
                    <p class="text-[11px] text-gray-400 uppercase font-bold mb-1">Pemesanan Atas Nama</p>
                    <p class="text-sm font-bold text-gray-700">👤 {{ auth()->user()->name }} | {{ auth()->user()->email }}</p>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-whatsapp">
                        <i class="fab fa-whatsapp text-xl"></i> Checkout via WhatsApp
                    </button>
                </form>
                <p class="text-[9px] text-gray-400 mt-3 uppercase tracking-widest">Dreamy Store Official</p>
            </div>
        @else
            <div class="py-20 text-center">
                <div class="text-6xl mb-4 opacity-20">🛒</div>
                <p class="text-lg font-bold text-gray-400">Keranjang kamu masih kosong</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block bg-[#5865D9] text-white px-6 py-2 rounded-full text-sm font-bold">
                    Cari Bias Sekarang
                </a>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert-box bg-green-500" id="notif">{{ session('success') }}</div>
        <script>setTimeout(() => { document.getElementById('notif').style.display='none' }, 3000);</script>
    @endif

</body>
</html>