@extends('user.layout.header')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
            </div>
            <h3 class="card-title mb-3">Pembayaran Gagal</h3>
            <p class="card-text mb-4">Maaf, pembayaran Anda gagal diproses. Silakan coba lagi atau hubungi customer service kami.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('transaksi_user') }}" class="btn btn-primary">Coba Lagi</a>
                <a href="{{ route('dashboard_user') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection 