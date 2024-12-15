@extends('user.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">
        <a href="" class="btn btn-primary my-3"
            style="display: inline-block; width: auto; max-width: fit-content;" data-bs-toggle="modal" data-bs-target="#tambahulasan">
            Tambah Data Ulasan
        </a>
        
        <div class="text-nowrap table-responsive pt-0">
            <table id="myTable" class="datatables-basic table border-top">
                <thead>
                    <tr>
                        {{-- <th>Nama Lapangan</th> --}}
                        <th>rating</th>
                        <th>komentar</th>
                        <th>Aksi</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ulasan as $item)
                        <tr>
                            <td>{{ $item->rating }}</td>
                            <td>{{ $item->komentar }}</td>
                            <td><div class="d-flex gap-3">
                                <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editulasan{{ $item->id }}">Edit</button>
                            <form action="{{ route('delete_ulasan_user', $item->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                {{-- <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" /> --}}
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editulasan{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalToggleLabel">Edit Data Ulasan</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('edit_ulasan_user', $item->id ) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                <div class="modal-body">
                                   
                                    <label for="exampleFormControlSelect1" class="form-label">Rating</label>
                                    <select class="form-select" id="exampleFormControlSelect1" name="rating" aria-label="Default select example">
                                        <option {{ $item->rating == 1 ? 'selected' : '' }} value="1">One</option>
                                        <option {{ $item->rating == 2 ? 'selected' : '' }} value="2">Two</option>
                                        <option {{ $item->rating == 3 ? 'selected' : '' }} value="3">Three</option>
                                        <option {{ $item->rating == 4 ? 'selected' : '' }} value="4">Four</option>
                                        <option {{ $item->rating == 5 ? 'selected' : '' }} value="5">Five</option>
                                    </select>
                                    <label for="defaultFormControlInput" class="form-label">Komentar</label>
                                    <input class="form-control" type="hidden" name="user_id" value="{{ $user->id }}" id="html5-time-input" />
                                    <input class="form-control" type="text" name="komentar" value="{{ $item->komentar }}" id="html5-time-input" />
                                    {{-- <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" /> --}}
                                    
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

        <div class="modal fade" id="tambahulasan" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalToggleLabel">Tambah Data Ulasan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_ulasan_user') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                   
                    <label for="exampleFormControlSelect1" class="form-label">Rating</label>
                    <select class="form-select" id="exampleFormControlSelect1" name="rating" aria-label="Default select example">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="4">Four</option>
                        <option value="5">Five</option>
                    </select>
                    <label for="defaultFormControlInput" class="form-label">Komentar</label>
                    <input class="form-control" type="hidden" name="user_id" value="{{ $user->id }}" id="html5-time-input" />
                    <input class="form-control" type="text" name="komentar"id="html5-time-input" />
                    {{-- <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" /> --}}
                    
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