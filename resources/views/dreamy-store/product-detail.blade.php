<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama_pc }} - Dreamy Store</title>
    
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
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            height: 70px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .store-logo { font-size: 1.2rem; font-weight: bold; color: white; text-decoration: none; }
        .icons { display: flex; gap: 15px; align-items: center; }
        .icon-btn { font-size: 20px; cursor: pointer; color: white; text-decoration: none; transition: 0.2s; border: none; background: transparent; }
        .icon-btn:hover { transform: scale(1.1); }
        
        .product-container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .section-header { font-size: 1.1rem; font-weight: bold; margin-bottom: 12px; border-left: 4px solid #9FA8DA; padding-left: 10px; color: #444; }
        .info-list { padding-left: 18px; line-height: 1.7; font-size: 14px; color: #555; margin-bottom: 10px; }

        .btn-buy { background: #5865D9; color: white; font-weight: bold; transition: 0.3s; }
        .btn-buy:hover { background: #4650b8; }
        .btn-cart { background: #e0e0e0; color: #333; transition: 0.3s; }
        .btn-cart:hover { background: #d0d0d0; }
    </style>
</head>
<body>

    <header class="topbar">
        <a href="{{ route('home') }}" class="store-logo">✨ DREAMY STORE</a>

        <div class="icons">
            @auth
                <a href="{{ route('cart') }}" class="icon-btn" title="Keranjang">🛒</a>
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
            @else
                <a href="{{ route('login') }}" class="text-white font-bold border border-white px-5 py-2 rounded-full hover:bg-white hover:text-[#9FA8DA] transition">Login</a>
            @endauth
        </div>
    </header>

    <div class="product-container">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-center mb-8">
            <img src="{{ asset('storage/' . $product->foto_pc) }}" class="max-w-[320px] w-full rounded-lg shadow-md border">
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->nama_pc }}</h1>
        <div class="text-2xl font-bold text-gray-900 mb-6">
            Rp {{ number_format($product->harga_pc, 0, ',', '.') }}
        </div>

        <div class="section-header">Deskripsi Produk</div>
        <div class="text-gray-600 mb-8 leading-relaxed">
            {{ $product->deskripsi_pc ?? 'Tidak ada deskripsi untuk produk ini.' }}
        </div>

        <div class="section-header">Informasi Produk</div>
        <ul class="info-list list-disc">
            <li>Gambar photocard hanya digunakan untuk identifikasi produk.</li>
            <li>Gambar dapat berbeda dengan photocard asli yang diterima.</li>
            <li>Harga berlaku untuk 1 lembar photocard.</li>
            <li>Photocard merupakan official/original dari album atau merchandise resmi.</li>
            <li>Periksa detail produk sebelum membeli.</li>
            <li>Produk tidak dapat dikembalikan kecuali terdapat kesalahan pengiriman.</li>
        </ul>

        <div class="pt-2 border-t">
            @auth
                <form action="{{ route('add-to-cart') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id_photocard" value="{{ $product->idPhotocard }}">
                    
                    <div class="flex items-center gap-4 py-2">
                        <label class="font-bold text-gray-700">Jumlah:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_pc }}" 
                               class="border rounded-lg px-3 py-1 w-20 text-center outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <div class="flex flex-col md:flex-row gap-3">
                        <button type="submit" name="action" value="add_to_cart" class="btn-cart flex-1 py-4 rounded-xl font-bold transition transform hover:scale-[1.01]">
                            🛒 Tambah ke Keranjang
                        </button>
                        <button type="submit" name="action" value="buy_now" class="btn-buy flex-1 py-4 rounded-xl font-bold transition transform hover:scale-[1.01]">
                            Beli Sekarang
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-gray-50 p-6 rounded-xl text-center border border-dashed">
                    <p class="text-gray-600 mb-4 font-medium">Masuk untuk mulai mengoleksi photocard ini.</p>
                    <a href="{{ route('login') }}" class="inline-block bg-indigo-500 text-white px-8 py-3 rounded-full font-bold shadow-md hover:bg-indigo-600 transition">
                        Login untuk Membeli
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <footer style="background: linear-gradient(135deg, #9FA8DA, #B39DDB); padding: 40px 20px; text-align: center; color: white; margin-top: 50px; box-shadow: 0 -4px 10px rgba(0,0,0,0.05);">
        <div style="font-weight: bold; font-size: 1.1rem; margin-bottom: 10px;">✨ DREAMY STORE</div>
        <p style="font-size: 13px; opacity: 0.9; margin-bottom: 15px;">Pusat koleksi photocard original dan terpercaya untuk melengkapi koleksi bias kamu.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px; font-size: 12px; opacity: 0.8;">
            &copy; 2025 Dreamy Store Official. Made with Deliberate Effort.
        </div>
    </footer>

</body>
</html>