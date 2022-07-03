@extends('layout.template')

@section('title')
    CRUD Barang | Budi Store
@endsection

@section('judul-halaman')
    CRUD Barang
@endsection

@section('navigasi-satu')
    CRUD Barang
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

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title center">Data Barang</h3>
                </div>

                <div class="box-body">
                    <button type="button" class="btn btn-lg bg-purple color-palette fa fa-plus" data-toggle="modal"
                        data-target="#modal-add-barang">
                        Tambah Barang
                    </button>
                    <a href="{{ route('recycle-barang') }}" class="btn btn-lg btn-default fa fa-trash"> Tong Sampah </a>
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
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Terjual</th>
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
                                    <td>Rp. {{ $data->harga }}/{{ $data->satuan }}</td>
                                    <td>{{ $data->stok }} {{ $data->satuan }}</td>
                                    @if ($data->terjual == null)
                                        <td><i>Belum ada penjualan</i></td>
                                    @else
                                        <td><i>{{ $data->terjual }}</i></td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#modal-tambah{{ $data->id }}">
                                            <i class="fa fa-fw fa-plus"></i>
                                        </button>
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

                    <!-- Modal tambah jenis barang-->
                    <div class="modal fade" id="modal-add-barang">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Barang</h4>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('post-barang') }}" method="POST" id="upload-image-form"
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
                                                    value="{{ old('stok') }}" placeholder="Contoh: 20">
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
                                                <input type="text" class="form-control" name="harga"
                                                    value="{{ old('harga') }}" placeholder="Contoh: 10000">
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
                        </div>
                    </div>

                    <!-- Modal tambah stok -->
                    @foreach ($barang as $data)
                        <div class="modal fade" id="modal-tambah{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Tambah Stok {{ $data->nama_barang }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('post-stok', $data->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>Stok Tersedia</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="stok_tersedia" class="form-control"
                                                        value="{{ $data->stok }}" readonly>
                                                    <div class="text-danger">
                                                        @error('stok_tersedia')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tambah Stok</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="tambah_stok" class="form-control"
                                                        placeholder="Contoh: 200">
                                                    <div class="text-danger">
                                                        @error('tambah_stok')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-block"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success btn-block"
                                                    value="submit">Tambah stok {{ $data->nama_barang }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Modal Edit Data -->
                    @foreach ($barang as $data)
                        <div class="modal fade" id="modal-edit{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Edit {{ $data->nama_barang }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('update-barang', $data->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>Kode Barang</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="edit_kode_barang" class="form-control"
                                                        value="{{ $data->kode_barang }}" readonly>
                                                    <div class="text-danger">
                                                        @error('edit_kode_barang')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Barang</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="edit_nama_barang" class="form-control"
                                                        value="{{ $data->nama_barang }}">
                                                    <div class="text-danger">
                                                        @error('edit_nama_barang')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Satuan</label>
                                                    <label class="text-danger">*</label>
                                                    @if ($data->satuan == 'Pcs')
                                                        <select name="edit_satuan" class="form-control">
                                                            <option value="Pcs" selected>Pcs</option>
                                                            <option value="Pack">Pack</option>
                                                        </select>
                                                    @elseif($data->satuan == 'Pack')
                                                        <select name="edit_satuan" required class="form-control">
                                                            <option value="Pcs">Pcs</option>
                                                            <option value="Pack" selected>Pack
                                                            </option>
                                                        </select>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Harga</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="edit_harga" class="form-control"
                                                        value="{{ $data->harga }}">
                                                    <div class="text-danger">
                                                        @error('edit_harga')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Foto</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="file" name="edit_photo">

                                                    <div class="text-danger">
                                                        @error('edit_photo')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <img src="{{ url('barang/' . $data->barang_url) }}" width="80">
                                                    <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                        (ukuran max: 1MB)
                                                    </p>
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
                            </div>
                        </div>
                    @endforeach

                    <!-- Modal Delete-->
                    @foreach ($barang as $data)
                        <div class="modal fade" id="modal-delete{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Hapus {{ $data->nama_barang }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus </b> barang
                                            {{ $data->nama_barang }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="{{ route('delete-barang', $data->id) }}"
                                            class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
