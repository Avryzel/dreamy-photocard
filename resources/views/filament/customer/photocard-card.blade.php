<div style="
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,.1);
    transition: .3s;
    height: 100%;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    position: relative;
    border: 1px solid #eee;
" 
onmouseover="this.style.transform='translateY(-8px)'" 
onmouseout="this.style.transform='translateY(0)'">

    <div style="height: 220px; overflow: hidden; position: relative; background-color: #f0f0f0;">
        @if ($getRecord()->foto_pc)
            <img src="{{ asset('storage/' . $getRecord()->foto_pc) }}" 
                 alt="{{ $getRecord()->nama_pc }}" 
                 style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #999;">
                No Image
            </div>
        @endif

        <div style="
            position: absolute; 
            top: 10px; 
            right: 10px; 
            background: rgba(255,255,255,0.95); 
            padding: 4px 10px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: {{ $getRecord()->stock_pc > 0 ? '#2e7d32' : '#c62828' }};
        ">
            Stok: {{ $getRecord()->stock_pc }}
        </div>
    </div>

    <div style="padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
        
        <div>
            <div style="font-size: 14px; color: #666; margin-bottom: 6px; line-height: 1.4; text-transform: uppercase; letter-spacing: 0.5px;">
                {{ $getRecord()->nama_pc }}
            </div>
            
            <div style="font-size: 18px; font-weight: bold; color: #333;">
                Rp {{ number_format($getRecord()->harga_pc, 0, ',', '.') }}
            </div>
        </div>

        <div style="margin-top: 15px;">
             <button style="
                width: 100%; 
                background: linear-gradient(135deg,#9FA8DA,#B39DDB); 
                color: white; 
                border: none; 
                padding: 10px; 
                border-radius: 20px; 
                font-weight: bold; 
                cursor: pointer;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
             ">
                Lihat Detail
             </button>
        </div>
    </div>

</div>