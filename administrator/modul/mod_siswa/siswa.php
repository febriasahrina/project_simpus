<script src="jquery-latest.js"></script>
<script>
var refreshId = setInterval(function()
{
$('#responsecontainer').load('oo.php');
}, 1000);
</script>

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
    $aksi = "modul/mod_siswa/aksi_siswa.php";   
     $act = isset($_GET['act']) ? $_GET['act'] : '';
     
     switch($act){
         default:
               echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=siswa\">Data Mahasiswa</a>
            </li>
        </ul>
    </div>"; 
     echo "<div class=\"row\">
       <div class=\"box col-md-12\">
       <div class=\"box-inner\">
    <div class=\"box-header well\" data-original-title=\"\">Data Mahasiswa</h2>

        <div class=\"box-icon\">
            
            <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                    class=\"glyphicon glyphicon-chevron-up\"></i></a>
            <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i class=\"glyphicon glyphicon-remove\"></i></a>
        </div>
    </div>
       <div class=\"box-content\">
       <div class=\"alert alert-info\">  <button class=\"btn btn-success\" onclick=window.location.href=\"?module=siswa&act=tambah\">Tambah Data</button></div>
       ";
echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">
       <thead>
    <tr>
         <th>No.</th>
         <th>NIM</th>
        <th>Nama Mahasiswa</th>
        <th>Kelamin</th>
        <th width=\"200px\">Fakultas</th>
        <th>Jurusan</th>
        <th>Action</th> 
    </tr>
    </thead>
    <tbody>";
    $query  = "SELECT * FROM mahasiswa ORDER BY nm_mahasiswa ASC";
   $tampil = mysqli_query($koneksidb,$query);
    $no = 1;
    while ($tyo = mysqli_fetch_array($tampil)):
         
         echo "<tr><td>$no</td>
             <td>$tyo[nim]</td>
             <td>$tyo[nm_mahasiswa]</td>
             <td>$tyo[kelamin]</td>
             <td>$tyo[fakultas]</td>
             <td>$tyo[jurusan]</td>";
        echo "           
            <td>
            <a class=\"btn btn-info\" href=\"?module=siswa&act=editsiswa&nim=$tyo[nim]\">
                <i class=\"glyphicon glyphicon-edit icon-white\"></i>
                Edit
            </a>
            <a class=\"btn btn-danger\" href=\"$aksi?module=siswa&act=hapus&nim=$tyo[nim]\">
                <i class=\"glyphicon glyphicon-edit icon-white\"></i>
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

   case "tambahsiswa":
    echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=siswa\">Data Mahasiswa</a>
            </li>
        </ul>
    </div>";
    //form tambah  
  echo "<div class=\"row\">
    <div class=\"box col-md-12\">
        <div class=\"box-inner\">
            <div class=\"box-header well\" data-original-title=\"\">
                <h2><i class=\"glyphicon glyphicon-edit\"></i> Form Add Mahasiswa</h2>

                <div class=\"box-icon\">
                 
                    <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-chevron-up\"></i></a>
                    <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-remove\"></i></a>
                </div>
            </div>
            <div class=\"box-content\">
                <form role=\"form\" class=\"cmxform\" id=\"form1\" method=\"POST\" action=\"$aksi?module=siswa&act=input\" enctype=\"multipart/form-data\">
                    
                    
                    <div class=\"form-group\">
                        <label>Upload XLS</label>
                        <input type=\"file\"  name=\"userfile\" >
                    </div>
                    <button type=\"submit\" class=\"btn btn-default\">Save</button> | 
                    <button type=\"button\" class=\"btn btn-warning\" onclick=\"self.history.back()\">Cancel</button>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->";       
    break;
   
   case "tambah":
        echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=siswa\">Data Mahasiswa</a>
            </li>
        </ul>
    </div>";
       
   //form tambah  
  echo "<div class=\"row\">
    <div class=\"box col-md-12\">
        <div class=\"box-inner\">
            <div class=\"box-header well\" data-original-title=\"\">
                <h2><i class=\"glyphicon glyphicon-edit\"></i> Form Add Mahasiswa</h2>

                <div class=\"box-icon\">
                 
                    <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-chevron-up\"></i></a>
                    <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-remove\"></i></a>
                </div>
            </div>
            <div class=\"box-content\">
                <form role=\"form\" class=\"cmxform\" id=\"form1\" method=\"POST\" action=\"$aksi?module=siswa&act=inputsiswa\" >
                    
                    
                    <div class=\"form-group\">
                        <label>NIM</label>
                        <input type=\"text\" class=\"form-control\"  name=\"nim\" required oninvalid=\"this.setCustomValidity('NIM tidak boleh kosong')\" oninput=\"setCustomValidity('')\">
                    </div>
                     <div class=\"form-group\">
                        <label>Nama Mahasiswa</label>
                        <input type=\"text\" class=\"form-control\"  name=\"nm_mahasiswa\" required oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong')\" oninput=\"setCustomValidity('')\" >
                    </div>
                     <div class=\"form-group\">
                        <label>Jenis Kelamin</label><br>
                        <input type=\"radio\"  name=\"kelamin\" value=\"L\" checked>Laki-Laki  <input type=\"radio\"  name=\"kelamin\" value=\"P\">Perempuan
                    </div>

                    <div class=\"form-group\">
                        <label>Fakultas</label>
                        <div class=\"controls\">
                        <select data-rel='chosen' name=\"fakultas\">
                        <option value=\"0\">-Pilih Data-</option>";
             
                        $query = "SELECT nm_kategori FROM kategori ORDER BY nm_kategori"; 
                        $hasil = mysqli_query($koneksidb,$query);
                        while($r = mysqli_fetch_array($hasil)){
                            echo "<option value=\"$r[nm_kategori]\">$r[nm_kategori]</option>";
                        }
                  echo" </select>              
                      </div>
                   </div>";


              echo"     <div class=\"form-group\">
                        <label>Jurusan</label>
                        <input type=\"text\" class=\"form-control\"  name=\"jurusan\" required oninvalid=\"this.setCustomValidity('Jurusan tidak boleh kosong')\" oninput=\"setCustomValidity('')\" >
                    </div>";

              echo" <button type=\"submit\" class=\"btn btn-default\">Save</button> | 
                    <button type=\"button\" class=\"btn btn-warning\" onclick=\"self.history.back()\">Cancel</button>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->";    
   break;



    //edit siswa 
    case "editsiswa":
        $query = "SELECT * FROM mahasiswa WHERE nim = '$_GET[nim]'";
        $hasil = mysqli_query($koneksidb,$query);
        $r = mysqli_fetch_array($hasil);
        $fakultas = $r['fakultas'];
        echo "<div>
        <ul class=\"breadcrumb\">
            <li>
                <a href=\"?module=beranda\">Home</a>
            </li>
            <li>
                <a href=\"?module=siswa\">Data Mahasiswa</a>
            </li>
        </ul>
    </div>";
       
   //form tambah  
  echo "<div class=\"row\">
    <div class=\"box col-md-12\">
        <div class=\"box-inner\">
            <div class=\"box-header well\" data-original-title=\"\">
                <h2><i class=\"glyphicon glyphicon-edit\"></i> Form Add Mahasiswa</h2>

                <div class=\"box-icon\">
                 
                    <a href=\"#\" class=\"btn btn-minimize btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-chevron-up\"></i></a>
                    <a href=\"#\" class=\"btn btn-close btn-round btn-default\"><i
                            class=\"glyphicon glyphicon-remove\"></i></a>
                </div>
            </div>
            <div class=\"box-content\">
                <form role=\"form\" class=\"cmxform\" id=\"form1\" method=\"POST\" action=\"$aksi?module=siswa&act=update\" >
                    <input type=\"hidden\" name=\"nim\" value=\"$r[nim]\">
                    
                    <div class=\"form-group\">
                        <label>NIM</label>
                        <input type=\"text\" class=\"form-control\"  name=\"nim\" value=\"$r[nim]\" required oninvalid=\"this.setCustomValidity('NIM tidak boleh kosong')\" oninput=\"setCustomValidity('')\" readonly>
                    </div>
                     <div class=\"form-group\">
                        <label>Nama Mahasiswa</label>
                        <input type=\"text\" class=\"form-control\"  name=\"nm_mahasiswa\" value=\"$r[nm_mahasiswa]\" required oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong')\" oninput=\"setCustomValidity('')\" >
                    </div>
                     <div class=\"form-group\">
                        <label>Jenis Kelamin</label><br>
                        <input type=\"radio\"  name=\"kelamin\" value=\"L\" checked>Laki-Laki  <input type=\"radio\"  name=\"kelamin\" value=\"P\">Perempuan
                    </div>

                    <div class=\"form-group\">
                        <label>Fakultas</label>
                        <div class=\"controls\">
                        <select data-rel='chosen' name=\"fakultas\">
                        <option value=\"0\">-Pilih Data-</option>";
             
                        $query = "SELECT * FROM kategori ORDER BY nm_kategori"; 
                        $hasil = mysqli_query($koneksidb,$query);
                        while($f = mysqli_fetch_array($hasil)){
                            if ($f[1] ==$fakultas) {
                                    echo "<option value='$f[1]' selected>$f[1]</option>";
                                } 
                            else {
                                echo "<option value='$f[1]'>$f[1]</option>";
                            }
                        }
                    echo" </select>              
                        </div>
                     </div>";

                    echo" <div class=\"form-group\">
                        <label>Jurusan</label>
                        <input type=\"text\" class=\"form-control\"  name=\"jurusan\" value=\"$r[jurusan]\" required oninvalid=\"this.setCustomValidity('Jurusan tidak boleh kosong')\" oninput=\"setCustomValidity('')\" >
                    </div>
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
