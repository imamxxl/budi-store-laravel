<ul class="sidebar-menu" data-widget="tree">
    @if (auth()->user()->level == 'pimpinan')
        <li class="header">Pimpinan</li>
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
        </li>
        <li class="{{ request()->is('user', 'recyle-user') ? 'active' : '' }}">
            <a href="/user"><i class="fa fa-user"></i> <span>User</span></a>
        </li>
        <li class="{{ request()->is('semua-barang', 'recycle-barang') ? 'active' : '' }}">
            <a href="/semua-barang"><i class="fa fa-file-text"></i> <span>Barang</span></a>
        </li>
        {{-- <li class="{{ request()->is('pembelian') ? 'active' : '' }}">
            <a href="/pembelian"><i class="fa fa-pencil-square-o"></i> <span>Pembelian</span></a>
        </li> --}}
        <li class="{{ request()->is('transaksi', '') ? 'active' : '' }}">
            <a href="/transaksi"><i class="fa fa-shopping-cart"></i> <span>Transaksi</span></a>
        </li>
        <li>
            <a href="/laporan"><i class="fa fa-sticky-note-o"></i> <span>Laporan</span></a>
        </li>
        </li>
    @endif

    @if (auth()->user()->level == 'admin')
        <li class="header">Admin</li>
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
        </li>
        <li class="{{ request()->is('barang', 'barang/trash') ? 'active' : '' }}">
            <a href="/barang"><i class="fa fa-file-text"></i> <span>Barang</span></a>
        </li>
        {{-- <li class="{{ request()->is('pembelian') ? 'active' : '' }}">
            <a href="/pembelian"><i class="fa fa-pencil-square-o"></i> <span>Pembelian</span></a>
        </li> --}}
        <li class="{{ request()->is('transaksi') ? 'active' : '' }}">
            <a href="/transaksi"><i class="fa fa-shopping-cart"></i> <span>Transaksi</span></a>
        </li>
        <li>
            <a href="/laporan"><i class="fa fa-sticky-note-o"></i> <span>Laporan</span></a>
        </li>
        </li>
    @endif

</ul>
