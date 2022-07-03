@extends('layout.template')

@section('title')
    Transaksi | Budi Store
@endsection

@section('judul-halaman')
    Transaksi
@endsection

@section('navigasi-satu')
    Transaksi
@endsection

@section('bagian-nav')
    @include('layout.nav')
@endsection

@section('isi-konten')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-warning"></i>
                        <h3 class="box-title">Belum ada transaksi</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="alert alert-warning">
                            <h4><i class="icon fa fa-ban"></i> Anda belum melakukan transaksi apapun</h4>
                            Silahkan belanja dengan mengetuk tombol Chart di bawah
                        </div>

                        <div class="info-box">
                            <div class="info-box-icon">
                                <button class="btn info-box btn-success" type="button" data-toggle="modal"
                                    data-target="#modal-belanja">
                                    <i style="font-size:2vw" class="fa fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Edit Data -->
        <div class="modal fade" id="modal-belanja">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Mulai Belanja</h4>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('post-belanja') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group" hidden>
                                    <input type="text" name="invoice" class="form-control" value="{{ $invoice }}"
                                        readonly>
                                    <div class="text-danger">
                                        @error('invoice')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group" hidden>
                                    <label>Tanggal</label>
                                    <input type="text" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}"
                                        readonly>
                                    <div class="text-danger">
                                        @error('tanggal')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group" hidden>
                                    <label>User ID</label>
                                    <input type="text" name="user_id" class="form-control"
                                        value="{{ Auth::user()->id }}" readonly>
                                    <div class="text-danger">
                                        @error('user_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="text-success">
                                        <p><b>Belanja </b></p>
                                    </div>
                                    <p>Silahkan tekan tombol belanja jika ingin melanjutkan!
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success btn-block" value="submit"><i
                                        class="fa fa-fw fa-shopping-cart"></i> Belanja
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


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
