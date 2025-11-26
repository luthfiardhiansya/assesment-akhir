@extends('layouts.dasboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4>Detail Pembelian</h4>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Informasi Pembelian</h5>
            <table class="table table-bordered">
                <tr>
                    <th>ID Pembelian</th>
                    <td>{{ $pembelian->id }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembelian</th>
                    <td>{{ $pembelian->tanggal_bayar }}</td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <td>Rp {{ number_format($pembelian->transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Uang Diterima</th>
                    <td>Rp {{ number_format($pembelian->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kembalian</th>
                    <td>Rp {{ number_format($pembelian->kembalian, 0, ',', '.') }}</td>
                </tr>
            </table>

            <h5 class="mt-4 mb-3">Informasi Transaksi</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Kode Transaksi</th>
                    <td>{{ $pembelian->transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>{{ $pembelian->transaksi->tanggal }}</td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td>Rp {{ number_format($pembelian->transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>

            <h5 class="mt-4 mb-3">Detail Kompenen</h5>
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Kompenen</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian->transaksi->barangs as $index => $barang)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barang->kategori->nama_kategori }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>{{ $barang->pivot->jumlah }}</td>
                        <td>Rp {{ number_format($barang->pivot->sub_total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="mt-4 mb-3">Data Supplier</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Nama Supplier</th>
                    <td>{{ $pembelian->transaksi->supplier->nama_supplier }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $pembelian->transaksi->supplier->alamat }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection