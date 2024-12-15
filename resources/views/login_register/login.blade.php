<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Booking | Login
      </title>
      <link rel="stylesheet" href="{{ asset('css/login.css') }}">
      <link rel="stylesheet" href="{{ asset('js/login1.js') }}">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      
      {{-- DATATABLE --}}
      <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
      <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
  
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css" rel="stylesheet">
      <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
   </head>
   <body>
      <section class="container forms">
         <div class="form login">
           <div class="form-content">
             <header>Login</header>
             <form action="{{ route('loginakun') }}" method="POST">
               @csrf
               <div class="field input-field">
                 <input type="email" name="email" placeholder="Email" class="input">
               </div>
               <div class="field input-field">
                 <input type="password" name="password" placeholder="Password" class="password">
                 <i class='bx bx-hide eye-icon'></i>
               </div>
               <div class="form-link">
                 <a href="#" class="forgot-pass">Forgot password?</a>
               </div>
               <div class="field button-field">
                 <button type="submit">Login</button>
               </div>
             </form>
             <div class="form-link">
               <span>Don't have an account? <a href="/register" class="link signup-link">Signup</a></span>
             </div>
           </div>
           {{-- <div class="line"></div>
           
           <div class="media-options">
             <a href="auth/redirect" class="field google">
               <img src="images/google.png" alt="" class="google-img">
               <span>Login with Google</span>
             </a>
           </div> --}}
         </div>

      <script>
        @if(Session::has('login_dulu'))
      
        Swal.fire({
          title: 'Gagal',
          text: 'Anda Wajib login Terlebih dahulu',
          icon: 'error',
          confirmButtonText: 'Oke'
        })
        @elseif(Session::has('gagal_login'))
      
        Swal.fire({
          title: 'Gagal',
          text: 'Masukkan email dan password dengan benar',
          icon: 'error',
          confirmButtonText: 'Oke'
        })
        @elseif(Session::has('password_berhasil'))
      
        Swal.fire({
          title: 'Berhasil',
          text: 'Password anda berhasil di Ubah',
          icon: 'success',
          confirmButtonText: 'Oke'
        })

        @elseif(Session::has('berhasil_logout'))
      
        Swal.fire({
          title: 'Berhasil',
          text: 'Anda Berhasil Logout',
          icon: 'success',
          confirmButtonText: 'Oke'
        })
        @elseif(Session::has('gagal_kirim'))
      
        Swal.fire({
          title: 'Gagal',
          text: 'Anda Gagal mengirim otp',
          icon: 'error',
          confirmButtonText: 'Oke'
        })
        @elseif(Session::has('gagal_ditemukan'))
      
        Swal.fire({
          title: 'Gagal',
          text: 'Email atau Username anda tidak terdaftar',
          icon: 'error',
          confirmButtonText: 'Oke'
        })

        
        @endif
        </script>

   </body>
</html>