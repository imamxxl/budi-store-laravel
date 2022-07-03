<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{

    public function index()
    {
        $barang = Barang::all();

        // membuat identitas barang
        $identity_barang = 'P';
        $random_number = random_int(1000, 9999);

        $kode_barang = $identity_barang . '-' . $random_number;

        return view('page.barang.barang', compact('barang', 'kode_barang'));
    }

    function indexRecycle()
    {
        $barang = Barang::onlyTrashed()->get();
        return view('page.barang.recycle-barang', compact('barang'));
    }

    public function postBarang(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_barang' => 'required|unique:barangs|min:3|max:12',
                'photo' => 'required|mimes:jpg,jpeg,png|max:1024',
                'nama_barang' => 'required',
                'stok' => 'numeric|required',
                'harga' => 'numeric|required',
                'satuan' => 'required',
            ],
            [
                'kode_barang.required' => 'Wajib diisi.',
                'kode_barang.unique' => 'Kode barang ini sudah ada. Masukkan kode lain atau lihat data user yang telah dinonaktifkan.',
                'kode_barang.min' => 'Minimal 4 karakter Angka.',
                'kode_barang.max' => 'Maksimal 12 karakter Angka.',
                'nama_barang.required' => 'Wajib diisi.',
                'stok.required' => 'Wajib diisi.',
                'stok.numeric' => 'Harus angka.',
                'harga.numeric' => 'Harus angka.',
                'harga.required' => 'Wajib diisi.',
                'satuan.required' => 'Wajib diisi.',
                'photo.required' => 'Foto wajib ada.',
                'photo.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'photo.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->route('semua-barang')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $data = $request->all();

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

        return redirect()->route('semua-barang')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'edit_photo' => 'mimes:jpg,jpeg,png|max:1024',
                'edit_nama_barang' => 'required',
                'edit_harga' => 'numeric|required',
                'edit_satuan' => 'required',
            ],
            [
                'edit_nama_barang.required' => 'Wajib diisi.',
                'edit_harga.required' => 'Wajib diisi.',
                'edit_satuan.required' => 'Wajib diisi.',
                'edit_harga.numeric' => 'Harus angka.',
                'edit_photo.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'edit_photo.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->route('semua-barang')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal diupdate. Mohon cek kembali data yang ingin diupdate!');
        }

        $updated_at = date('Y-m-d H:i:s');

        $barang = new Barang();
        $barang = Barang::find($id);
        $barang->nama_barang = $request->edit_nama_barang;
        $barang->harga = $request->edit_harga;
        $barang->satuan = $request->edit_satuan;

        $barang->updated_at = $updated_at;

        if ($request->hasFile('edit_photo')) {
            $photo = $request->file('edit_photo');
            $filename = $request->barang_url . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('/barang'), $filename);
            $barang->barang_url = $filename;

            $oldFilename = $barang->avatar;
            $barang->barang_url = $filename;
            Storage::delete($oldFilename);
        }

        $barang->save();

        return redirect()->route('semua-barang')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    public function postStok(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tambah_stok' => 'required|numeric',
                'stok_tersedia' => 'required'
            ],
            [
                'tambah_stok.required' => 'Wajib diisi.',
                'tambah_stok.numeric' => 'Harus angka.',
                'stok_tersedia.required' => 'Wajib diisi'
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->route('semua-barang')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambah. Mohon cek kembali data yang ingin ditambahkan!');
        }

        $barang = new Barang();
        $barang = Barang::find($id);

        $stok_awal = $request->stok_tersedia;
        $stok_tambahan = $request->tambah_stok;

        $stok_akhir = $stok_awal + $stok_tambahan;

        $barang->stok = $stok_akhir;
        $barang->save();

        return redirect()->route('semua-barang')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    public function restore($id)
    {
        $barang = Barang::onlyTrashed()->where('id', $id);
        $barang->restore();
        
        return redirect()->route('recycle-barang')->with('pesan-sukses', 'Data berhasil direstore.');
    }

    public function destroy($id)
    {
        // hapus permanen data barang
        $barang = Barang::onlyTrashed()->where('id', $id);
        $barang->forceDelete();

        return redirect()->route('recycle-barang')->with('pesan-sukses', 'Data berhasil dihapus permanen.');
    }

    public function delete($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect()->route('semua-barang')->with('pesan-sukses', 'Data berhasil dihapus.');
    }
}
