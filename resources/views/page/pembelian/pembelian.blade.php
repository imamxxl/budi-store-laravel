@extends('layout.template')

@section('title')
    Pembelian | Budi Store
@endsection

@section('judul-halaman')
    Pembelian Barang
@endsection

@section('navigasi-satu')
    Pembelian
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
                    <h3 class="box-title center">Daftar Barang</h3>
                </div>


                <div class="card-body box-body table-hover">

                    <!-- Table Barangs -->
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Stok Tersedia</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($barang as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td><img class="profile-user-img" src="{{ url('barang/' . $data->barang_url) }}"></td>
                                    <td>{{ $data->nama_barang }}</td>
                                    <td>Rp. {{ $data->harga }}/{{ $data->satuan }}</td>
                                    <td>{{ $data->stok }} {{ $data->satuan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm bg-orange" data-toggle="modal"
                                            data-target="#modal-beli{{ $data->id }}">
                                            <i class="fa fa-fw fa-shopping-cart"></i>
                                        </button>
                                        {{-- <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modal-edit{{ $data->id }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-delete{{ $data->id }}">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal Beli Barang -->
                    @foreach ($barang as $data)
                        <div class="modal fade" id="modal-beli{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Beli Barang {{ $data->nama_barang }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="/beli-barang/{{ $data->id }}" method="POST"
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
                                                    <label>Harga Satuan</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="harga_satuan" class="form-control"
                                                        id="harga" value="{{ $data->harga }}/{{ $data->satuan }}"
                                                        readonly>
                                                    <div class="text-danger">
                                                        @error('harga_satuan')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="qty" class="form-control" id="qty"
                                                        placeholder="Contoh: 5">
                                                    <div class="text-danger">
                                                        @error('qty')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Biaya</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="total_biaya" class="form-control"
                                                        placeholder="-" id="total_biaya" readonly>
                                                    <div class="text-danger">
                                                        @error('total_biaya')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-block"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn bg-orange btn-block" value="submit"> Beli
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

                    {{-- <!-- Modal Edit Data -->
                    @foreach ($pembelian as $data)
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
                                        <form action="/pimpinan/barang/update/{{ $data->id }}" method="POST"
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
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal add -->
                        </div>
                    @endforeach --}}

                    {{-- <!-- Modal Delete-->
                    @foreach ($pembelian as $data)
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
                                        <a href="/pimpinan/barang/delete/{{ $data->id }}"
                                            class="btn btn-danger">Ya!</a>
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

    <!-- jQuery 3 -->
    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <script>
        $("#qty").keyup(function() {
            qty = parseInt($(this).val())
            harga = parseInt($('#harga').val().split("/")[0]);

            console.log((qty * harga));

            $('#total_biaya').val(qty * harga);
        });
    </script>
@endsection
