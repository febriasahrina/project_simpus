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
    include "../../config/inc.library.php";
    include "../../config/excel_reader2.php";
    $module = $_GET['module'];
    $act = $_GET['act'];
    
    //upload data 
    if($module=='siswa' AND $act=='input'){
        $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']); 
        
        //membaca jumlah baris excel 
        $baris = $data->rowcount($sheet_index=0);
        
        //nilai awal counter untuk jumlah data yang sukses dan yang gagal import 
        $sukses = 0; 
        $gagal = 0; 
        
        //import data excel mulai baris ke 2 
        for($i=2; $i<=$baris; $i++){
            //membaca data nim
            $nim = $data->val($i, 1);
            $nm_mahasiswa = $data->val($i, 2);
            $kelamin = $data->val($i, 3);
            $jurusan = $data->val($i, 4);
            $fakultas = $data->val($i, 5);
            
            //simpan data ke dalam database 
            $hasil = mysqli_query($koneksidb,"INSERT mahasiswa SET nim='$nim',
                                                   nm_mahasiswa='$nm_mahasiswa', 
                                                   kelamin = '$kelamin', 
                                                   jurusan = '$jurusan', 
                                                   fakultas = '$fakultas'");
            if($hasil)
                $sukses++;
            else
                $gagal++;
            
        }
      header("location:../../media.php?module=".$module);      
    }
    
    //input manual 
    elseif($module=='siswa' AND $act=='inputsiswa'){
        $nim = $_POST['nim'];
        $nm_mahasiswa = $_POST['nm_mahasiswa'];
        $kelamin = $_POST['kelamin'];
        $fakultas = $_POST['fakultas']; 
        $jurusan=$_POST['jurusan'];
        
        $input_siswa = "INSERT mahasiswa SET nim       = '$nim',
                                         nm_mahasiswa = '$nm_mahasiswa', 
                                         kelamin    = '$kelamin', 
                                         jurusan      = '$jurusan',
                                         fakultas  ='$fakultas'";
        
        mysqli_query($koneksidb,$input_siswa)or die("gagal simpan".mysqli_error());
        header("location:../../media.php?module=".$module);
        
    }
    
    elseif($module=='siswa' AND $act=='hapus'){
        $delete  = "DELETE FROM mahasiswa WHERE nim='$_GET[nim]'";
        mysqli_query($koneksidb,$delete);
        header("location:../../media.php?module=".$module);
    }
    
    elseif($module=='siswa' AND $act=='update'){
        $nim = $_POST['nim'];
        $nm_mahasiswa = $_POST['nm_mahasiswa'];
        $jurusan   = $_POST['jurusan'];
        $kelamin = $_POST['kelamin'];
        $fakultas = $_POST['fakultas'];
        
        $update = "UPDATE mahasiswa SET nm_mahasiswa = '$nm_mahasiswa', 
                                    jurusan = '$jurusan', 
                                    kelamin = '$kelamin', 
                                    fakultas='$fakultas' 
                        WHERE nim = '$nim'";
        mysqli_query($koneksidb,$update);
        header("location:../../media.php?module=".$module);
    }
}
?>