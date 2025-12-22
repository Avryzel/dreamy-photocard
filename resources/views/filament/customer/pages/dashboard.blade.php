<x-filament-panels::page>
    <style>
        .custom-dashboard * {margin:0;padding:0;box-sizing:border-box}
        .custom-dashboard {font-family:Arial,sans-serif;background:#f5f5f5; border-radius: 10px; overflow: hidden;}

        /* --- TAMBAHAN: STYLE UNTUK NAVBAR --- */
        .store-header {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 15px 20px; 
            background: white; 
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .store-logo { font-size: 1.2rem; font-weight: bold; color: #4338ca; }
        .auth-buttons a {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            transition: 0.3s;
            margin-left: 10px;
        }
        .btn-login { border: 1px solid #4338ca; color: #4338ca; background: white; }
        .btn-register { background: linear-gradient(135deg,#9FA8DA,#B39DDB); color: white; border: none; }
        .btn-login:hover { background: #f0f0f0; }
        .btn-register:hover { opacity: 0.9; transform: scale(1.05); }
        /* ------------------------------------ */

        .hero-image{width:100%;height:280px;overflow:hidden; border-radius: 12px; margin-bottom: 20px;}
        .hero-image img{width:100%;height:100%;object-fit:cover}

        .artist-section{padding:30px 20px;display:flex;flex-wrap: wrap;justify-content: center;gap:25px;max-width:1200px;margin:auto}
        .artist-card{background:#fff;border-radius:50%;width:100px;height:100px;overflow:hidden;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(0,0,0,.1);transition:.3s;cursor: pointer;}
        .artist-card:hover{transform:scale(1.1)}
        .artist-card img{width:100%;height:100%;object-fit:cover}

        .section-title{max-width:1200px;margin:30px auto 15px;padding:0 20px;font-size:24px;font-weight:bold;color:#444}
        
        .album-grid{padding:0 20px 40px;display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;max-width:1200px;margin:auto}
        .album-card{background:#fff;border-radius:15px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,.1);transition:.3s;text-decoration:none;color:inherit;display: block;height: 100%;}
        .album-card:hover{transform:translateY(-8px)}
        .album-image{height:240px;overflow:hidden; background: #eee;}
        .album-image img{width:100%;height:100%;object-fit:cover}
        .album-info{padding:15px}
        .album-title{font-size:14px;color:#666;margin-bottom:6px; text-transform: uppercase;}
        .album-price{font-size:16px;font-weight:bold; color: #333;}
        .stok-badge { font-size: 12px; color: green; font-weight: bold; margin-top: 5px; display: block;}
    </style>

    <div class="custom-dashboard">

        <div class="store-header">
            <div class="store-logo">✨ DREAMY STORE</div>
            <div class="auth-buttons">
                @auth
                    <a href="{{ route('cart') }}" class="btn-login" style="margin-right: 10px;">🛒 Keranjang</a>
                    <span style="color: #555; margin-right: 10px;">Hi, {{ auth()->user()->name }}! 👋</span>
                @else
                    <a href="/member/login" class="btn-login">Masuk</a>
                    <a href="/member/register" class="btn-register">Daftar</a>
                @endauth
            </div>
        </div>

        <section class="hero-image">
            <img src="https://placehold.co/1200x400/9FA8DA/ffffff?text=DREAMY+K-POP+STORE" alt="Banner">
        </section>

        <section class="artist-section">
            @foreach(['NCT DREAM', 'LE SSERAFIM', 'ILLIT', 'ENHYPEN', 'JENNIE', 'ROSE', 'JISOO'] as $artist)
            <div class="artist-card" title="{{ $artist }}">
                <img src="https://ui-avatars.com/api/?name={{ $artist }}&background=random" alt="{{ $artist }}">
            </div>
            @endforeach
        </section>

        <div class="section-title">LATEST PHOTOCARD</div>
        <section class="album-grid">
            @foreach($latestProducts as $product)
                <a href="{{ route('filament.customer.pages.product-detail', ['id' => $product->idPhotocard]) }}" class="album-card">
                    <div class="album-image">
                        @if($product->foto_pc)
                            <img src="{{ asset('storage/' . $product->foto_pc) }}" alt="{{ $product->nama_pc }}">
                        @else
                            <div style="height:100%; display:flex; align-items:center; justify-content:center; color:#999;">No Image</div>
                        @endif
                    </div>
                    <div class="album-info">
                        <div class="album-title">{{ $product->nama_pc }}</div>
                        <div class="album-price">Rp {{ number_format($product->harga_pc, 0, ',', '.') }}</div>
                        <span class="stok-badge">Stok: {{ $product->stock_pc }}</span>
                        @auth
                            <form action="{{ route('add-to-cart') }}" method="POST" style="margin-top: 8px;">
                                @csrf
                                <input type="hidden" name="id_photocard" value="{{ $product->idPhotocard }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-blue-500 text-white py-1 px-3 rounded text-sm hover:bg-blue-600">
                                    Add to Cart
                                </button>
                            </form>
                        @endauth
                    </div>
                </a>
            @endforeach
        </section>

        <div class="section-title">BEST SELLER</div>
        <section class="album-grid">
            @foreach($bestSellers as $product)
                <a href="{{ route('filament.customer.pages.product-detail', ['id' => $product->idPhotocard]) }}" class="album-card">
                    <div class="album-image">
                        @if($product->foto_pc)
                            <img src="{{ asset('storage/' . $product->foto_pc) }}" alt="{{ $product->nama_pc }}">
                        @else
                            <div style="height:100%; display:flex; align-items:center; justify-content:center; color:#999;">No Image</div>
                        @endif
                    </div>
                    <div class="album-info">
                        <div class="album-title">{{ $product->nama_pc }}</div>
                        <div class="album-price">Rp {{ number_format($product->harga_pc, 0, ',', '.') }}</div>
                        @auth
                            <form action="{{ route('add-to-cart') }}" method="POST" style="margin-top: 8px;">
                                @csrf
                                <input type="hidden" name="id_photocard" value="{{ $product->idPhotocard }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-blue-500 text-white py-1 px-3 rounded text-sm hover:bg-blue-600">
                                    Add to Cart
                                </button>
                            </form>
                        @endauth
                    </div>
                </a>
            @endforeach
        </section>

    </div>
</x-filament-panels::page>