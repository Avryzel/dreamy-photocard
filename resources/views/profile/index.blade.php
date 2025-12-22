<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profil - Dreamy Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .tab-content { display: none; animation: fadeIn 0.4s; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .nav-item.active { background-color: #EEF2FF; color: #4F46E5; border-right: 3px solid #4F46E5; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="w-full px-4 sm:px-6 lg:px-10">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">✨ Dreamy Store</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-gray-500 hover:text-indigo-600 font-medium px-3 py-2 rounded-md transition">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-indigo-700 transition">
                            Dashboard Admin
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium px-3 py-2 transition">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="w-full px-4 sm:px-6 lg:px-10 py-10">
        
        {{-- @if(session('success')) ... @endif --}}

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <div class="md:col-span-1">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-24">
                    <div class="bg-indigo-600 p-6 text-center">
                        <div class="relative inline-block">
                            @if($user->foto_profil)
                                <img id="avatar-preview" src="{{ asset('storage/' . $user->foto_profil) }}" class="w-24 h-24 rounded-full border-4 border-white object-cover mx-auto shadow-md">
                            @else
                                <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=fff&color=4F46E5" class="w-24 h-24 rounded-full border-4 border-white object-cover mx-auto shadow-md">
                            @endif
                        </div>
                        <h2 class="mt-4 text-xl font-bold text-white">{{ $user->username }}</h2>
                        <p class="text-indigo-200 text-sm">{{ $user->email }}</p>
                    </div>

                    <nav class="p-4 space-y-2">
                        <button onclick="switchTab('profile')" id="btn-profile" class="nav-item active w-full flex items-center px-4 py-3 text-left rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-user-edit w-6 text-center mr-3 text-indigo-500"></i>
                            <span class="font-medium">Edit Profil</span>
                        </button>
                        
                        <button onclick="switchTab('orders')" id="btn-orders" class="nav-item w-full flex items-center px-4 py-3 text-left rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-box-open w-6 text-center mr-3 text-indigo-500"></i>
                            <span class="font-medium">Riwayat Pesanan</span>
                        </button>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center px-4 py-2 text-green-600 bg-green-50 rounded-lg text-sm">
                                <i class="fas fa-check-circle mr-2"></i> Akun Terverifikasi
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="md:col-span-3">
                
                <div id="tab-profile" class="tab-content active bg-white rounded-xl shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Edit Informasi Pribadi</h2>
                    
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil Baru</label>
                                <div class="flex items-center space-x-4">
                                    <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg border border-gray-300 transition text-gray-600 text-sm font-medium">
                                        <i class="fas fa-camera mr-2"></i> Pilih Foto
                                        
                                        <input type="file" name="avatar" class="hidden" onchange="previewImage(event)">
                                    </label>
                                    <span class="text-xs text-gray-400">JPG, PNG (Max 2MB)</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" value="{{ $user->email }}" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                                <p class="mt-1 text-xs text-gray-400">Email tidak dapat diubah demi keamanan.</p>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition w-full md:w-auto shadow-lg shadow-indigo-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="tab-orders" class="tab-content bg-white rounded-xl shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Riwayat Pesanan Saya</h2>

                    @if($orders->isEmpty())
                        <div class="text-center py-12">
                            <div class="bg-indigo-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-shopping-basket text-2xl text-indigo-500"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                            <p class="text-gray-500 mb-6">Yuk mulai belanja koleksi photocard favoritmu!</p>
                            <a href="{{ url('/') }}" class="text-indigo-600 font-bold hover:underline">Ke Beranda &rarr;</a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition">
                                    <div class="bg-gray-50 px-6 py-4 flex flex-wrap items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-sm">
                                                <p class="text-gray-500">Tanggal Order</p>
                                                <p class="font-bold text-gray-800">{{ $order->created_at->format('d M Y') }}</p>
                                            </div>
                                            <div class="hidden md:block h-8 w-px bg-gray-300"></div>
                                            <div class="text-sm">
                                                <p class="text-gray-500">Total Harga</p>
                                                <p class="font-bold text-indigo-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        
                                        @php
                                            $colors = [
                                                'PERMINTAAN' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                'DIPROSES' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'DIKIRIM' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'SELESAI' => 'bg-green-100 text-green-800 border-green-200',
                                                'DIBATALKAN' => 'bg-red-100 text-red-800 border-red-200',
                                            ];
                                            $class = $colors[$order->status_pesanan] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $class }} uppercase tracking-wider">
                                            {{ $order->status_pesanan }}
                                        </span>
                                    </div>

                                    <div class="p-6 bg-white">
                                        @foreach($order->details as $detail)
                                            <div class="flex justify-between items-center mb-3 last:mb-0">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-500 mr-3">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-800">{{ $detail->photocard->nama_pc ?? 'Item dihapus' }}</p>
                                                        <p class="text-xs text-gray-500">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                <p class="font-semibold text-gray-700">Rp {{ number_format($detail->jumlah * $detail->harga_per_item, 0, ',', '.') }}</p>
                                            </div>
                                        @endforeach

                                        @if($order->nomor_resi)
                                            <div class="mt-4 pt-4 border-t border-dashed border-gray-200">
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    <i class="fas fa-shipping-fast text-indigo-500 mr-2"></i>
                                                    Nomor Resi: <span class="ml-2 font-mono bg-gray-100 px-2 py-1 rounded font-bold">{{ $order->nomor_resi }}</span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const imageField = document.getElementById('avatar-preview');

            reader.onload = function(){
                if(reader.readyState == 2){
                    imageField.src = reader.result; 
                }
            }

            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#4F46E5',
                confirmButtonText: 'Oke'
            });
        @endif

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));

            document.getElementById('tab-' + tabName).classList.add('active');
            document.getElementById('btn-' + tabName).classList.add('active');
        }
    </script>

</body>
</html>