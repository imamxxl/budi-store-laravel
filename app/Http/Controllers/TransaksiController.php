<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Tmp;
use App\Models\Transaksi;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TransaksiController extends Controller
{
    public function index()
    {

        $transaksi = DB::table('transaksis')
            ->get();

        $barang = Barang::all();

        $tmp = DB::table('tmps')
            // ->join('transaksis', 'tmps.transaksi_id', '=', 'transaksis.id')
            ->join('barangs', 'barangs.id', '=', 'tmps.barang_id')
            ->groupBy('barang_id')
            ->get();

        $hitung_barang = DB::table('tmps')
            ->join('barangs', 'barangs.id', '=', 'tmps.barang_id')
            ->pluck('quantity');

        // dd($hitung_barang);

        $invoice = 'T-' . random_int(100000000000000, 999999999999999);

        $hitung_transaksi = DB::table('transaksis')
            ->where('status', '0')
            ->where('user_id', Auth::user()->id)
            ->count();

        if ($hitung_transaksi != null) {
            return view('page.transaksi.transaksi', compact('transaksi', 'tmp', 'barang'));
        } else {
            return view('page.transaksi.tambah-transaksi', compact('transaksi', 'invoice', 'hitung_transaksi'));
        }
    }

    public function postBelanja(Request $request)
    {
        $transaksi = new Transaksi;
        $transaksi->invoice = $request->input('invoice');
        $transaksi->tanggal = $request->input('tanggal');
        $transaksi->status = '0';
        $transaksi->user_id = $request->input('user_id');

        $transaksi->save();

        return view('page.transaksi.transaksi', compact('transaksi'));
    }

    public function postPembelian(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_barang' => 'required',
                'qty' => 'required|numeric',
            ],
            [
                'kode_barang.required' => 'Barang wajib dipilih',
                'qty.required' => 'Wajib diisi',
                'qty.numeric' => 'Wajib angka',
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->route('transaksi')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Barang gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // Deteksi kode barang
        $kode_barang = $request->input('kode_barang');

        // Deteksi quantity
        $quantity = $request->input('qty');


        // Deteksi Invoice
        $get_invoice = DB::table('transaksis')
            ->where('user_id', Auth::user()->id)
            ->pluck('id')
            ->first();

        $cek_harga_barang = DB::table('barangs')
            ->where('id', $request->kode_barang)
            ->pluck('harga')
            ->first();

        // Cek barang di database apakah ada atau tidak
        $cek_barang_db = DB::table('tmps')
            ->where('barang_id', $kode_barang)
            ->count();

        // Cek jumlah barang yang sudah ada di db
        $cek_qty_db = DB::table('tmps')
            ->join('barangs', 'barangs.id', '=', 'tmps.barang_id')
            ->where('barang_id', $kode_barang)
            ->pluck('quantity')
            ->first();

        // cek total jumlah  barang yang dibeli
        $sub_total = $cek_harga_barang * $cek_qty_db;

        // cek jumlah barang supaya discount
        if ($cek_qty_db >= 10) {
            $discount = $sub_total * 5 / 100;
        } else {
            $discount = 0;
        }

        // Jika barang belum pernah ditambahkan
        if ($cek_barang_db == '0') {
            $tmp = new Tmp;
            $tmp->barang_id = $request->kode_barang;
            $tmp->quantity = $quantity;
            $tmp->transaksi_id = $get_invoice;
            $tmp->discount = $discount;
            $tmp->save();

            return redirect()->route('transaksi')->with('pesan-sukses', 'Barang berhasil ditambahkan.');
        }

        // Jika barang sudah pernah ditambahkan 
        else {
            // Mengganti qty barang
            $tambah_quantity = $cek_qty_db + $quantity;

            DB::table('tmps')
                ->where('barang_id', $kode_barang)
                ->update(
                    ['quantity' => $tambah_quantity],
                    ['discount' => $discount]
                );

            return redirect()->route('transaksi')->with('pesan-sukses', 'Barang berhasil ditambahkan.');
        }
    }
}
