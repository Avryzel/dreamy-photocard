<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DREAMY STORE</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }

        .topbar {
            background: linear-gradient(135deg, #9FA8DA, #B39DDB);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .store-logo { font-size: 1.2rem; font-weight: bold; color: white; margin-right: 10px; white-space: nowrap; }

        #searchInput {
            flex: 1;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            outline: none;
            font-size: 14px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
        }

        .icons { display: flex; gap: 15px; align-items: center; margin-left: 10px; }
        .icon-btn { font-size: 20px; cursor: pointer; color: white; text-decoration: none; border: none; background: transparent; transition: 0.2s; }
        .icon-btn:hover { transform: scale(1.1); text-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        
        .auth-text { font-size: 14px; color: white; font-weight: bold; text-decoration: none; border: 1px solid white; padding: 5px 12px; border-radius: 20px; transition: 0.3s; }
        .auth-text:hover { background: white; color: #9FA8DA; }

        .hero-image { width: 100%; height: 280px; overflow: hidden; margin-bottom: 20px; border-radius: 12px; }
        .hero-image img { width: 100%; height: 100%; object-fit: cover; }

        .artist-section {
            padding: 30px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: auto;
            justify-items: center;
        }
        .artist-card {
            background: #fff; border-radius: 50%;
            width: 100px; height: 100px;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,.1);
            transition: .3s;
            cursor: pointer;
        }
        .artist-card:hover { transform: scale(1.1); border: 3px solid #B39DDB; }
        .artist-card img { width: 100%; height: 100%; object-fit: cover; }

        .section-title {
            max-width: 1200px; margin: 20px auto 10px; padding: 0 20px;
            font-size: 20px; font-weight: bold; color: #444; text-transform: uppercase; letter-spacing: 1px;
            border-left: 5px solid #9FA8DA; padding-left: 15px;
        }

        .album-grid {
            padding: 10px 20px 40px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: auto;
        }
        .album-card {
            background: #fff; border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            transition: .3s;
            text-decoration: none; color: inherit;
            display: flex; flex-direction: column;
            position: relative;
        }
        .album-card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(159, 168, 218, 0.4); }
        
        .album-image { height: 220px; overflow: hidden; background: #eee; position: relative; }
        .album-image img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .album-card:hover .album-image img { transform: scale(1.05); }

        .album-info { padding: 15px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .album-title { font-size: 14px; color: #666; margin-bottom: 5px; line-height: 1.4; font-weight: 500; }
        .album-price { font-size: 18px; font-weight: bold; color: #333; margin-bottom: 5px; }
        .stok-badge { font-size: 11px; color: #2ecc71; font-weight: bold; margin-bottom: 10px; display: block; }

        .btn-cart {
            width: 100%;
            background: linear-gradient(135deg, #9FA8DA, #B39DDB);
            color: white;
            border: none;
            padding: 8px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-cart:hover { opacity: 0.9; box-shadow: 0 3px 10px rgba(179, 157, 219, 0.5); }
        
        .main-container { padding: 20px; }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="store-logo">✨ DREAMY</div>

        <input 
            type="text" 
            id="searchInput" 
            placeholder="Search your favorite K-Pop photocard..."
            onkeyup="searchProduct()"
        >

        <div class="icons">
            <span class="icon-btn" onclick="document.getElementById('searchInput').focus()" title="Search">🔍</span>
            
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
                <a href="{{ route('login') }}" class="auth-text">Login</a>
                <a href="{{ route('register') }}" class="auth-text" style="background: white; color: #9FA8DA;">Daftar</a>
            @endauth
        </div>
    </header>

    <div class="main-container">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 max-w-xl mx-auto text-center">
                {{ session('success') }}
            </div>
        @endif

        <section class="hero-image">
            <img src="https://placehold.co/1200x400/9FA8DA/ffffff?text=DREAMY+K-POP+STORE" alt="Banner">
        </section>

        <section class="artist-section">
            @foreach(['NCT DREAM', 'LE SSERAFIM', 'ILLIT', 'ENHYPEN', 'JENNIE', 'ROSE', 'JISOO'] as $artist)
            <div class="artist-card" title="{{ $artist }}" onclick="fillSearch('{{ $artist }}')">
                <img src="https://ui-avatars.com/api/?name={{ $artist }}&background=random&color=fff" alt="{{ $artist }}">
            </div>
            @endforeach
        </section>

        <div class="section-title">LATEST PHOTOCARD</div>
        <section class="album-grid">
            @foreach($latestProducts as $product)
                <div class="album-card" data-title="{{ $product->nama_pc }} {{ $product->deskripsi_pc }}">
                    <a href="{{ route('product.detail', $product->idPhotocard) }}">
                        <div class="album-image">
                            @if($product->foto_pc)
                                <img src="{{ asset('storage/' . $product->foto_pc) }}" alt="{{ $product->nama_pc }}">
                            @else
                                <div style="height:100%; display:flex; align-items:center; justify-content:center; color:#999; background:#eee;">No Image</div>
                            @endif
                        </div>
                    </a>
                    <div class="album-info">
                        <div>
                            <div class="album-title">{{ $product->nama_pc }}</div>
                            <div class="album-price">Rp {{ number_format($product->harga_pc, 0, ',', '.') }}</div>
                            <span class="stok-badge">Stok: {{ $product->stock_pc }}</span>
                        </div>
                        
                        @auth
                            <form action="{{ route('add-to-cart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_photocard" value="{{ $product->idPhotocard }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-cart">+ Add to Cart</button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        </section>

        <div class="section-title">BEST SELLER</div>
        <section class="album-grid">
            @foreach($bestSellers as $product)
                <div class="album-card" data-title="{{ $product->nama_pc }} {{ $product->deskripsi_pc }}">
                    <a href="{{ route('product.detail', $product->idPhotocard) }}">
                        <div class="album-image">
                            @if($product->foto_pc)
                                <img src="{{ asset('storage/' . $product->foto_pc) }}" alt="{{ $product->nama_pc }}">
                            @else
                                <div style="height:100%; display:flex; align-items:center; justify-content:center; color:#999; background:#eee;">No Image</div>
                            @endif
                        </div>
                    </a>
                    <div class="album-info">
                        <div>
                            <div class="album-title">{{ $product->nama_pc }}</div>
                            <div class="album-price">Rp {{ number_format($product->harga_pc, 0, ',', '.') }}</div>
                        </div>
                        @auth
                            <form action="{{ route('add-to-cart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_photocard" value="{{ $product->idPhotocard }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-cart">+ Add to Cart</button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        </section>
    </div>

    <script>
        function searchProduct() {
            const keyword = document.getElementById("searchInput").value.toLowerCase();
            const cards = document.querySelectorAll(".album-card");

            cards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                card.style.display = title.includes(keyword) ? "flex" : "none";
            });
        }

        function fillSearch(artistName) {
            const searchInput = document.getElementById("searchInput");
            searchInput.value = artistName;
            searchProduct();
            searchInput.focus();
        }
    </script>
</body>
</html>