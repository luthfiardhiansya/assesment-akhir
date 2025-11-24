@extends('layouts.dasboard')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Tambah Transaksi Baru</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_supplier" class="form-label ">Supplier</label>
                    <select name="id_supplier" id="id_supplier" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($supplier as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <h5>Daftar Kompenen</h5>

                <div id="barang-wrapper">
                    <div class="row barang-item mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Kompenen</label>
                            <select name="id_barang[]" class="form-select barang-select" required>
                                <option value="">-- Pilih Kompenen --</option>
                                @foreach ($barang as $brg)
                                <option value="{{ $brg->id }}" data-harga="{{ $brg->harga }}">
                                    {{ $brg->nama_barang }} - Rp{{ number_format($brg->harga, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" value="1" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control subtotal" readonly value="Rp0">
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-remove w-100">×</button>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="button" class="btn btn-sm btn-secondary" id="btn-add">+ Tambah Kompenen</button>
                </div>

                <div class="text-center mb-4">
                    <h4>Total Harga: <span id="totalHarga">Rp0</span></h4>
                </div>

                <div class="text-center ">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function hitungSubtotal() {
        let total = 0;
        document.querySelectorAll('.barang-item').forEach(item => {
            let select = item.querySelector('.barang-select');
            let jumlah = item.querySelector('.jumlah-input');
            let subtotalInput = item.querySelector('.subtotal');
            
            let harga = select.selectedOptions[0]?.getAttribute('data-harga') || 0;
            let sub = parseInt(harga) * parseInt(jumlah.value || 0);
            
            subtotalInput.value = 'Rp' + sub.toLocaleString('id-ID');
            total += sub;
        });
        
        document.getElementById('totalHarga').innerText = 'Rp' + total.toLocaleString('id-ID');
    }
    
    document.addEventListener('input', hitungSubtotal);
    document.addEventListener('change', hitungSubtotal);
    
    document.getElementById('btn-add').addEventListener('click', function() {
        let wrapper = document.getElementById('barang-wrapper');
        let newRow = wrapper.firstElementChild.cloneNode(true);
        
        newRow.querySelectorAll('input').forEach(i => i.value = i.classList.contains('jumlah-input') ? 1 : 'Rp0');
        newRow.querySelector('.barang-select').value = '';
        
        wrapper.appendChild(newRow);
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove')) {
            let items = document.querySelectorAll('.barang-item');
            if (items.length > 1) {
                e.target.closest('.barang-item').remove();
                hitungSubtotal();
            }
        }
    });
</script>
    @endsection