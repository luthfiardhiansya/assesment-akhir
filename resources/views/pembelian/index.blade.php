@extends('layouts.dasboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Pembelian</h5>
            <a href="{{ route('pembelian.create') }}" class="btn btn-light btn-sm">+ Tambah Pembelian</a>
        </div>

        <div class="card-body">
            <form action="{{ route('pembelian.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari kode transaksi..." value="{{ $search }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                    @if($search)
                    <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Supplier</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode</th>
                            <th>Jumlah Bayar</th>
                            <th>Kembalian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembelians as $pembelian)
                        <tr>
                            <td>{{ $loop->iteration + ($pembelians->currentPage() - 1) * $pembelians->perPage() }}</td>
                            <td>{{ $pembelian->transaksi->kode_transaksi ?? '-' }}</td>
                            <td>{{ $pembelian->transaksi->supplier->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_bayar)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $pembelian->metode_pembayaran == 'cash' ? 'success' : ($pembelian->metode_pembayaran == 'credit' ? 'warning' : 'info') }}">
                                    {{ ucfirst($pembelian->metode_pembayaran) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pembelian->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pembelian->kembalian, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-sm btn-info text-white">
                                    Show
                                </a>
                                <a href="{{ route('pembelian.edit', $pembelian->id) }}" class="btn btn-sm btn-warning text-white">
                                    Edit
                                </a>
                                <form action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data pembelian</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pembelians->links() }}
            </div>
        </div>
    </div>
</div>

@endsection