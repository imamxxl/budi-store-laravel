@extends('layout.template')

@section('title')
    Barang | Budi Store
@endsection

@section('judul-halaman')
    CRUD Barang
@endsection

@section('navigasi-satu')
    Barang
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
                    <button type="button" class="btn btn-lg bg-purple color-palette fa fa-plus" data-toggle="modal"
                        data-target="#modal-add-admin">
                        Tambah Barang
                    </button>
                    <a href="/pimpinan/barang/trash" class="btn btn-lg btn-default fa fa-trash"> Tong Sampah </a>
                </div>


                <div class="card-body box-body table-hover">

                    <!-- Table Barangs -->
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($barang as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td><img class="profile-user-img" src="{{ url('barang/' . $data->barang_url) }}"></td>
                                    <td>{{ $data->kode_barang }}</td>
                                    <td>{{ $data->nama_barang }}</td>
                                    <td>{{ $data->satuan }}</td>
                                    <td>{{ $data->harga }}</td>
                                    <td>{{ $data->stok }}</td>
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

                    <!-- Modal Add Barang-->
                    <div class="modal fade" id="modal-add-admin">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Barang</h4>
                                </div>

                                <div class="modal-body">
                                    <form action="/pimpinan/barang/store" method="POST" id="upload-image-form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Barang</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_barang" class="form-control"
                                                    value="{{ $kode_barang }}" placeholder="Contoh: P-3222" readonly>
                                                <div class="text-danger">
                                                    @error('kode_barang')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Gambar</label>
                                                <label class="text-danger">*</label>
                                                <input type="file" name="photo">
                                                <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                    (ukuran max: 1MB)</p>
                                                <div class="text-danger">
                                                    @error('photo')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_barang" class="form-control"
                                                    value="{{ old('nama_barang') }}" placeholder="Contoh: Deterjen">
                                                <div class="text-danger">
                                                    @error('nama_barang')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div>
                                            </div>
                                            <div class="form-group">
                                                <label>Satuan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" id="satuan" name="satuan">
                                                    <option value="">- Pilih Satuan -</option>
                                                    <option value="Pcs"
                                                        @if (old('satuan') == 'Pcs') {{ 'selected' }} @endif>
                                                        Pcs
                                                    </option>
                                                    <option value="Pack"
                                                        @if (old('satuan') == 'Pack') {{ 'selected' }} @endif>
                                                        Pack
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('satuan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Stok</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="stok" class="form-control"
                                                    placeholder="Contoh: 20">
                                                <div class="text-danger">
                                                    @error('stok')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Satuan</label>
                                                <label class="text-danger">*</label>
                                                <div class="text-danger">
                                                    @error('harga')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type="text" class="form-control" name="harga">
                                                <span class="input-group-addon">,-</span>
                                            </div>
                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-block"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn bg-purple btn-block" value="submit">Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal add -->
                    </div>

                    {{-- <!-- Modal Change Password -->
                    @foreach ($barang as $data)
                        <!-- Modal Add Admin-->
                        <div class="modal fade" id="modal-change-password{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Ubah Password {{ $data->nama }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="/user/change_password/{{ $data->id }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" name="username" class="form-control"
                                                        value="{{ $data->username }}" readonly>
                                                    <div class="text-danger">
                                                        @error('username')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        value="{{ $data->nama }}" readonly>
                                                    <div class="text-danger">
                                                        @error('nama')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Password Baru</label>
                                                    <input type="password" name="password" class="form-control"
                                                        value="{{ old('password') }}"
                                                        placeholder="Masukkan Password Baru">
                                                    <div class="text-danger">
                                                        @error('password')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-block"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-block"
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
                    @endforeach --}}

                    {{-- <!-- Modal Nonaktif-->
                    @foreach ($barang as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Nonaktifkan {{ $data->nama }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/user/nonaktif/{{ $data->id }}" class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach --}}

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.row -->
    </section>
@endsection
