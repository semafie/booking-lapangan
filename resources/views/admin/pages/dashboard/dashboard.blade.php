@extends('admin.layout.header')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <iframe title="lapanan basket" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=e798a907-4a6f-498a-ace2-f1da4cbd1145&autoAuth=true&ctid=5263cc81-5912-42c4-abc1-d0f1b668b530" frameborder="0" allowFullScreen="true"></iframe>
      <!--/ Transactions -->
    </div>
  </div>
  <script>
    @if(Session::has('success_message'))

    Swal.fire({
      title: 'Berhasil',
      text: 'Anda Berhasil Login',
      icon: 'success',
      confirmButtonText: 'Oke'
    })
    @elseif(Session::has('gagal_login'))

    Swal.fire({
      title: 'Gagal',
      text: 'Masukkan email dan password dengan benar',
      icon: 'error',
      confirmButtonText: 'Oke'
    })
    @endif
</script>   
@endsection