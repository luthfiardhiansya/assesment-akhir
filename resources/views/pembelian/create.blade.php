    @extends('layouts.dasboard')

    @section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Pembelian</h5>
                <a href="{{ route('pembelian.index') }}" class="btn btn-light btn-sm">Kembali</a>
            </div>

            <div class="card-body">
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

                <form action="{{ route('pembelian.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cari Kode Transaksi</label>
                        <input type="text" id="searchTransaksi" class="form-control" placeholder="Ketik kode transaksi...">
                        <ul id="searchResult" class="list-group mt-1" style="display: none;"></ul>
                    </div>

                    <div id="transaksiInfo" style="display:none;">
                        <input type="hidden" name="id_transaksi" id="id_transaksi">

                        <div class="mb-3">
                            <label class="form-label">Kode Transaksi</label>
                            <input type="text" id="kode_transaksi" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" id="nama_supplier" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" id="total_harga" class="form-control" readonly>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode bayar</label>
                        <select name="metode_pembelian" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                            <option value="debit">Debit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kembalian</label>
                        <input type="text" name="kembalian" id="kembalian" class="form-control" readonly>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan Pembelian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchTransaksi');
            const searchResult = document.getElementById('searchResult');
            const transaksiInfo = document.getElementById('transaksiInfo');
            const totalHargaInput = document.getElementById('total_harga');
            const jumlahBayarInput = document.getElementById('jumlah_bayar');
            const kembalianInput = document.getElementById('kembalian');
            const idTransaksiInput = document.getElementById('id_transaksi');

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length < 2) {
                    searchResult.style.display = 'none';
                    return;
                }

                fetch(`/transaks/search?query=${query}`)
                    .then(res => res.json())
                    .then(data => {
                        searchResult.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const li = document.createElement('li');
                                li.classList.add('list-group-item', 'list-group-item-action');
                                li.textContent = `${item.kode_transaksi} - ${item.supplier_nama} (Rp${parseInt(item.total_harga).toLocaleString('id-ID')})`;
                                li.addEventListener('click', () => {
                                    idTransaksiInput.value = item.id;
                                    document.getElementById('kode_transaksi').value = item.kode_transaksi;
                                    document.getElementById('nama_supplier').value = item.supplier_nama;
                                    totalHargaInput.value = 'Rp' + parseInt(item.total_harga).toLocaleString('id-ID');

                                    transaksiInfo.style.display = 'block';
                                    searchResult.style.display = 'none';
                                    searchInput.value = '';
                                });
                                searchResult.appendChild(li);
                            });
                            searchResult.style.display = 'block';
                        } else {
                            searchResult.style.display = 'none';
                        }
                    })
                    .catch(() => {
                        searchResult.style.display = 'none';
                    });
            });

            jumlahBayarInput.addEventListener('input', function() {
                const total = parseInt(totalHargaInput.value.replace(/[^0-9]/g, '')) || 0;
                const bayar = parseInt(this.value) || 0;
                let kembali = bayar - total;
                if (kembali < 0) kembali = 0;
                kembalianInput.value = 'Rp' + kembali.toLocaleString('id-ID');
            });

            document.querySelector('form').addEventListener('submit', function(e) {
                if (!idTransaksiInput.value) {
                    e.preventDefault();
                    alert('Silakan pilih transaksi terlebih dahulu!');
                }
            });
        }); 

    </script>
    @endsection