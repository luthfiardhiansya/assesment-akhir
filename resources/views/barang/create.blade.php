@extends('layouts.dasboard')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Tambah Data Kompenen</div>
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="post">
                         @csrf

                        <div class="mb-3">
                            <label for="id_kategori" class="form-label ">Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                    </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Kompenen</label>
                            <input type="text" name="nama_barang" class="form-control 
                            @error('nama_barang') is-invalid @enderror">
                            @error('nama_barang')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Kompenen</label>
                            <input type="text" name="harga" class="form-control 
                            @error('harga') is-invalid @enderror">
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok </label>
                            <input type="varchar" name="stok" class="form-control 
                            @error('stok') is-invalid @enderror">
                            @error('stok')
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