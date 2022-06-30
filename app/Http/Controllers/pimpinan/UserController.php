<?php

namespace App\Http\Controllers\pimpinan;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {

        $user = DB::table('users')->get();

        // making user unique
        $identity_admin = 'ADM';
        $identity_pimpinan = 'PP';
        $random_number = random_int(100, 222);

        $admin = $identity_admin . $random_number;
        $pimpinan = $identity_pimpinan . $random_number;

        return view('pimpinan.user.user', compact('pimpinan', 'admin', 'user'));
    }

    public function storePimpinan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username_pimpinan' => 'required|unique:users,username|min:3|max:12',
                'nama_pimpinan' => 'required',
                'jk_pimpinan' => 'required',
                'password_pimpinan' => 'required|min:6',
                'avatar_pimpinan' => 'mimes:jpg,jpeg,png|max:1024'
            ],
            [
                'username_pimpinan.required' => 'Wajib diisi.',
                'username_pimpinan.unique' => 'Username ini ini sudah ada. Masukkan kode lain atau lihat data user yang telah dinonaktifkan.',
                'username_pimpinan.min' => 'Minimal 4 karakter Angka.',
                'username_pimpinan.max' => 'Maksimal 12 karakter Angka.',
                'nama_pimpinan.required' => 'Wajib diisi.',
                'jk_pimpinan.required' => 'Jenis kelamin harus dipilih.',
                'password_pimpinan.required' => 'Wajib diisi.',
                'password_pimpinan.min' => 'Minimal 6 karakter',
                'avatar_pimpinan.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_pimpinan.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/user')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $file = $request->avatar_admin;
        if ($file == "") {
            $fileName = "default.jpg";
        } else {
            $photo = $request->file('avatar_pimpinan');
            $fileName = $request->username_admin . '.' . $photo->getClientOriginalExtension();
            $file->move(public_path('public/avatar'), $fileName);
            // $location = public_path('avatar/' . $fileName);
        }

        $data = $request->all();

        $user = new User;
        $user->username = $data['username_pimpinan'];
        $user->nama = $data['nama_pimpinan'];
        $user->jk = $request->jk_pimpinan;
        $user->password = Hash::make($request->password_pimpinan);
        $user->level = 'pimpinan';
        $user->avatar = $fileName;
        $user->created_at = $created_at;
        $user->updated_at = $updated_at;
        $user->save();

        return redirect()->route('user')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    public function storeAdmin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username_admin' => 'required|unique:users,username|min:3|max:12',
                'nama_admin' => 'required',
                'jk_admin' => 'required',
                'password_admin' => 'required|min:6',
                'avatar_admin' => 'mimes:jpg,jpeg,png|max:1024'
            ],
            [
                'username_admin.required' => 'Wajib diisi.',
                'username_admin.unique' => 'Username ini ini sudah ada. Masukkan kode lain atau lihat data user yang telah dinonaktifkan.',
                'username_admin.min' => 'Minimal 4 karakter Angka.',
                'username_admin.max' => 'Maksimal 12 karakter Angka.',
                'nama_admin.required' => 'Wajib diisi.',
                'jk_admin.required' => 'Jenis kelamin harus dipilih.',
                'password_admin.required' => 'Wajib diisi.',
                'password_admin.min' => 'Minimal 6 karakter',
                'avatar_admin.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_admin.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/user')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $file = $request->avatar_admin;
        if ($file == "") {
            $fileName = "default.jpg";
        } else {
            $photo = $request->file('avatar_admin');
            $fileName = $request->username_admin . '.' . $photo->getClientOriginalExtension();
            $file->move(public_path('public/avatar'), $fileName);
            // $location = public_path('avatar/' . $fileName);
        }

        $data = $request->all();

        $user = new User;
        $user->username = $data['username_admin'];
        $user->nama = $data['nama_admin'];
        $user->jk = $request->jk_admin;
        $user->password = Hash::make($request->password_admin);
        $user->level = 'admin';
        $user->avatar = $fileName;
        $user->created_at = $created_at;
        $user->updated_at = $updated_at;
        $user->save();

        return redirect()->route('user')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request) {

    }

    function destroy($id)
    {
        $nonaktif = "0";

        $user = User::find($id);
        $user->status = $nonaktif;

        $user->update();

        return redirect()->route('user')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data User Nonaktif" untuk melihat Data yang telah dinonaktifkan.');
    }
}
