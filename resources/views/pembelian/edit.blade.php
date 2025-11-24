@extends('layouts.dasboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Pembelian</h5>
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

            <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode Transaksi</label>
                    <input type="text" class="form-control" value="{{ $pembelian->transaksi->kode_transaksi }}" readonly>
                    <input type="hidden" name="id_transaksi" value="{{ $pembelian->transaksi->id }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Supplier</label>
                    <input type="text" class="form-control" value="{{ $pembelian->transaksi->supplier->nama }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="text" id="total_harga" class="form-control" value="Rp{{ number_format($pembelian->transaksi->total_harga, 0, ',', '.') }}" readonly>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="form-control" value="{{ $pembelian->tanggal_bayar }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode bayar</label>
                    <select name="metode_pembayaran" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash" {{ $pembelian->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="credit" {{ $pembelian->metode_pembayaran == 'credit' ? 'selected' : '' }}>Credit</option>
                        <option value="debit" {{ $pembelian->metode_pembayaran == 'debit' ? 'selected' : '' }}>Debit</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" min="0" value="{{ $pembelian->jumlah_bayar }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kembalian</label>
                    <input type="text" name="kembalian" id="kembalian" class="form-control" value="Rp{{ number_format($pembelian->kembalian, 0, ',', '.') }}" readonly>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Update Pembelian</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalHargaInput = document.getElementById('total_harga');
        const jumlahBayarInput = document.getElementById('jumlah_bayar');
        const kembalianInput = document.getElementById('kembalian');

        jumlahBayarInput.addEventListener('input', function() {
            const total = parseInt(totalHargaInput.value.replace(/[^0-9]/g, '')) || 0;
            const bayar = parseInt(this.value) || 0;
            let kembali = bayar - total;
            if (kembali < 0) kembali = 0;
            kembalianInput.value = 'Rp' + kembali.toLocaleString('id-ID');
        });
    });

</script>
@endsection