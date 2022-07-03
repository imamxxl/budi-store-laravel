<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('page.pembelian.pembelian', compact('barang'));
    }

    public function beli(Request $request, $id)
    {
        $beli = new Pembelian;

        $beli->barang_id = $id;
        $beli->quantity = $request->qty;
        $beli->jmlh_bayar = $request->total_biaya;
        $beli->save();

        return redirect()->route('pembelian')->with('pesan-sukses', 'Item berhasil ditambahkan ke checkout');
    }
}
