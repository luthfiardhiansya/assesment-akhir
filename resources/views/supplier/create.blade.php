@extends('layouts.dasboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Tambah Data supplier</div>
                <div class="card-body">
                    <form action="{{ route('supplier.store') }}" method="post">
                         @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama supplier</label>
                            <input type="text" name="nama_supplier" class="form-control 
                            @error('nama_supplier') is-invalid @enderror">
                            @error('nama_supplier')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat supplier</label>
                            <input type="text" name="alamat" class="form-control 
                            @error('alamat') is-invalid @enderror">
                            @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Handphone</label>
                            <input type="varchar" name="telepon" class="form-control 
                            @error('telepon') is-invalid @enderror">
                            @error('telepon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection