@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">
        <a href="" class="btn btn-primary my-3"
        style="display: inline-block; width: auto; max-width: fit-content;" data-bs-toggle="modal" data-bs-target="#tambahlapangan" >
        Tambah Data Lapangan
    </a>
    
    <div class="text-nowrap table-responsive pt-0">
        <table id="myTable" class="datatables-basic table border-top">
            <thead>
                <tr>
                    <th>Nama Lapangan</th>
                    <th>Deskripsi</th>
                    <th>ukuran</th>
                    <th>type</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>status</th>
                    <th>Aksi</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($lapangan as $item)
                    <tr>
                        <td>{{ $item->nama  }}</td>
                        <td>{{ $item->deskripsi  }}</td>
                        <td>{{ $item->ukuran  }}</td>
                        <td>{{ $item->tipe  }}</td>
                        <td>{{ $item->harga_per_jam  }}</td>
                        <td><img style="width: 170px;" src="/{{ $item->gambar }}" alt=""></td>
                        <td>{{ $item->status  }}</td>
                        <td class="">
                            <a href="{{ route('jadwal', $item->id) }}">
                            <button type="submit" class="btn btn-primary mb-3"
                                >Detail Jadwal</button>
                            <div class="d-flex gap-3">
                            </a>
                                
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editlapangan{{ $item->id }}">Edit</button>
                            <form action="{{ route('delete_lapangan', $item->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            </div>
                            
                        </td>
                        
                    </tr>


                    <div class="modal fade" id="editlapangan{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalToggleLabel">Edit Data Lapangan</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('edit_lapangan', $item->id ) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                            <div class="modal-body">
                                <label for="defaultFormControlInput" class="form-label">Lapangan</label>
                                <input type="text" class="form-control mb-2" id="defaultFormControlInput" value="{{ $item->nama }}" placeholder="nama lapangan" name="nama" aria-describedby="defaultFormControlHelp" />
                                <label for="defaultFormControlInput" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control mb-2" id="defaultFormControlInput" value="{{ $item->deskripsi }}" placeholder="deskripsi" name="deskripsi" aria-describedby="defaultFormControlHelp" />
                                <label for="defaultFormControlInput" class="form-label">Ukuran</label>
                                <input type="text" class="form-control mb-2" id="defaultFormControlInput" value="{{ $item->ukuran }}" placeholder="ukuran" name="ukuran" aria-describedby="defaultFormControlHelp" />
                                <label for="defaultFormControlInput" class="form-label">Type</label>
                                <select class="form-select mb-2" name="tipe" id="exampleFormControlSelect1" aria-label="Default select example">
                                    <option value="futsal" {{ $item->jenis == 'futsal' ? 'selected' : '' }}>Futsal</option>
                                    <option value="basket" {{ $item->jenis == 'basket' ? 'selected' : '' }}>Basket</option>
                                    <option value="Badminton" {{ $item->jenis == 'badminton' ? 'selected' : '' }}>Badminton</option>
                                </select>
                                <label for="defaultFormControlInput" class="form-label">Harga</label>
                                <input type="text" class="form-control mb-2" name="harga" value="{{ $item->harga_per_jam }}" id="defaultFormControlInput" placeholder="Harga" aria-describedby="defaultFormControlHelp" />
                                <label for="defaultFormControlInput" class="form-label">Status</label>
                                <select class="form-select" name="status" id="exampleFormControlSelect1"  aria-label="Default select example">
                                    <option value="tersedia" {{ $item->jenis == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Tidak Tersedia" {{ $item->jenis == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                </select>
                                <label for="defaultFormControlInput" class="form-label">Gambar</label>
                                
                                <input type="file" class="form-control mb-2" name="gambar" id="defaultFormControlInput" placeholder="Gambar" aria-describedby="defaultFormControlHelp" />
                                
                                @if($item->gambar)
                                            <img src="{{ asset($item->gambar) }}" alt="Current Image" class="img-fluid mb-3" style="width: 100px;">
                                @endif
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Edit Data</button>
                            </div>
                        </form>
                          </div>
                        </div>
                      </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="tambahlapangan" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalToggleLabel">Tambah Data Lapangan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambah_lapangan') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <label for="defaultFormControlInput" class="form-label">Lapangan</label>
                <input type="text" class="form-control mb-2" id="defaultFormControlInput" placeholder="nama lapangan" name="nama" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Deskripsi</label>
                <input type="text" class="form-control mb-2" id="defaultFormControlInput" placeholder="deskripsi" name="deskripsi" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Ukuran</label>
                <input type="text" class="form-control mb-2" id="defaultFormControlInput" placeholder="ukuran" name="ukuran" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Type</label>
                <select class="form-select mb-2" name="tipe" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option value="futsal">Futsal</option>
                    <option value="basket">Basket</option>
                    <option value="Badminton">Badminton</option>
                </select>
                <label for="defaultFormControlInput" class="form-label">Harga</label>
                <input type="text" class="form-control mb-2" name="harga" id="defaultFormControlInput" placeholder="Harga" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Gambar</label>
                <input type="file" class="form-control mb-2" name="gambar" id="defaultFormControlInput" placeholder="Gambar" aria-describedby="defaultFormControlHelp" />
                <label for="defaultFormControlInput" class="form-label">Status</label>
                <select class="form-select" name="status" id="exampleFormControlSelect1" aria-label="Default select example">
                    <option value="tersedia">Tersedia</option>
                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Tambah Data</button>
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
      title: 'Gagal ',
      text: 'Lengkapi data',
      icon: 'error',
      confirmButtonText: 'Oke'
    })
    @endif
  
     </script>
@endsection