<?php

namespace App\Http\Controllers\pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();

        // Membuat identity Kode barang
        $identity_barang = 'P';
        $random_number = random_int(1000, 9999);

        $kode_barang = $identity_barang . '-' . $random_number;

        return view('pimpinan.barang.barang', compact('barang', 'kode_barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_barang' => 'required|unique:users,username|min:3|max:12',
                'photo' => 'mimes:jpg,jpeg,png|max:1024',
                'nama_barang' => 'required',
                'stok' => 'required',
                'harga' => 'required',
                'satuan' => 'required',
            ],
            [
                'kode_barang.required' => 'Wajib diisi.',
                'kode_barang.unique' => 'Username ini ini sudah ada. Masukkan kode lain atau lihat data user yang telah dinonaktifkan.',
                'kode_barang.min' => 'Minimal 4 karakter Angka.',
                'kode_barang.max' => 'Maksimal 12 karakter Angka.',
                'nama_barang.required' => 'Wajib diisi.',
                'stok.required' => 'Wajib diisi.',
                'harga.required' => 'Wajib diisi.',
                'satuan.required' => 'Wajib diisi.',
                'photo.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'photo.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/pimpinan/barang')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // if ($file == "") {
        //     $fileName = "default.jpg";
        // } else {
        //     $photo = $request->file('avatar_pimpinan');
        //     $fileName = $request->username_admin . '.' . $photo->getClientOriginalExtension();
        //     $file->move(public_path('/avatar'), $fileName);
        //     // $location = public_path('avatar/' . $fileName);
        // }

        $data = $request->all();

        // Save foto
        $barang = new Barang();
        $barang->kode_barang = $request->kode_barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->satuan = $request->satuan;
        $barang->harga = $request->harga;
        $barang->stok = $request->stok;

        $file = $request->photo;
        $photo = $request->file('photo');
        $fileName = $request->kode_barang . '.' . $photo->getClientOriginalExtension();
        $file->move(public_path('/barang'), $fileName);

        $barang->barang_url = $fileName;
        $barang->created_at = $created_at;
        $barang->updated_at = $updated_at;
        $barang->save();

        return redirect()->route('crud-barang')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        //
    }
}
