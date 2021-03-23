<?php

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
    
     # HAPUS DAFTAR barang DI TMP
if(isset($_GET['Act'])){
	if(trim($_GET['Act'])=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mysqli = "DELETE FROM tmp_pinjam WHERE id='".$_GET['id']."' AND username='".$_SESSION['namauser']."'";
		mysqli_query($koneksidb,$mysqli) or die ("Gagal kosongkan tmp".mysqli_error());
	}
	if(trim($_GET['Act'])=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}  
    global $rstok2;

    if(isset($_POST['btnInput'])){
       $cmbSiswa      = $_POST['cmbSiswa']; 
       $cmbBuku1       = $_POST['cmbBuku1'];
       if($cmbBuku1=="KOSONG"){
        echo "<script>alert('Anda belum memilih BUKU');</script>";
       }
       else{
       
         $vstok = "SELECT * FROM vstokbuku WHERE kd_buku = '$cmbBuku1'";
         $qvstok = mysqli_query($koneksidb,$vstok) or die ("Gagal kosongkan tmp".mysqli_error());
         while ($rstok = mysqli_fetch_array($qvstok)){
            if($rstok['stok']>0){
              $rstok2=1;
             //simpan ke dalam tmp 
             $tmpPinjam = "INSERT tmp_pinjam SET kd_buku = '$cmbBuku1',
                                                 username = '".$_SESSION['namauser']."'";
             mysqli_query($koneksidb,$tmpPinjam) or die ("Gagal Query tmp : ".mysqli_error());
            }
            else{
              $rstok2=2;
              echo "<script>alert('Stok buku yang Anda pilih 0');</script>";
            }
           }
          }
          if($rstok2==0){
          $tmpPinjam = "INSERT tmp_pinjam SET kd_buku = '$cmbBuku1',
                                                 username = '".$_SESSION['namauser']."'";
             mysqli_query($koneksidb,$tmpPinjam) or die ("Gagal Query tmp : ".mysqli_error());
           }
    }
     
    //btnSimpan
    if(isset($_POST['btnSimpan'])){ 
      $cmbSiswa      = $_POST['cmbSiswa']; 
      $cmbBuku1       = $_POST['cmbBuku1'];
      $lala = mysqli_query($koneksidb,"SELECT * FROM tmp_pinjam");
      $lala2 = mysqli_fetch_array($lala);
    if($cmbSiswa=="KOSONG"||$lala2[0]=="")
      {
        echo "<script>alert('Silahkan lengkapi data');</script>";
         // echo "<script>alert($tmp1);</script>"; 
      }
    else{
       
       $tgl_pinjam	= $_POST['tgl_pinjam'];
       $tgl_kembali	= $_POST['tgl_kembali'];
       $cmbSiswa      = $_POST['cmbSiswa']; 
       $cmbBuku1       = $_POST['cmbBuku1'];
        /*
        if($txtJumlah < 1 or $txtJumlah > 2){
            echo "<script>alert('Buku Maksimal 2, Bos!!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=media.php?module=peminjaman'>";
        }
        */
        
        
        $sqlCek="SELECT * FROM peminjaman WHERE nisn='$cmbSiswa' AND status='Pinjam'";
      	$qryCek=mysqli_query($koneksidb,$sqlCek) or die ("Eror Query".mysqli_error()); 
              
                $kodeBaru = buatKode("peminjaman","PJ");
		# SIMPAN KE DATABASE TABEL TMP_PINJAM
		// Jika jumlah error pesanError tidak ada, skrip di bawah dijalankan

		$Sql 	= "INSERT peminjaman SET nisn='$cmbSiswa',
                                                         no_pinjam='$kodeBaru',
                                                         tgl_pinjam = '". InggrisTgl($_POST['tgl_pinjam'])."',
                                                         tgl_kembali = '". InggrisTgl($_POST['tgl_kembali'])."',
                                                         username = '$_SESSION[namauser]'";
		$query = mysqli_query($koneksidb,$Sql) or die ("Gagal Query  : ".mysqli_error());	
                // Ambil semua data buku yang dipilih (diambil dari TMP) 
		$tmpSql ="SELECT * FROM tmp_pinjam ";
		$tmpQry = mysqli_query($koneksidb,$tmpSql) or die ("Gagal Query baca Tmp".mysqli_error());
		while ($tmpData = mysqli_fetch_array($tmpQry)) {
			// Membaca data dari tabel TMP
			$kode		= $tmpData['kd_buku'];
			//$jumlah		= $tmpData['jumlah'];
			
			// Masukkan semua buku dari TMP ke tabel peminjaman detil
			$itemSql = "INSERT INTO peminjaman_detil(no_pinjam, kd_buku) 
						VALUES ('$kodeBaru', '$kode')";
			mysqli_query($koneksidb,$itemSql) or die ("Gagal Query tuh: ".mysqli_error());
      }
       
      // Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_pinjam";
    
     
		    mysqli_query($koneksidb,$hapusSql) or die ("Gagal kosongkan tmp".mysqli_error());
                echo "<script>alert('Peminjaman BERHASIL...');</script>";
                // echo "<meta http-equiv='refresh' content='0; url=media.php?module=datapinjam'>";
        
    }}
}
     //deklarasi form 
     $pinjam = date("d-m-Y");
     $tiga_hari = mktime(0,0,0,date("n"),date("j")+3,date("Y"));
     $kembali	= date("d-m-Y", $tiga_hari);
     
     $dataJumlah= isset($_POST['txtJumlah']) ? $_POST['txtJumlah'] : '1';
 ?>
