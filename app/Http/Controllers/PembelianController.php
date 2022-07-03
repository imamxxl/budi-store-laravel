<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Tmp;
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

    public function postPembelian(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_barang' => 'required',
                'qty' => 'required|numeric',
                'jk_pimpinan' => 'required',
                'password_pimpinan' => 'required|min:6',
                'avatar_pimpinan' => 'mimes:jpg,jpeg,png|max:1024'
            ],
            [
                'kode_barang.required' => 'Barang wajib dipilih',
                'qty.required' => 'Wajib diisi',
                'qty.numeric' => 'Wajib angka',
            ],
        );

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Barang gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }


        $tmp = new Tmp;
        $tmp->barang_id = $request->input('kode_barang');
        $tmp->quantity = $request->input('qty');
        // $tmp->grand_total = $request->input('qty');
        // $tmp->status = '0';
        // $tmp->user_id = $request->input('user_id');

        $tmp->save();

        return redirect('/')->with('pesan-sukses', 'Barang berhasil ditambahkan.');
    }
}
