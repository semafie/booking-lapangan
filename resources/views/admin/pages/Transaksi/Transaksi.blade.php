@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">
            <a href="" class="btn btn-primary my-3"
            style="display: inline-block; width: auto; max-width: fit-content;" data-bs-toggle="modal" data-bs-target="#tambahbarang">
            Tambah Data Transaksi
        </a>
        
        <div class="text-nowrap table-responsive pt-0">
            <table id="myTable" class="datatables-basic table border-top">
                <thead>
                    <tr>
                        <th>Nama User</th>
                        <th>Nama Lapangan</th>
                        <th>status</th>
                        <th>Bukti</th>
                        <th>tanggal</th>
                        <th>total_harga</th>
                        <th>Aksi</th>
                        
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>
@endsection