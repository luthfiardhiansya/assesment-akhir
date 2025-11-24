@extends('layouts.dasboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('supplier') }}</span>
                    <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>

                <div class="card-body">
                    <h4 class="fw-bold">{{ $supplier->nama_supplier }}</h4>
                    <p class="mt-2 mb-1">Alamat: <strong>{{ $supplier->alamat }}</strong></p>
                    <p class="mt-2 mb-1">Nomor Handphone: <strong>{{ $supplier->telepon }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection