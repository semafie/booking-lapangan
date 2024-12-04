@extends('admin.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane "  id="navs-pills-top-aktif" role="tabpanel">

        
    <div class="mb-2 d-flex w-full gap-2 justify-content-end">
    <button id="resetButton" class="btn btn-danger" >Reset</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#carijadwal">Cari Jadwal</button>
</div>
    <table id="selectedTable" class="datatables-basic table border-top mb-2">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nama Lapangan</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                                
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <form action="{{ route('tambah_transaksi') }}" method="POST">
                        @csrf
                    <input type="text" id="selectedData" name="selectedData" />
        
                    <label for="defaultFormControlInput" class="form-label">Metode</label>
                    <select class="form-select mb-2" name="tipe" id="select_metode" aria-label="Default select example">
                        <option value="terdaftar">Terdaftar</option>
                        <option value="tidak_terdaftar">Tidak Terdaftar</option>
                    </select>
                    
                    <div id="id_user_section" style="display: none;">
                        <label for="defaultFormControlInput" class="form-label">ID User</label>
                        <div class="d-flex gap-3">
                            <input type="text" class="form-control mb-2" readonly style="width: 75%;" id="defaultFormControlInput" placeholder="ID User" name="id_user" aria-describedby="defaultFormControlHelp" />
                            <button type="button" class="btn btn-primary" style="width: 25%;">Cari User</button>
                        </div>
                    </div>
                    
                    <div id="nama_section" style="display: none;">
                        <label for="defaultFormControlInput" class="form-label">Nama</label>
                        <input type="text" class="form-control mb-2" id="defaultFormControlInput" placeholder="Nama User" name="nama" aria-describedby="defaultFormControlHelp" />
                    </div>
                    <label for="defaultFormControlInput" class="form-label">Metode</label>
                    <select class="form-select mb-2" name="metode" id="select_metode" aria-label="Default select example">
                        <option value="manual">Manual</option>
                        
                    </select>
                    {{-- <div id="show_gambar">
                    <label for="defaultFormControlInput" class="form-label">Bukti</label>
                    <input type="file" class="form-control mb-2" name="bukti" id="gambar" placeholder="Gambar" aria-describedby="defaultFormControlHelp" />
                </div> --}}
                    
                    
                    <label for="defaultFormControlInput" class="form-label">tanggal</label>
                    <input type="date" class="form-control mb-2" name="tanggal" id="tanggals" placeholder="Harga" aria-describedby="defaultFormControlHelp" />
                    
                    
                    <label for="defaultFormControlInput" class="form-label">Total Harga</label>
                    <input type="text" class="form-control mb-2" value="0" name="total_harga" id="total_harga" placeholder="Total Harga" aria-describedby="defaultFormControlHelp" readonly />

                    <button href="" class="btn btn-primary my-3"
        style="display: inline-block; width: auto; max-width: fit-content;" data-bs-toggle="modal" data-bs-target="#tambahlapangan" >
        Tambah Data Transaksi
                    </button>
</form>

            

        <div class="modal fade" id="tambahtransaksi" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalToggleLabel">Tambah Data transaksi</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_transaksi') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                                    </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Tambah Data</button>
                </div>
            </form>
              </div>
            </div>
          </div>

          <div class="modal fade" id="carijadwal" aria-hidden="true" aria-labelledby="modalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalToggleLabel2">Data jadwal</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="modalTable" class="datatables-basic table border-top">
                        <thead>
                            <tr>
                                <th>id_jadwal</th>
                                <th>Nama Lapangan</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($jadwal->isEmpty()) <!-- Cek jika jadwal kosong -->
                                <tr>
                                    <td colspan="6" style="color: red; font-weight: bold;" class="text-center">Jadwal lagi penuh</td>
                                </tr>
                            @else
                                @foreach ($jadwal as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->lapangan->nama }}</td>
                                        <td>{{ $item->jam_mulai }}</td>
                                        <td>{{ $item->jam_selesai }}</td>
                                        <td>{{ $item->lapangan->harga_per_jam }}</td>
                                        <td><button id="resetButton" class="btn btn-warning pilihJadwal" data-bs-dismiss="modal">Pilih jadwal</button></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    
                </div>
                <div class="modal-footer">
                  
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="carijadwal" aria-hidden="true" aria-labelledby="modalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalToggleLabel2">Data User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="modalTable" class="datatables-basic table border-top">
                        <thead>
                            <tr>
                                <th>id_jadwal</th>
                                <th>Nama Lapangan</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->lapangan->nama }}</td>
                            <td>{{ $item->jam_mulai }}</td>
                            <td>{{ $item->jam_selesai }}</td>
                            <td>{{ $item->lapangan->harga_per_jam }}</td>
                            <td><button id="resetButton" class="btn btn-warning pilihJadwal" data-bs-dismiss="modal">Pilih jadwal</button></td>
                            
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                  
                </div>
              </div>
            </div>
          </div>

    </div>
</div>



<script>

