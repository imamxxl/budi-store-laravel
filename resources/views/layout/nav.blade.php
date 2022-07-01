<ul class="sidebar-menu" data-widget="tree">
    <li class="header">Admin</li>
    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
    </li>
    <li class="{{ request()->is('barang') ? 'active' : '' }}">
        <a href="/barang"><i class="fa fa-file-text"></i> <span>Barang</span></a>
    </li>
    <li class="{{ request()->is('/pembelian') ? 'active' : '' }}">
        <a href="/pembelian"><i class="fa fa-pencil-square-o"></i> <span>Pembelian</span></a>
    </li>
    <li class="{{ request()->is('/pembelian') ? 'active' : '' }}">
        <a href="/penjualan"><i class="fa fa-shopping-cart"></i> <span>Penjualan</span></a>
    </li>
    <li class="{{ request()->is('/laporan') ? 'active' : '' }}">
        <a href="/laporan"><i class="fa fa-sticky-note-o"></i> <span>Laporan</span></a>
    </li>
    <li class="header">Pimpinan</li>
    <li class="{{ request()->is('dashboard_pimpinan') ? 'active' : '' }}">
        <a href="/dashboard_pimpinan"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
    </li>
    <li class="{{ request()->is('user') ? 'active' : '' }}">
        <a href="/user"><i class="fa fa-user"></i> <span>CRUD User</span></a>
    </li>
    <li class="{{ request()->is('pimpinan/barang') ? 'active' : '' }}">
        <a href="/pimpinan/barang"><i class="fa fa-file-text"></i> <span>Barang</span></a>
    </li>
    <li>
        <a href="/pembelian"><i class="fa fa-pencil-square-o"></i> <span>Pembelian</span></a>
    </li>
    <li>
        <a href="/penjualan"><i class="fa fa-shopping-cart"></i> <span>Penjualan</span></a>
    </li>
    <li>
        <a href="/laporan"><i class="fa fa-sticky-note-o"></i> <span>Laporan</span></a>
    </li>
    </li>
</ul>
