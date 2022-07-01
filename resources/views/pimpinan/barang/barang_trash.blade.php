@extends('layout.template')

@section('title')
    Barang | Budi Store
@endsection

@section('judul-halaman')
    Barang Trash
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
                    <h3 class="box-title center">Data Barang Trash</h3>
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
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#modal-edit{{ $data->id }}">
                                            <i class="fa fa-fw fa-refresh"></i>
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
                                            {{ $data->nama_barang }} <b>secara permanen</b> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/pimpinan/barang/destroy/{{ $data->id }}"
                                            class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach

                    <!-- Modal Restore-->
                    @foreach ($barang as $data)
                        <div class="modal fade" id="modal-edit{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Restore {{ $data->nama_barang }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda ingin <b> mengembalikan </b> barang
                                            {{ $data->nama_barang }} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/pimpinan/barang/restore/{{ $data->id }}"
                                            class="btn btn-success">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    @endforeach

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.row -->
    </section>
@endsection
