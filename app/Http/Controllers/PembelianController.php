<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $pembelians = Pembelian::with('transaksi')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('transaksi', function ($q) use ($search) {
                    $q->where('kode_transaksi', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('pembelian.index', compact('pembelians', 'search'));
    }

    public function create()
    {
        return view('pembelian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_transaksi'     => 'required|exists:transaksis,id',
            'tanggal_bayar'    => 'required|date',
            'metode_pembelian' => 'required|in:cash,credit,debit',
            'jumlah_bayar'     => 'required|integer|min:0',
        ]);

        $transaksi = Transaksi::with('barangs')->findOrFail($request->id_transaksi);

        foreach ($transaksi->barangs as $brg) {
            $barang = Barang::find($brg->id);

            if ($barang) {
                $barang->stok += $brg->pivot->jumlah;
                $barang->save();
            }
        }

        $kembalian = $request->jumlah_bayar - $transaksi->total_harga;

        Pembelian::create([
            'id_transaksi'     => $transaksi->id,
            'tanggal_bayar'    => $request->tanggal_bayar,
            'metode_pembelian' => $request->metode_pembelian,
            'jumlah_bayar'     => $request->jumlah_bayar,
            'kembalian'        => max($kembalian, 0),
        ]);

        return redirect()->route('pembelian.index');
    }

    public function show($id)
    {
        $pembelian = Pembelian::with('transaksi.supplier')->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit($id)
    {
        $pembelian = Pembelian::with(['transaksi.supplier'])->findOrFail($id);
        return view('pembelian.edit', compact('pembelian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_transaksi'     => 'required|exists:transaksis,id',
            'tanggal_bayar'    => 'required|date',
            'metode_pembelian' => 'required|in:cash,credit,debit',
            'jumlah_bayar'     => 'required|integer|min:0',
        ]);

        $pembelian = Pembelian::findOrFail($id);
        $transaksi = Transaksi::with('barangs')->findOrFail($request->id_transaksi);


        $kembalian = $request->jumlah_bayar - $transaksi->total_harga;

        $pembelian->update([
            'id_transaksi'     => $transaksi->id,
            'tanggal_bayar'    => $request->tanggal_bayar,
            'metode_pembelian' => $request->metode_pembelian,
            'jumlah_bayar'     => $request->jumlah_bayar,
            'kembalian'        => max($kembalian, 0),
        ]);

        return redirect()->route('pembelian.index');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $transaksi = Transaksi::with('barangs')->find($pembelian->id_transaksi);

        if ($transaksi) {
            foreach ($transaksi->barangs as $brg) {
                $barang = Barang::find($brg->id);

                if ($barang) {
                    $barang->stok -= $brg->pivot->jumlah;
                    $barang->save();
                }
            }
        }

        $pembelian->delete();

        return redirect()->route('pembelian.index');
    }
}
