<?php

namespace App\Http\Controllers\pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('pimpinan.pembelian.pembelian', compact('barang'));
    }
}
