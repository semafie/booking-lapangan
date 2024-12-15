@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">

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
                                
                            <form action="{{ route('delete_ulasan_user', $item->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                {{-- <input class="form-control" type="hidden" name="id_lapangan" value="{{ $id_lapangan }}" id="html5-time-input" /> --}}
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            </div>
                            </td>
                        </tr>

                        
                </tbody>
                @endforeach
            </table>
        </div>

    </div>
</div>
<script>
    let table = new DataTable('#myTable');
</script>
@endsection