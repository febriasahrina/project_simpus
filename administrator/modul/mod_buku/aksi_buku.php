<?php
session_start();
if(empty($_SESSSION['namauser']) AND empty($_SESSION['passuser'])){
    echo "<link href='http://fonts.googleapis.com/css?family=Creepster|Audiowide' rel='stylesheet' type='text/css'>
        <link href=\"../../css/error.css\" rel='stylesheet' type=\"text/css\" />
            <p class=\"error-code\">
                404
            </p>

            <p class=\"not-found\">Not<br/>Found</p>

            <div class=\"clear\"></div>
            <div class=\"content\">
                The page your are looking for is not found.
                <br>
                <a href=\"index.php\">Go Back</a>

        <br>
        <br>
</div>";
}
else{
     include "../../config/inc.connection.php";
    
     include "../../config/fungsi_thumbnail.php";
     include "../../config/inc.library.php";
     
     $module = $_GET['module'];
     $act = $_GET['act'];
     
     if($module=='buku' AND $act=='hapus'){
         $query = "SELECT gambar FROM buku WHERE kd_buku = '$_GET[kd_buku]'";
         $hapus = mysqli_query($koneksidb,$query);
         $r = mysqli_fetch_array($hapus);
         
         if($r['gambar']!=''){
             $namafile = $r['gambar']; 
             unlink("../../../foto_buku/$namafile");
             unlink("../../../foto_buku/small_$namafile");
             
             //hapus data buku dari database 
             mysqli_query($koneksidb,"DELETE FROM buku,pengadaan WHERE buku.kd_buku = '$_GET[kd_buku]' AND pengadaan.kd_buku = '$_GET[kd_buku]'");
         }
         else{
            mysqli_query($koneksidb,"DELETE FROM pengadaan WHERE pengadaan.kd_buku = '$_GET[kd_buku]'");
            mysqli_query($koneksidb,"DELETE FROM buku WHERE buku.kd_buku = '$_GET[kd_buku]'");
         }
         header("location:../../media.php?module=".$module);
     }
     
     elseif($module=='buku' AND $act=='input'){
        $kodeBaru   = buatKode("buku","B");
        $kodeBaru2 = buatKode("pengadaan","PG");
        $tgl_pengadaan = $_POST['tgl_pengadaan'];
        $asal_buku = $_POST['asal_buku'];
        $judul      = $_POST['judul']; 
        $subyek  = $_POST['subyek'];
        $isbn       = $_POST['isbn'];
        $halaman    = $_POST['halaman'];
        $jumlah     = $_POST['jumlah'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $sinopsis   = $_POST['sinopsis'];
        $penerbit   = $_POST['penerbit'];
        $kategori   = $_POST['kategori'];
        $namauser   = $_SESSION['namauser'];
       
        if(empty($lokasi_file)){
            $input = "INSERT buku SET kd_buku = '$kodeBaru', 
                                      judul = '$judul', 
                                      subyek = '$subyek', 
                                      isbn = '$isbn', 
                                      halaman = '$halaman', 
                                      th_terbit = '$tahun_terbit', 
                                      sinopsis = '$sinopsis',
                                      kd_penerbit = '$penerbit', 
                                      kd_kategori = '$kategori',
                                      username = '$namauser'";
            mysqli_query($koneksidb,$input) or die ("Query salah : ".mysqli_error());
            $input2 = "INSERT pengadaan SET no_pengadaan = '$kodeBaru2',
                                       tgl_pengadaan = '$tgl_pengadaan',
                                       kd_buku ='$kodeBaru', 
                                       asal_buku = '$asal_buku',
                                       jumlah = '$jumlah', 
                                       keterangan = '$sinopsis'";
            mysqli_query($koneksidb,$input2) or die ("Query salah : ".mysqli_error());
            header("location:../../media.php?module=".$module);
        }
        else{
            if($tipe_file !="image/jpeg" AND $tipe_file !="image/pjpeg"){
                echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=buku')</script>";
            }
            else{
                $folder = "../../../foto_buku/";
                $ukuran = 200;
                UploadFoto($nama_gambar,$folder,$ukuran);
                mysqli_query($koneksidb,"INSERT buku SET kd_buku = '$kodeBaru', 
                                      judul = '$judul', 
                                      subyek = '$subyek', 
                                      isbn = '$isbn', 
                                      halaman = '$halaman',
                                      th_terbit = '$tahun_terbit', 
                                      sinopsis = '$sinopsis', 
                                      gambar = '$nama_gambar',
                                      kd_penerbit = '$penerbit', 
                                      kd_kategori = '$kategori'");
            //mysqli_query($input,$koneksidb); 
            header("location:../../media.php?module=".$module);
            }
        }
     }
     
     //update buku 
     elseif($module=='buku' AND $act=='update'){
        $judul      = $_POST['judul']; 
        $tgl_pengadaan = $_POST['tgl_pengadaan'];
        $asal_buku = $_POST['asal_buku'];
        $subyek  = $_POST['subyek'];
        $isbn       = $_POST['isbn'];
        $halaman    = $_POST['halaman'];
        $jumlah     = $_POST['jumlah'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $sinopsis   = $_POST['sinopsis'];
        $penerbit   = $_POST['penerbit'];
        $kategori   = $_POST['kategori'];
        $Kode = $_POST['Kode'];
        $namauser   = $_SESSION['namauser'];
        
        
        $update2 = "UPDATE pengadaan SET tgl_pengadaan = '$tgl_pengadaan',
                                       asal_buku = '$asal_buku',
                                       jumlah = '$jumlah', 
                                       keterangan = '$sinopsis'
                                       WHERE kd_buku = '$Kode'";
        
        $update = "UPDATE buku SET    judul = '$judul', 
                                      subyek = '$subyek', 
                                      isbn = '$isbn', 
                                      halaman = '$halaman', 
                                      th_terbit = '$tahun_terbit', 
                                      sinopsis = '$sinopsis',
                                      kd_penerbit = '$penerbit', 
                                      kd_kategori = '$kategori',
                                      username = '$namauser'
                                      WHERE kd_buku = '$Kode'";
        mysqli_query($koneksidb,$update2) or die ("Query salah : ".mysqli_error());
        mysqli_query($koneksidb,$update) or die ("Query salah : ".mysqli_error());
        header("location:../../media.php?module=".$module); 
     }
}
?>