@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane" id="navs-pills-top-aktif" role="tabpanel">
        <a href="" class="btn btn-primary my-3" style="display: inline-block; width: auto; max-width: fit-content;" 
            data-bs-toggle="modal" data-bs-target="#tambahpelanggan">
            Tambah Data Pelanggan
        </a>
        
        <div class="text-nowrap table-responsive pt-0">
            <table id="myTable" class="datatables-basic table border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggan as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editpelanggan{{ $item->id }}">Edit</button>
                                    <form action="{{ route('delete_pelanggan', $item->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editpelanggan{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalToggleLabel">Edit Data Pelanggan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('edit_pelanggan', $item->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Update Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahpelanggan" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Tambah Data Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('tambah_pelanggan') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    @if(Session::has('berhasil_tambah'))
    Swal.fire({
        title: 'Berhasil',
        text: 'Data Berhasil ditambahkan',
        icon: 'success',
        confirmButtonText: 'Oke'
    })
    @elseif(Session::has('gagal_tambah'))
    Swal.fire({
        title: 'Gagal',
        text: 'Data gagal di tambahkan',
        icon: 'error',
        confirmButtonText: 'Oke'
    })
    @elseif(Session::has('berhasil_edit'))
    Swal.fire({
        title: 'Berhasil',
        text: 'Data Berhasil di edit',
        icon: 'success',
        confirmButtonText: 'Oke'
    })
    @elseif(Session::has('berhasil_hapus'))
    Swal.fire({
        title: 'Berhasil',
        text: 'Data Berhasil dihapus',
        icon: 'success',
        confirmButtonText: 'Oke'
    })
    @elseif(Session::has('kosong_tambah'))
    Swal.fire({
        title: 'Gagal',
        text: 'Lengkapi data',
        icon: 'error',
        confirmButtonText: 'Oke'
    })
    @endif
</script>
@endsection