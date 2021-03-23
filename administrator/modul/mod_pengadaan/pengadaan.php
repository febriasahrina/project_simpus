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
   
     $aksi = "modul/mod_pengadaan/aksi_pengadaan.php";   
     $act = isset($_GET['act']) ? $_GET['act'] : '';
     $dataKode = buatKode("pengadaan", "PG");
     switch($act){
         default:
               echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=pengadaan\">Data Pengadaan</a>
            </li>
        </ul>
    </div>"; 
     echo "<div class=\"row\">
       <div class=\"box col-md-12\">
       <div class=\"box-inner\">
    <div class=\"box-header well\" data-original-title=\"\">
        <h2><i class=\"glyphicon glyphicon-user\"></i> Data Pengadaan</h2>

        <div class=\"box-icon\">
            
            <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                    class=\"glyphicon glyphicon-chevron-up\"></i></a>
            <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i class=\"glyphicon glyphicon-remove\"></i></a>
        </div>
    </div>
       <div class=\"box-content\">
       <div class=\"alert alert-info\"><button class=\"btn btn-success\" onclick=window.location.href=\"?module=pengadaan&act=tambahpengadaan\">Tambah Data</button></div>
       ";
echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">
       <thead>
    <tr>
        <th>No.</th>     
        <th width=\"320\">Buku</th>
        <th>Asal Buku</th>
        <th>Tanggal Pengadaan</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
        <th>Action</th> 
    </tr>
    </thead>
    <tbody>"; 
   $query  = "SELECT buku.judul,buku.kd_buku,pengadaan.kd_buku,pengadaan.no_pengadaan,pengadaan.asal_buku,pengadaan.tgl_pengadaan,pengadaan.jumlah,pengadaan.keterangan FROM pengadaan,buku WHERE buku.kd_buku=pengadaan.kd_buku";
   $tampil = mysqli_query($koneksidb,$query);
    $no = 1;
    while ($tyo = mysqli_fetch_array($tampil)):
         echo "<tr><td>$no</td>
             <td>$tyo[judul]</td>
             <td>$tyo[asal_buku]</td>
             <td>$tyo[tgl_pengadaan]</td>
             <td>$tyo[jumlah]</td>
             <td>$tyo[keterangan]</td>";
        echo "           
                   <td>
            <a class=\"btn btn-info\" href=\"?module=pengadaan&act=editpengadaan&no_pengadaan=$tyo[no_pengadaan]\">
                <i class=\"glyphicon glyphicon-edit icon-white\"></i>
                Edit
            </a>
            <a class=\"btn btn-danger\" href=\"$aksi?module=pengadaan&act=hapus&kd_buku=$tyo[kd_buku]\" onclick=\"return confirm('Apakah Anda yakin mengahpus data ini?')\">
                <i class=\"glyphicon glyphicon-delete icon-white\"></i>
                Delete
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

   
    case "tambahpengadaan":
            echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=pengadaan\">Data Pengadaan</a>
            </li>
        </ul>
    </div>";
        
    //form tambah  
  echo "<div class=\"row\">
    <div class=\"box col-md-12\">
        <div class=\"box-inner\">
            <div class=\"box-header well\" data-original-title=\"\">
                <h2><i class=\"glyphicon glyphicon-edit\"></i> Form Add Pengadaan</h2>

                <div class=\"box-icon\">
                 
                    <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-chevron-up\"></i></a>
                    <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-remove\"></i></a>
                </div>
            </div>
            <div class=\"box-content\">
                <form role=\"form\" class=\"cmxform\" id=\"form1\" method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=pengadaan&act=input\">
                    <div class=\"form-group\">
                        <label>No Pengadaan</label>
                        <input type=\"text\" class=\"form-control\"  name=\"no_pengadaan\" placeholder=\"No Pengadaan\" value=\"$dataKode\" readonly=\"readonly\">
                    </div>
                    
                    <div class=\"form-group\">
                        <label>Tanggal Pengadaan</label>
                        <input type=\"date\" class=\"form-control\" name=\"tgl_pengadaan\" required>
                    </div>";
                    
  
                echo" <div class=\"form-group\">
                        <label>Buku</label>
                        <div class=\"controls\">
                        <select data-rel='chosen' name=\"buku\">
                        <option value=\"0\">-Pilih Data-</option>";
                        $query = "SELECT * FROM buku ORDER BY judul"; 
                        $hasil = mysqli_query($koneksidb,$query);
                        while($r = mysqli_fetch_array($hasil)){
                            echo "<option value=\"$r[kd_buku]\">$r[judul]</option>";
                        }
                    echo" </select>              
                        </div>
                     </div>";  
                    
                    
            echo "<div class=\"form-group\">
                        <label>Asal Buku</label>
                        <input type=\"text\" class=\"form-control\" name=\"asal_buku\"   placeholder=\"Asal Buku\" required>
             </div>
             
             <div class=\"form-group\">
                        <label>Jumlah</label>
                        <input type=\"text\" class=\"form-control\" name=\"jumlah\"   placeholder=\"Jumlah\" required>
             </div>
             
             
             <div class=\"form-group\">
                        <label>Keterangan</label>
                        <input type=\"text\" class=\"form-control\" name=\"keterangan\"   placeholder=\"Keterangan\" required>
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
    case "editpengadaan":
        $query="SELECT * FROM pengadaan WHERE no_pengadaan='$_GET[no_pengadaan]'";
        $hasil = mysqli_query($koneksidb,$query);
        $r = mysqli_fetch_array($hasil);
        $dataKode = $r['no_pengadaan'];
        $kd_buku = $r['kd_buku'];
        
    echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=pengadaan\">Data Pengadaan</a>
            </li>
        </ul>
    </div>";

    //form edit  
  echo "<div class=\"row\">
    <div class=\"box col-md-12\">
        <div class=\"box-inner\">
            <div class=\"box-header well\" data-original-title=\"\">
                <h2><i class=\"glyphicon glyphicon-edit\"></i> Form Edit Pengadaan</h2>

                <div class=\"box-icon\">
                 
                    <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-chevron-up\"></i></a>
                    <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-remove\"></i></a>
                </div>
            </div>
            <div class=\"box-content\">
                <form role=\"form\" class=\"cmxform\" id=\"form1\" method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=pengadaan&act=editpengadaan\">
                    <div class=\"form-group\">
                        <label>No Pengadaan</label>
                        <input type=\"text\" class=\"form-control\"  name=\"no_pengadaan\" placeholder=\"No Pengadaan\" value=\"$dataKode\" readonly=\"readonly\">
                    </div>
                    
                    ";
                    
  
                echo" <div class=\"form-group\">
                        <label>Buku</label>
                        <div class=\"controls\">
                        <select data-rel='chosen' name=\"buku\" >
                        <option value=\"0\">-Pilih Data-</option>";
                        $query = "SELECT * FROM buku ORDER BY judul"; 
                        $hasil = mysqli_query($koneksidb,$query);
                        while($r2 = mysqli_fetch_array($hasil)){
                            if ($r2[0] ==$kd_buku) {
                                echo "<option value='$r2[0]' selected>$r2[1]</option>";
                            } 
                            else {
                                echo "<option value='$r2[0]'>$r2[1]</option>";
                            }
                        }
                    echo" </select>              
                        </div>
                     </div>";  
                    
                    
            echo "<div class=\"form-group\">
                        <label>Asal Buku</label>
                        <input type=\"text\" class=\"form-control\" name=\"asal_buku\"   placeholder=\"Asal Buku\" value=\"$r[asal_buku]\" required>
                    </div>

                    <div class=\"form-group\">
                        <label>Tanggal Pengadaan</label>
                        <input type=\"date\" class=\"form-control\" name=\"tgl_pengadaan\" value=\"$r[tgl_pengadaan]\"required>
                    </div>

             
             <div class=\"form-group\">
                        <label>Jumlah</label>
                        <input type=\"text\" class=\"form-control\" name=\"jumlah\"   placeholder=\"Jumlah\" value=\"$r[jumlah]\"required>
             </div>
             
             
             <div class=\"form-group\">
                        <label>Keterangan</label>
                        <input type=\"text\" class=\"form-control\" name=\"keterangan\"   placeholder=\"Keterangan\" value=\"$r[keterangan]\" required>
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
?>