<!-- <script type="text/javascript">
function validasi_input(){
    if (form.cmbSiswa.value =="KOSONG"){
       alert("Anda belum memilih SISWA!");
       form.cmbSiswa.focus();
       return (false);
    }
return (true);

}
</script> -->
      <div>
        <ul class="breadcrumb">
            <li>
                <a href="?module=beranda">Home</a>
            </li>
            <li>
                <a href="?module=peminjaman">Data Peminjaman</a>
            </li>
        </ul>
    </div>
<div class="row"> 
    <div class="box col-md-12">
        <div class="box-inner">
             <div class="box-header well">
                <h2><i class="glyphicon glyphicon-th"></i> Data Peminjaman</h2>

                <div class="box-icon">
                    
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form class="form-inline" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">   
                <table><br>
    <tr>
      <td bgcolor="#CCCCCC"><strong>INPUT BUKU </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
        <td><strong>Buku </strong></td>
      <td><strong>:</strong></td>
      <td><select data-rel="chosen" name="cmbBuku1" >
              <option value="KOSONG">-Pilih Data-</option>
              <?php
	  $bacaSql = "SELECT * FROM buku ORDER BY judul";
	  $bacaQry = mysqli_query($koneksidb,$bacaSql) or die ("Gagal Query".mysqli_error());
	  while ($bacaData = mysqli_fetch_array($bacaQry)) {
		if ($bacaData['kd_buku'] == $dataBuku) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[kd_buku]' $cek>[ $bacaData[judul] ]  $bacaData[nisbn]</option>";
	  }
	  ?>
          </select> <input name="btnInput" type="submit" class="btn btn-info" value="INPUT BUKU " /> </td>
    </tr>
     <tr>
      <td><strong>DAFTAR BUKU </strong></td>
      <td>&nbsp;</td>
      <td>
	  <table  class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="6%" bgcolor="#CCCCCC"><strong>No</strong></td>
          <td width="9%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
          <td width="51%" bgcolor="#CCCCCC"><strong>Judul Buku </strong></td>
          <td width="26%" bgcolor="#CCCCCC"><strong>Subyek</strong></td>
          <td width="8%" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
		
	<?php
	// Skrip menampilkan data TMP Buku
	$tmpSql ="SELECT tmp.*, buku.judul, buku.subyek FROM tmp_pinjam As tmp
		  LEFT JOIN buku ON tmp.kd_buku = buku.kd_buku ORDER BY id";
	$tmpQry = mysqli_query($koneksidb,$tmpSql) or die ("Gagal Query Tmp".mysqli_error());
	$nomor=0; 
  while($tmpData = mysqli_fetch_array($tmpQry)) {
		$nomor++;
		$id	=  $tmpData['id'];
	?>
	
        <tr>
          <td> <?php echo $nomor; ?> </td>
          <td> <?php echo $tmpData['kd_buku']; ?> </td>
          <td> <?php echo $tmpData['judul']; ?> </td>
          <td> <?php echo $tmpData['subyek']; ?> </td>
          <td><a href="media.php?module=peminjaman&Act=Delete&id=<?php echo $id; ?>" target="_self">Batal</a></td>
        </tr>
		
	<?php } ?>
	

      </table>
	  </td>
    </tr>
     <tr>
                    <td colspan="3">&nbsp;</td>
                   </tr>
                   <tr>
                        <td bgcolor="#CCCCCC"><strong>Data Pinjam </strong></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                   </tr>
                   <tr>
                       <td>No Pinjam</td>
                       <td><strong>:</strong></td>
                       <td><input type="text" class="form-control" name="nomor" size="20" value="<?php echo buatKode("peminjaman","PJ"); ?>" disabled></td>
                   </tr>
                   <tr>
                       <td>Tgl.Pinjam</td>
                       <td><strong>:</strong></td>
                       <td><input type="hidden" name="tgl_pinjam" value="<?php echo $pinjam; ?>"><?php echo $pinjam; ?></td>
                   </tr>
                   <tr>
                       <td>Tgl.Kembali</td>
                       <td><strong>:</strong></td>
                       <td><input type="hidden" name="tgl_kembali" value="<?php echo $kembali; ?>"><?php echo $kembali; ?></td>
                   </tr>
                   <tr>
                       <td>Siswa</td>
                       <td><strong> : </strong></td>
                       <td><select data-rel="chosen" name="cmbSiswa" required>
          <option value="KOSONG">....</option>
          <?php
    $bacaSql = "SELECT * FROM mahasiswa ORDER BY nim";
    $bacaQry = mysqli_query($koneksidb,$bacaSql) or die ("Gagal Query".mysqli_error());
    while ($bacaData = mysqli_fetch_array($bacaQry)) {
    if ($bacaData['nim'] == $dataSiswa) {
      $cek = " selected";
    } else { $cek=""; }
    
    echo "<option value='$bacaData[nim]' $cek>[ $bacaData[nim] ]  $bacaData[nm_mahasiswa]</option>";
    }
    ?>
        </select></td>
    </tr>       
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" class="btn btn-warning" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
  </table>
  <br>
</form>
                </table>
              
            </div>
        </div>
    </div>
</div>
