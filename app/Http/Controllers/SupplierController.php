<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index()
    {
        $supplier = Supplier::all();
        return view('supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier'       => 'required|unique:suppliers,nama_supplier,',
            'alamat'     => 'required',
            'telepon' => 'required',
        ]);

        $supplier                      = new Supplier();
        $supplier->nama_supplier       = $request->nama_supplier;
        $supplier->alamat              = $request->alamat;
        $supplier->telepon             = $request->telepon;
        $supplier->save();

        return redirect()->route('supplier.index');
    }

    public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_supplier'       => 'required',
            'alamat'              => 'required',
            'telepon'             => 'required',
        ]);

        $supplier                      = Supplier::findOrFail($id);
        $supplier->nama_supplier       = $request->nama_supplier;
        $supplier->alamat              = $request->alamat;
        $supplier->telepon             = $request->telepon;
        $supplier->save();

        return redirect()->route('supplier.index');
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('supplier.index');
    }
}
