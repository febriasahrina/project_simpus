<?php
# Membaca form filter Siswa
$kodeSiswa 	= isset($_POST['cmbSiswa']) ? $_POST['cmbSiswa'] : 'Semua'; 

# Membuat Filter Siswa
if($kodeSiswa=="Semua") {
	// Jika memilih siswa
	$filterSQL = "";
}
else {
	$filterSQL = "WHERE nim ='$kodeSiswa'";
}

?>
<h2> LAPORAN PEMINJAMAN PER SISWA </h2>

<form id="form1" name="form1" method="post" action="">
  <table width="500" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="2" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="84">Mahasiswa</td>
      <td width="401">:	  
		<select data-rel="chosen" name="cmbSiswa">
		<option value="Semua">Semua</option>
		<?php
		// Skrip menampilkan data Siswa ke ComboBo (ListMenu)
		$bacaSql = "SELECT * FROM mahasiswa ORDER BY nim";
		$bacaQry = mysqli_query($koneksidb,$bacaSql) or die ("Gagal Query".mysqli_error());
		while ($bacaData = mysqli_fetch_array($bacaQry)) {
			if ($bacaData['nim'] == $kodeSiswa) {
				$cek = " selected";
			} else { $cek=""; }
			
			echo "<option value='$bacaData[nim]' $cek> $bacaData[nim] - $bacaData[nm_mahasiswa]</option>";
		}
    
		?>
		</select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" id="btnTampil" value="Tampil" /></td>
    </tr>
  </table>
</form>
<table class="table-list" width="1000" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="85" bgcolor="#CCCCCC"><strong>No. Pinjam </strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>Tgl. Pinjam </strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>Tgl. Kembali </strong></td>
    <td width="207" bgcolor="#CCCCCC"><strong>Mahasiswa</strong></td>
    <td width="207" bgcolor="#CCCCCC"><strong>Buku</strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>Admin</strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Status</strong></td>
  </tr>
  
<?php 
// Skrip menampilkan data Peminjaman dengan filter Bulan

  $mysqli = "SELECT * FROM vlapsiswa $filterSQL";
  $myQry = mysqli_query($koneksidb,$mysqli)  or die ("Query salah : ".mysqli_error());
  $nomor = 0;  
  while ($myData = mysqli_fetch_array($myQry)) {
  	$nomor++;		
    if ($filterSQL!="") {
    $kode = $myData['nim'];
    }
    else{
     $kode = "Semua"; 
    }
  ?>

    <tr>
      <td> <?php echo $nomor; ?> </td>
      <td> <?php echo $myData['no_pinjam']; ?> </td>
      <td> <?php echo IndonesiaTgl($myData['tgl_pinjam']); ?> </td>
      <td> <?php echo IndonesiaTgl($myData['tgl_kembali']); ?> </td>
      <td> <?php echo $myData['nim']."/ ".$myData['nm_mahasiswa']; ?> </td>
      <td> <?php echo $myData['judul']; ?> </td>
      <td> <?php echo $myData['username']; ?> </td>
      <td> <?php echo $myData['status']; ?> </td>
    </tr>   


<?php } ?>
</table>
<a class="btn btn-primary col-md-1" target="_blank" href="cetak/lapsiswa.php?kode=<?php echo $kode; ?>" >
                <i class="glyphicon glyphicon-delete icon-white"></i>
                PRINT
            </a>
