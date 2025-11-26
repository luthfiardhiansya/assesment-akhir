@extends('layouts.dasboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Transaksi</h5>
            <a href="{{ route('transaksi.index') }}" class="btn btn-light btn-sm">Kembali</a>
        </div>

        <div class="card-body">

            {{-- Informasi Transaksi --}}
            <h6 class="fw-bold mb-3">Informasi Transaksi</h6>
            <table class="table table-sm table-bordered mb-4">
                <tr>
                    <th>Kode Transaksi</th>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Supplier</th>
                    <td>{{ $transaksi->supplier->nama_supplier ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>

            <h6 class="fw-bold mb-3">Detail Kompenen</h6>
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Kompenen</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->barangs as $brg)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $brg->kategori->nama_kategori }}</td>
                        <td>{{ $brg->nama_barang }}</td>
                        <td>Rp {{ number_format($brg->harga, 0, ',', '.') }}</td>
                        <td>{{ $brg->pivot->jumlah }}</td>
                        <td>Rp {{ number_format($brg->pivot->sub_total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="5" class="text-end">Total</th>
                        <th>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection