<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'admin', 'middleware'=>['auth']],function(){
    Route::get('/',function(){
        return view('admin.index');
    });
});

    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('barang', App\Http\Controllers\BarangController::class);
    Route::resource('supplier', App\Http\Controllers\SupplierController::class);
    Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);
    Route::resource('pembelian', App\Http\Controllers\PembelianController::class);

    
    
Auth::routes();
