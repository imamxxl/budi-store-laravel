@extends('layout.template')

@section('title')
    User | Budi Store
@endsection

@section('judul-halaman')
    User
@endsection

@section('navigasi-satu')
    User
@endsection

@section('bagian-nav')
    @include('layout.nav')
@endsection

@section('isi-konten')
    @if (session('pesan-sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses </h4>
            {{ session('pesan-sukses') }}
        </div>
    @endif
    @if (session('pesan-gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Gagal </h4>
            {{ session('pesan-gagal') }}
        </div>
    @endif
    @if (session('password-sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses </h4>
            {{ session('password-sukses') }}
        </div>
    @endif
    @if (session('password-gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Gagal </h4>
            {{ session('password-gagal') }}
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title center">Data User</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <button type="button" class="btn btn-lg btn-success fa fa-plus" data-toggle="modal"
                        data-target="#modal-tambah-pimpinan">
                        Tambah User Pimpinan
                    </button>
                    <button type="button" class="btn btn-lg btn-primary fa fa-plus" data-toggle="modal"
                        data-target="#modal-tambah-admin">
                        Tambah User Admin
                    </button>
                    <a href="{{ route('recycle-user') }}" class="btn btn-lg btn-default fa fa-trash"> Tong Sampah </a>
                </div>


                <div class="card-body box-body table-hover">

                    <!-- Table Users -->
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($user as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->jk }}</td>
                                    <!-- Level User -->
                                    @if ($data->level == 'admin')
                                        <td>
                                            <span class="badge btn-primary" id="{{ $data->level }}">Admin<span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge btn-success" id="{{ $data->level }}">Pimpinan<span>
                                        </td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modal-edit{{ $data->id }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-delete{{ $data->id }}">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal Add Pimpinan-->
                    <div class="modal fade" id="modal-tambah-pimpinan">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah User Pimpinan</h4>
                                </div>

                                <div class="modal-body">
                                    <form action=" {{ route('post-pimpinan') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Username Pimpinan</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="username_pimpinan" class="form-control"
                                                    value="{{ $pimpinan }}" placeholder="Contoh: PP526" readonly>
                                                <div class="text-danger">
                                                    @error('username_pimpinan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Pimpinan</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_pimpinan" class="form-control"
                                                    value="{{ old('nama_pimpinan') }}" placeholder="Contoh: Ahmad Imam">
                                                <div class="text-danger">
                                                    @error('nama_pimpinan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" id="jk_pimpinan" name="jk_pimpinan">
                                                    <option value="">- Pilih Jenis Kelamin -</option>
                                                    <option value="Laki-laki"
                                                        @if (old('jk_pimpinan') == 'Laki-laki') {{ 'selected' }} @endif>
                                                        Laki-laki
                                                    </option>
                                                    <option value="Perempuan"
                                                        @if (old('jk_pimpinan') == 'Perempuan') {{ 'selected' }} @endif>
                                                        Perempuan
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('jk_pimpinan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <label class="text-danger">*</label>
                                                <input type="password" name="password_pimpinan" class="form-control"
                                                    value="{{ old('password_pimpinan') }}"
                                                    placeholder="Contoh: Password123">
                                                <div class="text-danger">
                                                    @error('password_pimpinan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Admin</label>
                                                <div class="text-danger">
                                                    <p>Catatan : "Jika tidak memilih foto, maka foto akan
                                                        didefault-kan."</p>
                                                </div>
                                                <input type="file" name="avatar_pimpinan">
                                                <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                    (ukuran max: 1MB)</p>
                                                <div class="text-danger">
                                                    @error('avatar_pimpinan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-block"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success btn-block"
                                                value="submit">Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Add Admin-->
                    <div class="modal fade" id="modal-tambah-admin">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah User Admin</h4>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('post-admin') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Username Admin</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="username_admin" class="form-control"
                                                    value="{{ $admin }}" placeholder="Contoh: ADM232" readonly>
                                                <div class="text-danger">
                                                    @error('username_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Admin</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_admin" class="form-control"
                                                    value="{{ old('nama_admin') }}" placeholder="Contoh: Ahmad Imam">
                                                <div class="text-danger">
                                                    @error('nama_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" id="jk_admin" name="jk_admin">
                                                    <option value="">- Pilih Jenis Kelamin -</option>
                                                    <option value="Laki-laki"
                                                        @if (old('jk_admin') == 'Laki-laki') {{ 'selected' }} @endif>
                                                        Laki-laki
                                                    </option>
                                                    <option value="Perempuan"
                                                        @if (old('jk_admin') == 'Perempuan') {{ 'selected' }} @endif>
                                                        Perempuan
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('jk_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <label class="text-danger">*</label>
                                                <input type="password" name="password_admin" class="form-control"
                                                    value="{{ old('password_admin') }}"
                                                    placeholder="Contoh: Password123">
                                                <div class="text-danger">
                                                    @error('password_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Admin</label>
                                                <div class="text-danger">
                                                    <p>Catatan : "Jika tidak memilih foto, maka foto akan
                                                        didefault-kan."</p>
                                                </div>
                                                <input type="file" name="avatar_admin">
                                                <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                    (ukuran max: 1MB)</p>
                                                <div class="text-danger">
                                                    @error('avatar_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-block"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success btn-block"
                                                value="submit">Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal add -->
                    </div>

                    <!-- Modal Edit Data -->
                    @foreach ($user as $data)
                        <div class="modal fade" id="modal-edit{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Edit {{ $data->nama }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('update-user', $data->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="edit_username" class="form-control"
                                                        value="{{ $data->username }}" readonly>
                                                    <div class="text-danger">
                                                        @error('edit_username')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="edit_nama" class="form-control"
                                                        value="{{ $data->nama }}">
                                                    <div class="text-danger">
                                                        @error('edit_nama')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <label class="text-danger">*</label>
                                                    @if ($data->jk == 'Laki-laki')
                                                        <select name="edit_jk" class="form-control">
                                                            <option value="Laki-laki" selected>Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    @elseif($data->jk == 'Perempuan')
                                                        <select name="edit_jk" required class="form-control">
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan" selected>Perempuan
                                                            </option>
                                                        </select>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Level</label>
                                                    <label class="text-danger">*</label>
                                                    @if ($data->level == 'pimpinan')
                                                        <select name="edit_level" class="form-control">
                                                            <option value="pimpinan" selected>Pimpinan</option>
                                                            <option value="admin">Admin</option>
                                                        </select>
                                                    @elseif($data->level == 'admin')
                                                        <select name="edit_level" required class="form-control">
                                                            <option value="pimpinan">Pimpinan</option>
                                                            <option value="admin" selected>Admin
                                                            </option>
                                                        </select>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Password Baru</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="password" name="edit_password" class="form-control"
                                                        value="{{ old('edit_password') }}"
                                                        placeholder="Masukkan Password Baru">
                                                    <div class="text-danger">
                                                        @error('edit_password')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                    <div class="text-danger">
                                                        <p>Catatan : "Kosongkan jika tidak ingin merubah password."</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-block"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning btn-block"
                                                    value="submit">Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal add -->
                        </div>
                    @endforeach

                    <!-- Modal Delete-->
                    @foreach ($user as $data)
                        <div class="modal fade" id="modal-delete{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Hapus User {{ $data->nama }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus </b> data
                                            <b> {{ $data->nama }} </b> ({{ $data->level }}) ?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="{{ route('delete-user', $data->id) }}" class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.row -->
    </section>
@endsection