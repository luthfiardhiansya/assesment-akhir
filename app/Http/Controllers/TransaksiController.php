<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['supplier', 'barangs'])->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $barang  = Barang::all();
        return view('transaksi.create', compact('supplier', 'barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier'  => 'required|exists:suppliers,id',
            'id_barang'    => 'required|array',
            'id_barang.*'  => 'exists:barangs,id',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'integer|min:1',
        ]);

        $kode = 'TRX-' . strtoupper(uniqid());

        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $kode;
        $transaksi->id_supplier    = $request->id_supplier;
        $transaksi->tanggal        = now();
        $transaksi->total_harga    = 0;
        $transaksi->save();

        $totalHarga  = 0;
        $barangPivot = [];

        foreach ($request->id_barang as $index => $barangId) {
            $barang   = Barang::findOrFail($barangId);
            $jumlah   = $request->jumlah[$index];
            $subTotal = $barang->harga * $jumlah;

            $barangPivot[$barangId] = [
                'jumlah'    => $jumlah,
                'sub_total' => $subTotal,
            ];

            $totalHarga += $subTotal;
        }

        $transaksi->barangs()->attach($barangPivot);

        $transaksi->update(['total_harga' => $totalHarga]);

        return redirect()->route('transaksi.index');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['supplier', 'barangs'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('barangs')->findOrFail($id);
        $supplier  = Supplier::all();
        $barang    = Barang::all();

        return view('transaksi.edit', compact('transaksi', 'supplier', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_supplier'  => 'required|exists:suppliers,id',
            'id_barang'    => 'required|array',
            'id_barang.*'  => 'exists:barangs,id',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'integer|min:1',
        ]);

        $transaksi = Transaksi::with('barangs')->findOrFail($id);

        $transaksi->barangs()->detach();

        $transaksi->id_supplier  = $request->id_supplier;
        $transaksi->tanggal      = now();
        $transaksi->total_harga  = 0;
        $transaksi->save();

        $totalHarga  = 0;
        $barangPivot = [];

        foreach ($request->id_barang as $index => $barangId) {
            $barang   = Barang::findOrFail($barangId);
            $jumlah   = $request->jumlah[$index];
            $subTotal = $barang->harga * $jumlah;

            $barangPivot[$barangId] = [
                'jumlah'    => $jumlah,
                'sub_total' => $subTotal,
            ];


            $totalHarga += $subTotal;
        }

        $transaksi->barangs()->attach($barangPivot);

        $transaksi->update(['total_harga' => $totalHarga]);

        return redirect()->route('transaksi.index');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::with('barangs')->findOrFail($id);

        $transaksi->barangs()->detach();

        $transaksi->delete();

        return redirect()->route('transaksi.index');
    }

    public function search(Request $request)
    {
        $query     = $request->query('query');
        $transaksi = Transaksi::with('supplier')
            ->where('kode_transaksi', 'like', "%$query%")
            ->get();

        return response()->json(
            $transaksi->map(function ($t) {
                return [
                    'id'             => $t->id,
                    'kode_transaksi' => $t->kode_transaksi,
                    'supplier_nama'  => optional($t->supplier)->nama_supplier,
                    'total_harga'    => $t->total_harga,
                ];
            })
        );
    }
}