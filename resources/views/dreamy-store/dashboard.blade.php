<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dreamy Store</title>
    
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
            flex: 1; padding: 10px 20px; border: none; border-radius: 20px; outline: none;
            font-size: 14px; box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
        }

        .icons { display: flex; gap: 15px; align-items: center; margin-left: 10px; }
        .icon-btn { font-size: 20px; cursor: pointer; color: white; text-decoration: none; border: none; background: transparent; transition: 0.2s; }
        .icon-btn:hover { transform: scale(1.1); }
        
        .auth-text { font-size: 14px; color: white; font-weight: bold; text-decoration: none; border: 1px solid white; padding: 5px 12px; border-radius: 20px; transition: 0.3s; }
        .auth-text:hover { background: white; color: #9FA8DA; }

        /* HERO IMAGE: Menampilkan banner iklan kustom [cite: 2025-10-29] */
        .hero-image { width: 100%; height: 280px; overflow: hidden; margin-bottom: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .hero-image img { width: 100%; height: 100%; object-fit: cover; }

        .section-title { max-width: 1300px; margin: 30px auto 15px; padding: 0 20px; font-size: 20px; font-weight: bold; color: #444; text-transform: uppercase; letter-spacing: 1px; border-left: 5px solid #9FA8DA; padding-left: 15px; }

        .album-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; max-width: 1300px; margin: auto; padding: 0 20px; }
        @media (min-width: 768px) { .album-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 1024px) { .album-grid { grid-template-columns: repeat(4, 1fr); } }
        @media (min-width: 1280px) { .album-grid { grid-template-columns: repeat(5, 1fr); } }

        .album-card { background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,.05); transition: .3s; display: flex; flex-direction: column; height: 100%; }
        .album-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(159, 168, 218, 0.3); }
        .album-image { aspect-ratio: 3/4; overflow: hidden; background: #eee; }
        .album-image img { width: 100%; height: 100%; object-fit: cover; }

        .album-info { padding: 15px; flex: 1; display: flex; flex-direction: column; }
        .album-title { font-size: 14px; color: #555; margin-bottom: 8px; font-weight: 500; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 40px; line-height: 20px; }
        .album-price { font-size: 18px; font-weight: bold; color: #333; margin-top: auto; }
        .stok-badge { font-size: 11px; color: #2ecc71; font-weight: bold; margin-bottom: 12px; }

        .btn-cart { width: 100%; background: linear-gradient(135deg, #9FA8DA, #B39DDB); color: white; border: none; padding: 10px; border-radius: 8px; font-size: 13px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-cart:hover { opacity: 0.9; }

        .pagination-container { max-width: 1300px; margin: 40px auto; padding: 0 20px; display: flex; justify-content: center; }
        .custom-pagination nav > div:first-child { display: none; }
        .custom-pagination nav span[aria-current="page"] span { background-color: #9FA8DA !important; border-color: #9FA8DA !important; color: white !important; border-radius: 8px; }
        .custom-pagination nav a, .custom-pagination nav span { border-radius: 8px !important; margin: 0 3px; border: 1px solid #e5e7eb; transition: 0.3s; }
        .custom-pagination nav a:hover { background-color: #F0F2FF !important; color: #9FA8DA !important; border-color: #9FA8DA !important; }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="store-logo">✨ DREAMY</div>
        <input type="text" id="searchInput" placeholder="Search your favorite bias..." onkeyup="searchProduct()">
        <div class="icons">
            @auth
                <a href="{{ route('cart') }}" class="icon-btn">🛒</a>
                <a href="{{ route('profile.index') }}" class="icon-btn">
                    @if(auth()->user()->foto_profil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" style="width:30px; height:30px; border-radius:50%; border:2px solid white; object-fit:cover;">
                    @else 👤 @endif
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="icon-btn">🚪</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="auth-text">Login</a>
            @endauth
        </div>
    </header>

    <div style="padding: 20px;">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 max-w-xl mx-auto text-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <section class="hero-image max-w-[1260px] mx-auto">
            <img src="{{ asset('assets/Iklan.jpg') }}" alt="Dreamy Banner">
        </section>

        <div class="section-title">LATEST PHOTOCARD</div>
        <section class="album-grid">
            @foreach($latestProducts as $product)
                <div class="album-card" data-title="{{ $product->nama_pc }}">
                    <a href="{{ route('product.detail', $product->idPhotocard) }}">
                        <div class="album-image">
                            @if($product->foto_pc)
                                <img src="{{ asset('storage/' . $product->foto_pc) }}" alt="{{ $product->nama_pc }}" loading="lazy">
                            @else
                                <div style="height:100%; display:flex; align-items:center; justify-content:center; background:#eee;">No Image</div>
                            @endif
                        </div>
                    </a>
                    <div class="album-info">
                        <div class="album-title">{{ $product->nama_pc }}</div>
                        <div class="album-price">Rp {{ number_format($product->harga_pc, 0, ',', '.') }}</div>
                        <span class="stok-badge">Stok: {{ $product->stock_pc }}</span>
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

        <div class="pagination-container py-5">
            <div class="custom-pagination">
                {{ $latestProducts->links() }}
            </div>
        </div>

        <div class="section-title">BEST SELLER</div>
        <section class="album-grid">
            @foreach($bestSellers as $product)
                <div class="album-card" data-title="{{ $product->nama_pc }}">
                    <a href="{{ route('product.detail', $product->idPhotocard) }}">
                        <div class="album-image">
                            @if($product->foto_pc)
                                <img src="{{ asset('storage/' . $product->foto_pc) }}" alt="{{ $product->nama_pc }}" loading="lazy">
                            @else
                                <div style="height:100%; display:flex; align-items:center; justify-content:center; background:#eee;">No Image</div>
                            @endif
                        </div>
                    </a>
                    <div class="album-info">
                        <div class="album-title">{{ $product->nama_pc }}</div>
                        <div class="album-price">Rp {{ number_format($product->harga_pc, 0, ',', '.') }}</div>
                        <span class="stok-badge">Stok: {{ $product->stock_pc }}</span>
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

    <footer style="background: linear-gradient(135deg, #9FA8DA, #B39DDB); padding: 40px; text-align: center; color: white; margin-top: 50px;">
        <div style="font-weight: bold; margin-bottom: 10px;">✨ DREAMY STORE</div>
        <div style="font-size: 12px; opacity: 0.8;">&copy; 2025 Dreamy Store Official. Made with Deliberate Effort.</div>
    </footer>

    <script>
        function searchProduct() {
            const keyword = document.getElementById("searchInput").value.toLowerCase();
            const cards = document.querySelectorAll(".album-grid .album-card");
            const pagination = document.querySelector(".pagination-container");

            cards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                card.style.display = title.includes(keyword) ? "flex" : "none";
            });

            if (keyword.length > 0 && pagination) {
                pagination.style.display = "none";
            } else if (pagination) {
                pagination.style.display = "flex";
            }
        }
    </script>
</body>
</html>