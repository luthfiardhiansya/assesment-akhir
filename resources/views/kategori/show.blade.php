@extends('layouts.dasboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('kategori') }}</span>
                    <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>

                <div class="card-body">
                    <h4 class="fw-bold">{{ $kategori->nama_kategori }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection