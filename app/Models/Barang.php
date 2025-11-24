<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'stok',
        'harga',
        'id_kategori',
    ];

    // Relasi ke pelanggan
    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class)->withPivot(['jumlah', 'sub_total']);
    }

}
