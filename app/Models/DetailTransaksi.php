<?php

class DetailTransaksi extends Model
{
    protected $fillable = ['id_transaksi', 'id_barang', 'jumlah', 'subtotal'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
