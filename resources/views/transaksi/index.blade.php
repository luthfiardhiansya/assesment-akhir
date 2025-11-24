@extends('layouts.dasboard')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Transaksi</h3>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">+ Tambah Transaksi</a>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if($transaksi->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $no => $trx)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $trx->kode_transaksi }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y, H:i') }}</td>
                    <td>{{ $trx->supplier->nama_supplier ?? '-' }}</td>
                    <td>Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('transaksi.show', $trx->id) }}"
                            class="btn btn-outline-warning btn-sm">Show</a>
                        <a href="{{ route('transaksi.edit', $trx->id) }}"
                            class="btn btn-outline-success btn-sm">Edit</a>
                        <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin mau hapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">
        Belum ada transaksi yang tercatat.
    </div>
    @endif
</div>
@endsection