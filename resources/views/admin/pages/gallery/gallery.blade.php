@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">
        <a href="" class="btn btn-primary my-3"
            style="display: inline-block; width: auto; max-width: fit-content;" data-bs-toggle="modal" data-bs-target="#tambahgallery">
            Tambah Data Gallery
        </a>
        
        <div class="text-nowrap table-responsive pt-0">
            <table id="myTable" class="datatables-basic table border-top">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>gambar</th>
                        <th>Aksi</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gallery as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><img style="width: 170px;" src="/{{ $item->gambar }}" alt=""></td>
                            <td><div class="d-flex gap-3">
                                <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editgallery{{ $item->id }}">Edit</button>
                            <form action="{{ route('delete_gallery', $item->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                {{-- <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" /> --}}
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editgallery{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalToggleLabel">Tambah Data Gallery</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('edit_gallery', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                <div class="modal-body">
                                    
                                    <label for="defaultFormControlInput" class="form-label">Gambar</label>
                                    <input type="file" class="form-control mb-2" name="gambar" id="defaultFormControlInput" placeholder="Gambar" aria-describedby="defaultFormControlHelp" />
                                    
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Tambah Data</button>
                                </div>
                            </form>
                              </div>
                            </div>
                          </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="tambahgallery" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalToggleLabel">Tambah Data Gallery</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_gallery') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    
                    <label for="defaultFormControlInput" class="form-label">Gambar</label>
                    <input type="file" class="form-control mb-2" name="gambar" id="defaultFormControlInput" placeholder="Gambar" aria-describedby="defaultFormControlHelp" />
                    
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