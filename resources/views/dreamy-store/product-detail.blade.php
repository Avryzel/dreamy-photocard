<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama_pc }} - Dreamy Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .topbar {
            background: linear-gradient(135deg, #9FA8DA, #B39DDB);
            padding: 15px 20px; display: flex; align-items: center; justify-content: space-between;
            color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-back { color: white; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 5px; }
        .btn-back:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="topbar">
        <a href="{{ route('home') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Home
        </a>
        <div class="font-bold text-xl">✨ Detail Produk</div>
        <div style="width: 80px;"></div> </div>

    <div class="max-w-4xl mx-auto p-6 mt-6">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row">
            
            <div class="md:w-1/2 bg-gray-100 flex items-center justify-center p-4">
                @if($product->foto_pc)
                    <img src="{{ asset('storage/' . $product->foto_pc) }}" class="max-h-[400px] object-contain rounded-lg shadow-sm">
                @else
                    <div class="text-gray-400">Tidak ada gambar</div>
                @endif
            </div>

            <div class="md:w-1/2 p-8 flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->nama_pc }}</h1>
                    <div class="text-2xl font-bold text-indigo-600 mb-4">
                        Rp {{ number_format($product->harga_pc, 0, ',', '.') }}
                    </div>
                    
                    <div class="mb-6">
                        <span class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full">
                            Stok Tersedia: {{ $product->stock_pc }}
                        </span>
                    </div>

                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $product->deskripsi_pc ?? 'Tidak ada deskripsi untuk produk ini.' }}
                    </p>
                </div>

                <div class="border-t pt-6">
                    @auth
                        <form action="{{ route('add-to-cart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_photocard" value="{{ $product->idPhotocard }}">
                            
                            <div class="flex items-center gap-4 mb-4">
                                <label class="font-bold text-gray-700">Jumlah:</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_pc }}" 
                                       class="border rounded-lg px-3 py-2 w-20 text-center focus:ring-2 focus:ring-indigo-400 outline-none">
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-400 to-purple-400 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3 rounded-lg shadow-md transition transform hover:scale-105">
                                <i class="fas fa-shopping-cart mr-2"></i> Masukkan Keranjang
                            </button>
                        </form>
                    @else
                        <a href="/member/login" class="block text-center w-full bg-gray-200 text-gray-700 font-bold py-3 rounded-lg hover:bg-gray-300">
                            Login untuk Membeli
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </div>

</body>
</html>