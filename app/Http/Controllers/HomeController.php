<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // ← tambahkan ini

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    $barang = \App\Models\Barang::with('kategori')->get();

    return view('home', compact('barang'));
        }

}
