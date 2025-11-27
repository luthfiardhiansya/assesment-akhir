<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
     public function index()
    {
        $barang = Barang::with('kategori')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('barang.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'       => 'required|unique:barangs,nama_barang',
            'stok'              => 'required',
            'id_kategori'       => 'exists:kategoris,id',
            'harga'              => 'required'
        ]);

        $barang                      = new Barang();
        $barang->nama_barang       = $request->nama_barang;
        $barang->stok              = $request->stok;
        $barang->id_kategori       = $request->id_kategori;
        $barang->harga             = $request->harga;
        $barang->save();

        return redirect()->route('barang.index');
    }

    public function show(string $id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all();
        return view('barang.edit', compact('barang','kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_barang'       => 'required',
            'stok'              => 'required',
            'id_kategori'       => 'exists:kategoris,id',
            'harga'              => 'required'
        ]);

        $barang                    = Barang::findOrFail($id);
        $barang->nama_barang       = $request->nama_barang;
        $barang->stok              = $request->stok;
        $barang->id_kategori       = $request->id_kategori;
        $barang->harga             = $request->harga;
        $barang->save();

        return redirect()->route('barang.index');
    }

    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index'); 
    }
}
