@extends('layouts.dasboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detail Barang') }}</span>
                    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>

                <div class="card-body">
                    <h4 class="fw-bold">{{ $barang->nama_barang }}</h4>
                    <p class="mt-2 mb-1">Harga: <strong>Rp{{ number_format($barang->harga, 0, ',', '.') }}</strong></p>
                    <p class="mt-2">{!! $barang->deskripsi !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection