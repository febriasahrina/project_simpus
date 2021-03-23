<?php
error_reporting(0);
include "config/inc.connection.php";

$username = $_POST['username'];
$password = md5($_POST['password']);


  $login=mysqli_query($koneksidb,"SELECT * FROM users WHERE username='$username' AND password='$password'");
  $ketemu=mysqli_num_rows($login);
  $r=mysqli_fetch_array($login);
  $level = $r['level'];
  $blokir = $r['blokir'];
  $read_password = $r['password'];

  if($ketemu > 0)
  {
    if($blokir == "N"){
      // Apabila username dan password ditemukan (benar)
      if ($ketemu > 0){
        session_start();

        // bikin variabel session
        $_SESSION['namauser']    = $r['username'];
        $_SESSION['passuser']    = $r['password'];
        $_SESSION['namalengkap'] = $r['nama_lengkap'];
        $_SESSION['leveluser']   = $r['level'];
          
        // bikin id_session yang unik dan mengupdatenya agar slalu berubah 
        // agar user biasa sulit untuk mengganti password Administrator 

        $sid_lama = session_id();
    	  session_regenerate_id();
        $sid_baru = session_id();
        mysqli_query($koneksidb,"UPDATE users SET id_session='$sid_baru' WHERE username='$username'");
        $_SESSION['id_session']   = $r['id_session'];

          $inputsess  = "INSERT user_log SET username = '".$_SESSION['namauser']."',
                                        session_id = '".$_SESSION['id_session']."'";
            mysqli_query($koneksidb,$inputsess);

          header("location:media.php?module=beranda");
      }
    }
   else{
      echo "<script>alert('Akun Anda sudah di blokir'); window.location = 'index.php'</script>";
    }
  }
  else{
    // echo "<script>alert('Password yang Anda masukkan salah'); window.location = 'index.php'</script>";
    echo "<script>alert('Password yang Anda masukkan salah $username $password'); window.location = 'index.php'</script>";
    // echo $read_password;
  }
?>
