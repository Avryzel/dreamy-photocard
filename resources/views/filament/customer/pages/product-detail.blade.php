<x-filament-panels::page>
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        
        <div style="display: flex; gap: 40px; flex-wrap: wrap;">
            
            <div style="flex: 1; min-width: 300px;">
                <div style="border-radius: 12px; overflow: hidden; border: 1px solid #eee; position: relative;">
                    @if($product->foto_pc)
                        <img src="{{ asset('storage/' . $product->foto_pc) }}" 
                             alt="{{ $product->nama_pc }}"
                             style="width: 100%; height: auto; display: block; object-fit: cover;">
                    @else
                        <div style="height: 300px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            No Image
                        </div>
                    @endif
                </div>
            </div>

            <div style="flex: 1; min-width: 300px;">
                
                <span style="background: #e0e7ff; color: #4338ca; padding: 5px 12px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                    {{ $product->groupBand->nama_group ?? 'K-POP' }}
                </span>

                <h1 style="font-size: 2rem; font-weight: bold; margin-top: 15px; margin-bottom: 10px; color: #1f2937;">
                    {{ $product->nama_pc }}
                </h1>

                <h2 style="font-size: 1.8rem; color: #ea580c; font-weight: bold; margin-bottom: 20px;">
                    Rp {{ number_format($product->harga_pc, 0, ',', '.') }}
                </h2>

                <div style="margin-bottom: 20px; padding: 10px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb; display: inline-block;">
                    Status: 
                    @if($product->stock_pc > 0)
                        <span style="color: green; font-weight: bold;">✅ Tersedia ({{ $product->stock_pc }} item)</span>
                    @else
                        <span style="color: red; font-weight: bold;">❌ Habis Terjual</span>
                    @endif
                </div>

                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: 1rem; font-weight: bold; color: #374151; margin-bottom: 5px;">Deskripsi:</h3>
                    <p style="color: #4b5563; line-height: 1.6;">
                        {{ $product->deskripsi_pc ?? 'Tidak ada deskripsi tambahan.' }}
                    </p>
                </div>

                <div style="display: flex; gap: 15px; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <label for="quantity" style="font-weight: 600; color: #374151;">Jumlah:</label>
                        <input type="number" 
                               id="quantity" 
                               name="quantity" 
                               value="1" 
                               min="1" 
                               max="{{ $product->stock_pc }}" 
                               style="width: 80px; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; text-align: center;">
                    </div>
                    
                    <form method="POST" action="{{ route('add-to-cart-detail') }}" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="id_photocard" value="{{ $product->idPhotocard }}">
                        <input type="hidden" name="quantity" id="form-quantity" value="1">
                        
                        <button type="submit" 
                                style="width: 100%; background: #4f46e5; color: white; padding: 14px; border-radius: 8px; border: none; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);"
                                @if($product->stock_pc <= 0) disabled style="background: #9ca3af; cursor: not-allowed;" @endif>
                            🛒 Masukkan Keranjang
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script>
        // Sync quantity input with hidden form field
        document.getElementById('quantity').addEventListener('input', function() {
            document.getElementById('form-quantity').value = this.value;
        });
    </script>
</x-filament-panels::page>