@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">

            <a href="" class="btn btn-primary my-3"
            style="display: inline-block; width: auto; max-width: fit-content;" data-bs-toggle="modal" data-bs-target="#tambahjadwal">
            Tambah Data Jadwal
        </a>
        
        <div class="text-nowrap table-responsive pt-0">
            <table id="myTable" class="datatables-basic table border-top">
                <thead>
                    <tr>
                        <th>Nama Lapangan</th>
                        <th>jam_mulai</th>
                        <th>jam_berakhir</th>
                        <th>status</th>
                        <th>Aksi</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $item)
                        <tr>
                            <td>{{ $item->lapangan->nama }}</td>
                            <td>{{ $item->jam_mulai }}</td>
                            <td>{{ $item->jam_selesai }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editjadwal{{ $item->id }}">Edit</button>
                                <form action="{{ route('delete_jadwal', $item->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" />
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editjadwal{{ $item->id }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalToggleLabel">Edit Data Jadwal</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('edit_jadwal', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                <div class="modal-body">
                                   
                                    <label for="defaultFormControlInput" class="form-label">jam_mulai</label>
                                    <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" />
                                    <input class="form-control" type="time" name="jam_mulai" value="{{ $item->jam_mulai }}" id="html5-time-input" />
                                    <label for="defaultFormControlInput" class="form-label">jam_selesai</label>
                                    <input class="form-control" type="time" name="jam_selesai" value="{{ $item->jam_selesai }}" id="html5-time-input" />
                                    
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

        <div class="modal fade" id="tambahjadwal" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalToggleLabel">Tambah Data Jadwal</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_jadwal') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                   
                    <label for="defaultFormControlInput" class="form-label">jam_mulai</label>
                    <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" />
                    <input class="form-control" type="time" name="jam_mulai" value="12:30:00" id="html5-time-input" />
                    <label for="defaultFormControlInput" class="form-label">jam_selesai</label>
                    <input class="form-control" type="time" name="jam_selesai" value="12:30:00" id="html5-time-input" />
                    
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