<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Dreamy Store</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { overflow-y: scroll; }
        body { font-family: Arial, sans-serif; background: #A9AEE6; line-height: 1.5; }

        .topbar {
            background: linear-gradient(135deg, #9FA8DA, #B39DDB);
            padding: 15px 20px;
            display: flex;
            align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100; height: 70px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .store-logo { font-size: 1.2rem; font-weight: bold; color: white; text-decoration: none; }
        .icon-btn { font-size: 20px; color: white; text-decoration: none; transition: 0.2s; border: none; background: transparent; cursor: pointer; }

        .container {
            max-width: 680px; width: 90%; margin: 35px auto; 
            background: white; padding: 35px; border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            color: #5865D9; font-size: 13px; font-weight: 600;
            margin-bottom: 25px; text-decoration: none; transition: 0.2s;
        }
        .btn-back:hover { color: #4650b8; transform: translateX(-3px); }

        .profile-header { text-align: center; border-bottom: 2px solid #f9fafb; padding-bottom: 30px; margin-bottom: 30px; }
        .avatar-large {
            width: 110px; height: 110px; border-radius: 50%; 
            object-fit: cover; border: 5px solid #f0f0f0; margin: 0 auto 15px;
        }

        .section-title { font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .order-card { background: #fdfdff; border: 1px solid #eef2ff; border-radius: 12px; padding: 20px; margin-bottom: 15px; }

        .status-badge { font-size: 10px; font-weight: bold; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; border: 1px solid transparent; }
        .status-permintaan { background: #f3f4f6; color: #374151; border-color: #d1d5db; }
        .status-diproses { background: #fef3c7; color: #92400e; border-color: #fcd34d; }
        .status-dikirim { background: #dbeafe; color: #1e40af; border-color: #93c5fd; }
        .status-selesai { background: #dcfce7; color: #166534; border-color: #86efac; }
        .status-dibatalkan { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }

        .btn-update { background: #5865D9; color: white; width: 100%; padding: 12px; border-radius: 10px; font-weight: bold; cursor: pointer; }
        .btn-signout { background: #fee2e2; color: #ef4444; width: 100%; padding: 12px; border-radius: 10px; font-weight: bold; margin-top: 20px; cursor: pointer; border: none; }
    </style>
</head>
<body>

    <header class="topbar">
        <a href="{{ route('home') }}" class="store-logo">✨ DREAMY STORE</a>
        <div class="icons">
            @auth <a href="{{ route('cart') }}" class="icon-btn">🛒</a> @endauth
        </div>
    </header>

    <div class="container">
        <a href="{{ route('home') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali Belanja
        </a>

        <div class="profile-header">
            @if($user->foto_profil)
                <img src="{{ asset('storage/' . $user->foto_profil) }}" class="avatar-large" id="main-avatar">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=9FA8DA&color=fff" class="avatar-large">
            @endif
            <h2 class="text-2xl font-bold text-gray-800">{{ $user->username }}</h2>
            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
        </div>

        <div class="mb-10">
            <h3 class="section-title"><i class="fas fa-user-edit text-indigo-500"></i> Pengaturan Akun</h3>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="text-[11px] font-bold text-gray-400 uppercase">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full mt-1 p-3 bg-gray-50 rounded-lg border border-gray-200 outline-none focus:border-indigo-400 transition">
                </div>
                <div>
                    <label class="text-[11px] font-bold text-gray-400 uppercase">Foto Profil</label>
                    <input type="file" name="avatar" onchange="previewImage(event)" class="w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700">
                </div>
                <button type="submit" class="btn-update">Simpan Perubahan</button>
            </form>
        </div>

        <div>
            <h3 class="section-title"><i class="fas fa-history text-indigo-500"></i> Riwayat Pesanan</h3>
            @forelse($orders as $order)
                @php
                    $statusText = strtoupper($order->status_pesanan ?? 'PERMINTAAN');
                    $statusClass = match($statusText) {
                        'PERMINTAAN' => 'status-permintaan',
                        'DIPROSES'   => 'status-diproses',
                        'DIKIRIM'    => 'status-dikirim',
                        'SELESAI'    => 'status-selesai',
                        'DIBATALKAN' => 'status-dibatalkan',
                        default      => 'status-permintaan',
                    };
                @endphp
                <div class="order-card">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-base font-bold text-gray-700">{{ $order->created_at->format('d M Y') }}</p>
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </div>

                    <div class="space-y-4 mb-4 border-t border-b border-gray-50 py-4">
                        @foreach($order->details as $detail)
                            <div class="flex justify-between items-center text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden border border-gray-100 bg-gray-50 flex-shrink-0">
                                        @if($detail->photocard && $detail->photocard->foto_pc)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($detail->photocard->foto_pc) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-700">{{ $detail->photocard->nama_pc ?? 'Photocard' }}</p>
                                        <p class="text-gray-400 text-xs">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_per_item, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-600">Rp {{ number_format($detail->jumlah * $detail->harga_per_item, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if($order->nomor_resi)
                        <div class="mb-4 p-2 bg-indigo-50 rounded-lg flex items-center gap-2 border border-indigo-100">
                            <i class="fas fa-shipping-fast text-indigo-500 text-xs"></i>
                            <p class="text-[11px] text-indigo-700 font-medium">Resi: <b>{{ $order->nomor_resi }}</b></p>
                        </div>
                    @endif

                    <div class="flex justify-between items-center">
                        <p class="text-xs text-gray-400 font-bold uppercase">Total Pembayaran</p>
                        <p class="text-xl font-bold text-[#5865D9]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed text-gray-400 text-sm">Belum ada pesanan.</div>
            @endforelse
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-signout" onclick="return confirm('Yakin ingin keluar?')">Keluar Akun</button>
        </form>
    </div>

    <footer style="background: linear-gradient(135deg, #9FA8DA, #B39DDB); padding: 40px 20px; text-align: center; color: white; margin-top: 50px;">
        <div style="font-weight: bold; font-size: 1.1rem; margin-bottom: 10px;">✨ DREAMY STORE</div>
        <div style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px; font-size: 12px; opacity: 0.8;">&copy; 2025 Dreamy Store Official. Made with Deliberate Effort.</div>
    </footer>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){ document.getElementById('main-avatar').src = reader.result; }
            reader.readAsDataURL(event.target.files[0]);
        }
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#5865D9' });
        @endif
    </script>
</body>
</html>