<?php
include_once "../config/inc.connection.php";
include_once "../config/inc.library.php";

# SKRIP MEMBACA DATA TRANSAKSI 
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];
}
else {
	echo "Nomor Pinjam (Kode) tidak ditemukan";
	exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Nota Pinjam </title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body onLoad="window.print()">

<h2> PERPUSTAKAN UNIVERSITAS SUMATERA UTARA</h2>
<table width="600" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="120"><strong>Judul </strong></td>
    <td width="10">:</td>
    <td width="448">Laporan Peminjaman Buku Bulanan</td>
  </tr>
</table>

    <br>
<table width="800" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="85" bgcolor="#CCCCCC"><strong>No Pinjam </strong></td>
    <td width="150" bgcolor="#CCCCCC"><strong>Tgl. Pinjam </strong></td>
    <td width="150" bgcolor="#CCCCCC"><strong>Mahasiswa </strong></td>
    <td width="150" bgcolor="#CCCCCC"><strong>Buku </strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Status </strong></td>
    
  </tr>
<?php
$totalPinjam	= 0;
// Menampilkan daftar Buku pinjaman
$notaSql = "SELECT * FROM vlapbln";
$notaQry = mysqli_query($koneksidb,$notaSql)  or die ("Query list salah : ".mysqli_error());
$nomor  = 0;  
while ($notaData = mysqli_fetch_array($notaQry)) {
	$nomor++;
	//$totalPinjam	= $totalPinjam + $notaData['jumlah'];
?>
  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $notaData['no_pinjam']; ?> </td>
    <td> <?php echo $notaData['tgl_pinjam']; ?> </td>
    <td> <?php echo $notaData['nim']."/ ".$notaData['nm_mahasiswa']; ?> </td>
    <td> <?php echo $notaData['judul']; ?> </td>
    <td> <?php echo $notaData['status']; ?> </td>

  </tr>
<?php } ?>
</table>
</body>
</html>
