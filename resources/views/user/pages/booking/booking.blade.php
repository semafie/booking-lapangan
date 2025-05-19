@extends('user.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card px-4 py-2 tab-pane" id="navs-pills-top-aktif" role="tabpanel">
        <div class="mb-2 d-flex w-full gap-2 justify-content-end">
            <button id="resetButton" class="btn btn-danger">Reset</button>
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

        <form id="payment-form" action="{{ route('process-payment') }}" method="POST">
            @csrf
            <input type="text" id="selectedData" name="selectedData" hidden/>
            
            <label for="defaultFormControlInput" class="form-label">Tanggal</label>
            <input type="date" class="form-control mb-2" name="tanggal" id="tanggals" required />
            
            <label for="defaultFormControlInput" class="form-label">Total Harga</label>
            <input type="text" class="form-control mb-2" value="0" name="total_harga" id="total_harga" readonly />

            <button type="submit" class="btn btn-primary my-3" id="pay-button" style="display: inline-block; width: auto; max-width: fit-content;">
                Bayar Sekarang
            </button>
        </form>

        <!-- Modal Cari Jadwal -->
        <div class="modal fade" id="carijadwal" aria-hidden="true" aria-labelledby="modalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel2">Data Jadwal</h5>
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
                                @if($jadwal->isEmpty())
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
                                            <td><button class="btn btn-warning pilihJadwal" data-bs-dismiss="modal">Pilih jadwal</button></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-PeBVgmyPHeH5FWiH"></script>
<script>
$(document).ready(function () {
    const selectedTableBody = $("#selectedTable tbody");
    const selectedDataInput = $("#selectedData");
    const totalHargaInput = $("#total_harga");

    // Pilih Jadwal
    $("#modalTable").on("click", ".pilihJadwal", function () {
        const row = $(this).closest("tr");
        const id = row.find("td:nth-child(1)").text();
        const namaLapangan = row.find("td:nth-child(2)").text();
        const jamMulai = row.find("td:nth-child(3)").text();
        const jamSelesai = row.find("td:nth-child(4)").text();
        const harga = row.find("td:nth-child(5)").text();

        // Cek duplikat
        let isDuplicate = false;
        selectedTableBody.find("tr").each(function () {
            if ($(this).find("td:nth-child(1)").text() === id) {
                isDuplicate = true;
                return false;
            }
        });

        if (isDuplicate) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Jadwal ini sudah dipilih!',
                icon: 'warning',
                confirmButtonText: 'Oke'
            });
            return;
        }

        // Tambah ke tabel
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
        updateHiddenInput();
        updateTotalHarga();
    });

    // Reset Tabel
    $("#resetButton").on("click", function () {
        selectedTableBody.empty();
        updateHiddenInput();
        updateTotalHarga();
    });

    // Hapus baris
    $("#selectedTable").on("click", ".hapusRow", function () {
        $(this).closest("tr").remove();
        updateHiddenInput();
        updateTotalHarga();
    });

    // Update total harga
    function updateTotalHarga() {
        let total = 0;
        selectedTableBody.find("tr").each(function () {
            const harga = parseFloat($(this).find(".harga").text()) || 0;
            total += harga;
        });
        totalHargaInput.val(total);
    }

    // Update input hidden
    function updateHiddenInput() {
        const data = [];
        selectedTableBody.find("tr").each(function () {
            const row = $(this);
            data.push({
                idjadwal: row.find("td:nth-child(1)").text(),
                jamMulai: row.find("td:nth-child(3)").text(),
                jamSelesai: row.find("td:nth-child(4)").text(),
                harga: row.find("td:nth-child(5)").text()
            });
        });
        selectedDataInput.val(JSON.stringify(data));
    }

    // Handle form submission
    $("#payment-form").on("submit", function(e) {
        e.preventDefault();
        
        if (selectedTableBody.find("tr").length === 0) {
            Swal.fire({
                title: 'Error',
                text: 'Pilih minimal satu jadwal!',
                icon: 'error',
                confirmButtonText: 'Oke'
            });
            return;
        }

        // Tampilkan loading
        Swal.fire({
            title: 'Memproses Pembayaran',
            text: 'Mohon tunggu sebentar...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Kirim data ke server
        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.snap_token) {
                    snap.pay(response.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '/payment-success';
                        },
                        onPending: function(result) {
                            window.location.href = '/payment-pending';
                        },
                        onError: function(result) {
                            window.location.href = '/payment-error';
                        },
                        onClose: function() {
                            Swal.fire({
                                title: 'Pembayaran Dibatalkan',
                                text: 'Anda menutup halaman pembayaran',
                                icon: 'info',
                                confirmButtonText: 'Oke'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memproses pembayaran',
                        icon: 'error',
                        confirmButtonText: 'Oke'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat memproses pembayaran';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Oke'
                });
            }
        });
    });
});

// Set tanggal default ke hari ini
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById("tanggals");
    const today = new Date();
    const jakartaDate = new Date(today.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
    dateInput.value = jakartaDate.toISOString().split("T")[0];
});
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
    @endif
</script>
@endsection