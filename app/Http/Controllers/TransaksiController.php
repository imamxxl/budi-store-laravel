<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index() {
        $transaksi = Transaksi::all();

        return view('page.transaksi.semua-transaksi', compact('transaksi'));
    }

    public function pilihTransaksi()
    {
        $barang = Barang::all();

        return view('page.transaksi.transaksi', compact('barang'));
    }
}