$(document).ready(function () {
    const selectedTableBody = $("#selectedTable tbody");
    const selectedDataInput = $("#selectedData");

    // Pilih Jadwal
    $("#modalTable").on("click", ".pilihJadwal", function () {
        const row = $(this).closest("tr");
        const id = row.find("td:nth-child(1)").text();
        const namaLapangan = row.find("td:nth-child(2)").text();
        const jamMulai = row.find("td:nth-child(3)").text();
        const jamSelesai = row.find("td:nth-child(4)").text();
        const harga = row.find("td:nth-child(5)").text();

        // Cek apakah ID sudah ada di tabel selectedTable
        let isDuplicate = false;
        selectedTableBody.find("tr").each(function () {
            const existingId = $(this).find("td:nth-child(1)").text();
            if (existingId === id) {
                isDuplicate = true;
                return false; // Hentikan loop
            }
        });

        // Jika duplikat, tidak perlu menambahkan lagi
        if (isDuplicate) {
            alert("Jadwal ini sudah dipilih!");
            return;
        }

        // Tambahkan baris ke tabel kedua
        const newRow = `
            <tr>
                <td>${id}</td>
                <td>${namaLapangan}</td>
                <td>${jamMulai}</td>
                <td>${jamSelesai}</td>
                <td class="harga">${harga}</td>
                <td><button class="btn btn-danger hapusRow">Hapus</button></td>
            </tr>
        `;
        selectedTableBody.append(newRow);

        // Update input hidden dengan data JSON
        updateHiddenInput();
        updateTotalHarga();
    });

    // Reset Tabel
    $("#resetButton").on("click", function () {
        selectedTableBody.empty();
        updateHiddenInput();
        updateTotalHarga();
    });

    // Hapus baris tertentu
    $("#selectedTable").on("click", ".hapusRow", function () {
        $(this).closest("tr").remove();
        updateHiddenInput();
        updateTotalHarga();
    });

    
    const table = document.getElementById("selectedTable");
    const totalHargaInput = document.getElementById("total_harga");

    function updateTotalHarga() {
        let totalHarga = 0;

        // Iterasi semua baris tabel dan tambahkan harga
        table.querySelectorAll("tbody tr").forEach(row => {
            const hargaCell = row.querySelector(".harga");
            if (hargaCell) {
                totalHarga += parseFloat(hargaCell.textContent) || 0;
            }
        });

        // Perbarui nilai input total_harga
        totalHargaInput.value = totalHarga;
    }

    // Hitung total harga saat halaman dimuat
    

    // Event listener untuk tombol hapus
    table.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove")) {
            const row = e.target.closest("tr");
            row.remove(); // Hapus baris dari tabel
            updateTotalHarga(); // Perbarui total harga
        }
    });


    // Update input hidden
    function updateHiddenInput() {
        const data = [];
        selectedTableBody.find("tr").each(function () {
            const row = $(this);
            const rowData = {
                idjadwal: row.find("td:nth-child(1)").text(),
                jamMulai: row.find("td:nth-child(3)").text(),
                jamSelesai: row.find("td:nth-child(4)").text(),
                harga: row.find("td:nth-child(5)").text()
            };
            data.push(rowData);
        });
        selectedDataInput.val(JSON.stringify(data));
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const selectMetode = document.getElementById('select_metode');
    const idUserSection = document.getElementById('id_user_section');
    const namaSection = document.getElementById('nama_section');
    const idUserInput = idUserSection.querySelector('input');
    const namaInput = namaSection.querySelector('input');

    // Fungsi untuk update tampilan berdasarkan pilihan metode
    selectMetode.addEventListener('change', function () {
        const selectedValue = selectMetode.value;

        // Jika terdaftar, tampilkan ID User dan sembunyikan Nama
        if (selectedValue === 'terdaftar') {
            idUserSection.style.display = 'block';
            namaSection.style.display = 'none';
            // Kosongkan input Nama jika memilih "Terdaftar"
            namaInput.value = '';
        } else if (selectedValue === 'tidak_terdaftar') {
            // Jika tidak terdaftar, tampilkan Nama dan sembunyikan ID User
            idUserSection.style.display = 'none';
            namaSection.style.display = 'block';
            // Kosongkan input ID User jika memilih "Tidak Terdaftar"
            idUserInput.value = '';
        }
    });

    // Pastikan tampilan sudah ter-update saat halaman pertama kali dimuat
    selectMetode.dispatchEvent(new Event('change'));
});





    // Mendapatkan elemen input
    const dateInput = document.getElementById("tanggals");

// Mengambil tanggal hari ini dengan zona waktu Indonesia (Jakarta)
const today = new Date();
const jakartaDate = new Date(today.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));

// Format tanggal dalam format YYYY-MM-DD
const formattedDate = jakartaDate.toISOString().split("T")[0];

// Mengatur nilai default input ke tanggal hari ini dengan zona waktu Jakarta
dateInput.value = formattedDate;
</script>

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