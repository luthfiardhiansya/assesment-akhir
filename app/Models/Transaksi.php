<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'id_supplier',
        'total_harga'
    ];

    // Relasi ke pelanggan
    function supplier() {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
    public function barangs()
    {
    return $this->belongsToMany(Transaksi::class, 'detail_transaksi','id_transaksi', 'id_barang')
        ->withPivot('jumlah', 'sub_total')
        ->withTimestamps();
    }
}
