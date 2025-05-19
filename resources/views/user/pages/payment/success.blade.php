@extends('user.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
            </div>
            <h3 class="card-title mb-3">Pembayaran Berhasil!</h3>
            <p class="card-text mb-4">Terima kasih telah melakukan pembayaran. Booking Anda telah dikonfirmasi.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('transaksi_user') }}" class="btn btn-primary">Lihat Transaksi</a>
                <a href="{{ route('dashboard_user') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection 