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
    Ada yang salah di codingnya nih
    <br>
    <a href=\"index.php\">Go Back</a>
    
    <br>
    <br>
</div>";
}
else{
     include "../../config/inc.connection.php";
     include "../../config/inc.library.php";
    
     $module = $_GET['module'];
     $act = $_GET['act'];
     // $kd_buku = $_GET['kd_buku'];
    
     //hapus data
    if($module=='pengadaan' AND $act=='hapus'){
        mysqli_query($koneksidb,"DELETE FROM pengadaan WHERE pengadaan.kd_buku = '$_GET[kd_buku]'");
        mysqli_query($koneksidb,"DELETE FROM buku WHERE buku.kd_buku = '$_GET[kd_buku]'");
        header("location:../../media.php?module=".$module);
    }
    
    //input data 
    elseif($module=='pengadaan' AND $act=='input'){
        $kodeBaru = buatKode("pengadaan","PG");
        $tgl_pengadaan = $_POST['tgl_pengadaan'];
        $buku = $_POST['buku'];
        $asal_buku = $_POST['asal_buku'];
        $jumlah = $_POST['jumlah'];
        $keterangan = $_POST['keterangan'];

        $queryp = "SELECT kd_buku FROM pengadaan WHERE kd_buku = '$buku'";
        $cp = mysqli_query($koneksidb,$queryp) or die ("Gagal kosongkan tmp".mysqli_error());
        $rp = mysqli_fetch_array($cp);
        $kodebukup = $rp['kd_buku'];

        if($kodebukup == $buku){
         // echo "<script>alert('Buku tersebut sudah di Input');</script>";
           echo "<script>window.alert('Gagal! Buku tersebut sudah di Input');
              window.location=('../../media.php?module=pengadaan')</script>";
        }
        
        else{
         $input = "INSERT pengadaan SET no_pengadaan = '$kodeBaru',
                                               tgl_pengadaan = '$tgl_pengadaan',
                                               kd_buku ='$buku', 
                                               asal_buku = '$asal_buku',
                                               jumlah = '$jumlah', 
                                               keterangan = '$keterangan'";
                mysqli_query($koneksidb,$input);
                header("location:../../media.php?module=".$module);
        }
        
    }
    elseif($module=='pengadaan' AND $act=='editpengadaan'){
        $no_pengadaan = $_POST['no_pengadaan'];
        $tgl_pengadaan = $_POST['tgl_pengadaan'];
        $buku = $_POST['buku'];
        $asal_buku = $_POST['asal_buku'];
        $jumlah = $_POST['jumlah'];
        $keterangan = $_POST['keterangan'];

        $queryup = "UPDATE pengadaan SET tgl_pengadaan = '$tgl_pengadaan',
                                               kd_buku ='$buku', 
                                               asal_buku = '$asal_buku',
                                               jumlah = '$jumlah', 
                                               keterangan = '$keterangan'
                                               WHERE no_pengadaan = '$no_pengadaan'";
        $up = mysqli_query($koneksidb,$queryup) or die ("Gagal kosongkan tmp".mysqli_error());
        header("location:../../media.php?module=".$module);
        }
}

