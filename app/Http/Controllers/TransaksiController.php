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

        // Deteksi Transaksi
        $transaksi_id = DB::table('transaksis')
            ->where('user_id', Auth::user()->id)
            ->pluck('id')
            ->first();

        // Deteksi kode barang
        $kode_barang = $request->input('kode_barang');

        // Deteksi quantity
        $quantity = $request->input('qty');

        // Deteksi Invoice
        $get_invoice = DB::table('transaksis')
            ->where('user_id', Auth::user()->id)
            ->where('id', $transaksi_id)
            ->pluck('id')
            ->first();

        $cek_harga_barang = DB::table('barangs')
            ->where('id', $request->kode_barang)
            ->pluck('harga')
            ->first();

        // Cek barang di database apakah ada atau tidak
        $cek_barang_db = DB::table('tmps')
            ->where('transaksi_id', $transaksi_id)
            ->where('barang_id', $kode_barang)
            ->count();

        // Cek jumlah barang yang sudah ada di db
        $cek_qty_db = DB::table('tmps')
            ->join('barangs', 'barangs.id', '=', 'tmps.barang_id')
            ->where('barang_id', $kode_barang)
            ->where('transaksi_id', $transaksi_id)
            ->pluck('quantity')
            ->first();

        if ($cek_qty_db == 0) {
            $sub_total = $cek_harga_barang * $quantity;
            $c_total_harga = $quantity * $cek_harga_barang;
        } else {
            // cek total jumlah  barang yang dibeli
            $sub_total = $cek_harga_barang * ($cek_qty_db + $quantity);
            $c_total_harga = ($quantity + $cek_qty_db) * $cek_harga_barang ;
        }

        $jumlah = $cek_harga_barang * ($cek_qty_db + $quantity);

        // cek jumlah barang supaya discount
        if ($cek_qty_db >= 9) {
            $discount = $sub_total * 0.05;
        } else {
            $discount = 0;
        }

        // total belanja dikurangi diskon
        $total = ($sub_total - $discount);

        // Mengambil array jumlah barang pembelian
        $total_barang_pembelian = DB::table('tmps')
            ->join('barangs', 'barangs.id', '=', 'tmps.barang_id')
            ->where('transaksi_id', $transaksi_id)
            ->pluck('total');

        // Mengambil array jumlah discount pembelian
        $total_discount_pembelian = DB::table('tmps')
            ->join('barangs', 'barangs.id', '=', 'tmps.barang_id')
            ->where('transaksi_id', $transaksi_id)
            ->pluck('discount');

        // Mengambil array harga pembelian
        $total_harga_pembelian = DB::table('tmps')
            ->join('barangs', 'barangs.id', '=', 'tmps.barang_id')
            ->where('transaksi_id', $transaksi_id)
            ->pluck('jumlah');

        // Jika barang belum pernah ditambahkan
        if ($cek_barang_db == '0') {
            // Menyimpan ke tabel tmp
            $tmp = new Tmp;
            $tmp->barang_id = $request->kode_barang;
            $tmp->quantity = $quantity;
            $tmp->jumlah = $jumlah;
            $tmp->discount = $discount;
            $tmp->total = $total;
            $tmp->transaksi_id = $get_invoice;
            $tmp->save();


            DB::table('transaksis')
                ->where('id', $transaksi_id)
                ->update(
                    ['sub_total' => $c_total_harga]
                );

            return redirect()->route('transaksi')->with('pesan-sukses', 'Barang berhasil ditambahkan.');
        }

        // Jika barang sudah pernah ditambahkan 
        else {

            // Mengganti qty barang
            $tambah_quantity = $cek_qty_db + $quantity;

            DB::table('tmps')
                ->where('barang_id', $kode_barang)
                ->where('transaksi_id', $transaksi_id)
                ->update(
                    ['quantity' => $tambah_quantity, 'jumlah' => $jumlah, 'discount' => $discount, 'total' => $total]
                );

            // menghitung total semua array
            $c_total_harga = ($total_harga_pembelian)->sum() + ($quantity * $cek_harga_barang);
            $c_total_discount = ($total_discount_pembelian)->sum() + ($quantity * $cek_harga_barang);
            $c_total_barang = ($total_barang_pembelian)->sum() + ($quantity * $cek_harga_barang);

            // Potongan discount
            $c_grand_total = $c_total_barang
                - $c_total_discount;


            DB::table('transaksis')
                ->where('id', $transaksi_id)
                ->update(
                    ['sub_total' => $c_total_harga, 'total_discount' => $c_total_discount, 'grand_total' => $c_grand_total]
                );

            return redirect()->route('transaksi')->with('pesan-sukses', 'Barang berhasil ditambahkan.');
        }
    }
}
