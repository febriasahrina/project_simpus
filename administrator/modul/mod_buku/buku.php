<?php
//session_start();
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
     $aksi = "modul/mod_buku/aksi_buku.php";   
     $act = isset($_GET['act']) ? $_GET['act'] : '';
     $dataKode = buatKode("buku", "B");
     switch($act){
         default:
               echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=buku\">Data Buku</a>
            </li>
        </ul>
    </div>"; 
     echo "<div class=\"row\">
       <div class=\"box col-md-12\">
       <div class=\"box-inner\">
    <div class=\"box-header well\" data-original-title=\"\">
        <h2><i class=\"glyphicon glyphicon-user\"></i> Data Buku</h2>

        <div class=\"box-icon\">
            
            <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                    class=\"glyphicon glyphicon-chevron-up\"></i></a>
            <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i class=\"glyphicon glyphicon-remove\"></i></a>
        </div>
    </div>
       <div class=\"box-content\">
       <div class=\"alert alert-info\"><button class=\"btn btn-success\" onclick=window.location.href=\"?module=buku&act=tambahbuku\">Tambah Data</button></div>
       ";
echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">
       <thead>
    <tr>
        <th>No.</th>    
        <th>Judul</th>
        <th>Subyek</th>
        <th>Penerbit</th>
        <th>Rak</th>
        <th>Action</th> 
    </tr>
    </thead>
    <tbody>"; 
   $query  = "SELECT buku.kd_buku,buku.judul, buku.subyek, penerbit.nm_penerbit, kategori.nm_kategori, pengadaan.jumlah, pengadaan.kd_buku FROM buku, penerbit, kategori, pengadaan WHERE buku.kd_penerbit=penerbit.kd_penerbit AND buku.kd_kategori=kategori.kd_kategori AND buku.kd_buku = pengadaan.kd_buku ORDER BY buku.kd_buku ASC ";
   $tampil = mysqli_query($koneksidb,$query);
    $no = 1;
    while ($tyo = mysqli_fetch_array($tampil)):
         
         echo "<tr><td>$no</td>
             <td>$tyo[judul]</td>
             <td>$tyo[subyek]</td>
             <td>$tyo[nm_penerbit]</td>
             <td>$tyo[nm_kategori]</td>
            ";
        echo "           
        <td>
            <a class=\"btn btn-info btn-xs\" href=\"?module=buku&act=editbuku&kd_buku=$tyo[kd_buku]\">
                <i class=\"glyphicon glyphicon-edit icon-white\"></i>
                
            </a>
            <a class=\"btn btn-danger btn-xs\" href=\"$aksi?module=buku&act=hapus&kd_buku=$tyo[kd_buku]\" onclick=\"return confirm('Apakah Anda yakin mengahpus data ini?')\">
                <i class=\" glyphicon glyphicon-trash icon-white\"></i>
               
            </a>
                   </td>    
             </tr>";
       $no++; 
   endwhile;
        echo "</tbody></table>
       </div><!-- box content -->
       </div><!--box inner -->
       </div><!--box col-md-12 -->
       </div><!-- row -->";
        break;        


  case "tambahbuku":
            echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=buku\">Data Buku</a>
            </li>
        </ul>
    </div>";
        
//form tambah  
  echo "<div class=\"row\">
    <div class=\"box col-md-12\">
        <div class=\"box-inner\">
            <div class=\"box-header well\" data-original-title=\"\">
                <h2><i class=\"glyphicon glyphicon-edit\"></i> Form Add Buku</h2>

                <div class=\"box-icon\">
                 
                    <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-chevron-up\"></i></a>
                    <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-remove\"></i></a>
                </div>
            </div>
            <div class=\"box-content\">
                <form role=\"form\" class=\"cmxform\" id=\"form1\" method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=buku&act=input\">
                    <div class=\"form-group\">
                        <label>Kode Buku</label>
                        <input type=\"text\" class=\"form-control\"  name=\"kd_buku\" placeholder=\"Kode Buku\" value=\"$dataKode\" readonly=\"readonly\">
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Judul</label>
                        <input type=\"text\" class=\"form-control\" name=\"judul\" id=\"judul\"  placeholder=\"Judul\" required>
                    </div>

                    <div class=\"form-group\">
                        <label>Asal Buku</label>
                        <input type=\"text\" class=\"form-control\" name=\"asal_buku\" id=\"asal_buku\"  placeholder=\"asal buku\" required>
                    </div>

                    <div class=\"form-group\">
                        <label>Tanggal Pengadaan</label>
                        <input type=\"date\" class=\"form-control\" name=\"tgl_pengadaan\" required>
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Subyek</label>
                        <input type=\"text\" class=\"form-control\" name=\"subyek\" id=\"subyek\" placeholder=\"subyek\" required>
                    </div>
                    
                    <div class=\"form-group\">
                        <label>ISBN</label>
                        <input type=\"text\" class=\"form-control\" name=\"isbn\" id=\"isbn\" placeholder=\"isbn\">
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Halaman</label>
                        <input type=\"text\" class=\"form-control\" name =\"halaman\" placeholder=\"Halaman\" />
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Jumlah</label>
                        <input type=\"text\" class=\"form-control\" name=\"jumlah\" required placeholder=\"Jumlah\">
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Tahun Terbit</label>
                        <input type=\"text\" class=\"form-control\" name=\"tahun_terbit\" placeholder=\"Tahun terbit\" required>
                    </div>
                    
                    <div class=\"form-group\">
                        <label></label>
                        
                        <input type=\"hidden\" name=\"fupload\" size=\"50\"> 
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Keterangan</label>
                        <textarea class=\"form-control\" name=\"sinopsis\" rows=\"5\"></textarea>
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Penerbit</label>
                        <div class=\"controls\">
                        <select data-rel='chosen' name=\"penerbit\">
                        <option value=\"0\">-Pilih Data-</option>";
             
            $query = "SELECT * FROM penerbit ORDER BY nm_penerbit"; 
            $hasil = mysqli_query($koneksidb,$query);
            while($r = mysqli_fetch_array($hasil)){
                echo "<option value=\"$r[kd_penerbit]\">$r[nm_penerbit]</option>";
            }
        echo" </select>              
            </div>
         </div>";
        
        echo "<div class=\"form-group\">
                <label>Kategori</label>
                <div class=\"controls\">
                   <select data-rel='chosen' name=\"kategori\">
                <option value=\"0\">-Pilih Data-</option>";
        
        $kategori = "SELECT * FROM kategori ORDER BY nm_kategori";
        $tampil = mysqli_query($koneksidb,$kategori);
        while($kt= mysqli_fetch_array($tampil)){
            echo "<option value=\"$kt[kd_kategori]\">$kt[nm_kategori]</option>";
        }
        
        echo "</select>
            </div>
            </div>";
        echo "

                    <button type=\"submit\" class=\"btn btn-default\">Save</button> | 
                    <button type=\"button\" class=\"btn btn-warning\" onclick=\"self.history.back()\">Cancel</button>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->";       
    break;
    
    
    case "editbuku":
        $query="SELECT * FROM buku, pengadaan WHERE buku.kd_buku='$_GET[kd_buku]' AND pengadaan.kd_buku='$_GET[kd_buku]'";
        $hasil = mysqli_query($koneksidb,$query);
        $r = mysqli_fetch_array($hasil);
        $dataKode = $r['kd_buku'];
        $kd_penerbit = $r['kd_penerbit'];
        $kd_kategori = $r['kd_kategori'];
        
    echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=buku\">Data Buku</a>
            </li>
        </ul>
    </div>";
        
//form EdiT 
  echo "<div class=\"row\">
    <div class=\"box col-md-12\">
        <div class=\"box-inner\">
            <div class=\"box-header well\" data-original-title=\"\">
                <h2><i class=\"glyphicon glyphicon-edit\"></i> Form Add Buku</h2>

                <div class=\"box-icon\">
                 
                    <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-chevron-up\"></i></a>
                    <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-remove\"></i></a>
                </div>
            </div>
            <div class=\"box-content\">
                <form role=\"form\" class=\"cmxform\" id=\"form1\" method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=buku&act=update\">
                    <input type=\"hidden\" name=\"Kode\" value=\"$r[kd_buku]\">
                    <div class=\"form-group\">
                        <label>Kode Buku</label>
                        <input type=\"text\" class=\"form-control\"  name=\"kd_buku\" placeholder=\"Kode Buku\" value=\"$dataKode\" readonly=\"readonly\">
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Judul</label>
                        <input type=\"text\" class=\"form-control\" name=\"judul\" id=\"judul\"  placeholder=\"Judul\" value=\"$r[judul]\" required>
                    </div>

                    <div class=\"form-group\">
                        <label>Asal Buku</label>
                        <input type=\"text\" class=\"form-control\" name=\"asal_buku\" id=\"asal_buku\"  placeholder=\"asal buku\" value=\"$r[asal_buku]\" required>
                    </div>

                    <div class=\"form-group\">
                        <label>Tanggal Pengadaan</label>
                        <input type=\"date\" class=\"form-control\" name=\"tgl_pengadaan\" value=\"$r[tgl_pengadaan]\" required>
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Subyek</label>
                        <input type=\"text\" class=\"form-control\" name=\"subyek\" id=\"subyek\" placeholder=\"subyek\" value=\"$r[subyek]\" required>
                    </div>
                    
                    <div class=\"form-group\">
                        <label>ISBN</label>
                        <input type=\"text\" class=\"form-control\" name=\"isbn\" id=\"isbn\" placeholder=\"isbn\" value=\"$r[isbn]\">
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Halaman</label>
                        <input type=\"text\" class=\"form-control\" name =\"halaman\" placeholder=\"Halaman\"  value=\"$r[halaman]\"/>
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Jumlah</label>
                        <input type=\"text\" class=\"form-control\" name=\"jumlah\" required placeholder=\"Jumlah\"value=\"$r[jumlah]\">
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Tahun Terbit</label>
                        <input type=\"text\" class=\"form-control\" name=\"tahun_terbit\" placeholder=\"Tahun terbit\"  value =\"$r[th_terbit]\" required>
                    </div>";
  echo "
                    
                    <div class=\"form-group\">
                        <label>Keterangan</label>
                        <textarea class=\"form-control\" name=\"sinopsis\" rows=\"5\">$r[sinopsis]</textarea>
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Penerbit</label>
                        <div class=\"controls\">
                        <select data-rel='chosen' name=\"penerbit\">
                        <option value=\"0\">-Pilih Data-</option>";
             
            $query = "SELECT * FROM penerbit ORDER BY nm_penerbit"; 
            $hasil = mysqli_query($koneksidb,$query);
            while($r = mysqli_fetch_array($hasil)){
                if ($r[0] ==$kd_penerbit) {
                        echo "<option value='$r[0]' selected>$r[1]</option>";
                    } 
                else {
                    echo "<option value='$r[0]'>$r[1]</option>";
                }
            }
        echo" </select>              
            </div>
         </div>";
        
        echo "<div class=\"form-group\">
                <label>Kategori</label>
                <div class=\"controls\">
                   <select data-rel='chosen' name=\"kategori\">";
        if($r['kd_kategori']==0){
            echo "<option value=\"0\" selected>-Pilih Kategori</option>";
        }
        
        $query2 = "SELECT * FROM kategori ORDER BY nm_kategori";
        $tampil = mysqli_query($koneksidb,$query2);
        while($k=mysqli_fetch_array($tampil)){
           if ($k[0] ==$kd_kategori) {
                    echo "<option value='$k[0]' selected>$k[1]</option>";
                } 
            else {
                echo "<option value='$k[0]'>$k[1]</option>";
            }
        }
        
        
        echo "</select>
            </div>
            </div>";
        echo "

                    <button type=\"submit\" class=\"btn btn-default\">Save</button> | 
                    <button type=\"button\" class=\"btn btn-warning\" onclick=\"self.history.back()\">Cancel</button>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->";       
    break;
 }
}