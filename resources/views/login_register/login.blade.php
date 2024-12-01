<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login Form Design | CodeLab</title>
      <link rel="stylesheet" href="{{ asset('css/login.css') }}">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      
      {{-- DATATABLE --}}
      <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
      <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
  
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css" rel="stylesheet">
   </head>
   <body>
      <div class="wrapper">
         <div class="title">
            Login Form
         </div>
         <form action="{{ route('loginakun') }}" method="POST">
            @csrf
            <div class="field">
               <input type="text" name="email" required>
               <label>Email Address</label>
            </div>
            <div class="field">
               <input type="password" name="password" required>
               <label>Password</label>
            </div>
            <div class="content">
               <div class="checkbox">
                  <input type="checkbox" id="remember-me">
                  <label for="remember-me">Remember me</label>
               </div>
               <div class="pass-link">
                  <a href="#">Forgot password?</a>
               </div>
            </div>
            <div class="field">
               <input type="submit" value="Login">
            </div>
            <div class="signup-link">
               Not a member? <a href="#">Signup now</a>
            </div>
         </form>
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