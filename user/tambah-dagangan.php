<?php
    ob_start();
    session_start();
    require_once '../dbconnect.php';
    // if session is not set this will redirect to login page
    if( $_SESSION['user'] == "" ) {
        header("Location: ../login.php");
        exit;
    }else {
    //select loggedin users detail
  $a = $_SESSION['user'];
  $query = "SELECT * FROM akun WHERE email= '$a'";
  $res= sqlsrv_query($conn,$query);
  $userRow= sqlsrv_fetch_array($res); 
?>
<!DOCTYPE html>
<html class="html" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tambah Barang Dagangan</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="../style.css" type="text/css" />
</head>
<style>
.input-group{
    width: 40%;
}
.select-list{
    width: 30%;
}
</style>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../homepage.php"><img src="../images/logo.png" alt="indokraf logo" style="border:0;">
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="../homepage.php">Beranda</a>
                        </li>
                        <li>
                            <a href="../task/top-produk10.php">10 Produk Terlaris</a>
                        </li>
                        <li>
                            <a href="../task/top-toko5.php">5 Toko Paling Laris</a>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-left">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Cari Barang">
                      </div>
                      <button type="submit" class="btn btn-default">Cari</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php echo $userRow['nama']; ?>&nbsp;<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="../user/tambah-dagangan.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;Tambah dagangan</a></li>
                                <li><a href="../user/list-dagangan.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Daftar dagangan</a></li>
                                <li><a href="../user/status-kirim.php"><span class="glyphicon glyphicon-check"></span>&nbsp;Status Pengiriman</a></li>
                                <li><a href="../user/ubah-profil.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;Ubah Profil</a></li>
                                <li><a href="../transaksi/riwayat-beli.php"><span class="glyphicon glyphicon-inbox"></span>&nbsp;Riwayat Pembelian</a></li>
                                <li><a href="../logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
        </nav>
    <div id="wrapper">
        <div class="container">

            <div class="page-header text-center text-uppercase">
                <h3>Tambahkan Dagangan</h3>
            </div>
            <h4>Perhatian !! Pastikan anda telah memasukkan nomor rekening terlebih dahulu sebelum menambahkan barang dagangan</br>
                Dengan mengubah profil anda di menu ubah profil kemudian pilih ubah informasi sensitif
            </h4>
            <form method="post" action="" enctype="multipart/form-data" autocomplete="off">
                <h6>Nama</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="text" name="nama" class="form-control" placeholder="Nama" />
                        </div>
                </div>
                <h6>Harga</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="number" name="harga" class="form-control" placeholder="Harga" />
                        </div>
                </div>

                <h6>Jumlah</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah barang yang dijual" />
                        </div>
                </div>

                <h6>Berat Barang (Dalam Kilogram (Kg))</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="number" name="berat" class="form-control" placeholder="Berat barang yang dijual dalam Kg" />
                        </div>
                </div>

                <h6>Deskripsi</h6>
                 <div class="form-group">
                      <textarea class="form-control" limit="50" name="desc"></textarea>
                </div>

                <h6>Jenis</h6>
                <div class="form-group select-list">
                    <select class="form-control" id="sel1" name="tipe" onchange="showfield(this.options[this.selectedIndex].value)">
                        <option value ="Rajut">Rajut</option>
                        <option value="Batik">Batik</option>
                        <option value="Keramik">Keramik</option>
                        <option value="Tenun">Tenun</option>
                        <option value="Rajut">Rajut</option>
                        <option value="Ukir">Ukir</option>
                        <option value="Anyaman">Anyaman</option>
                        <option value="Handicraft">Handicraft</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <h6>Upload gambar</h6>
                 <div class="form-group">
                      <input type="file" name="fileToUpload" id="fileToUpload">
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="btn-add">Tambahkan Produk</button>
                </div>

                <?php
                    include "../dbconnect.php";
                    if ( isset($_POST['btn-add']) ) {
                        $name = $_POST['nama'];
                        $harga = $_POST['harga'];
                        $desc = $_POST['desc'];
                        $qty = $_POST['jumlah'];
                        $jenis = $_POST['tipe'];
                        $berat = $_POST['berat'];

                        /*SQL INSERT*/
                        $tsql1 = "INSERT INTO produk(email_penjual, nama_produk, harga, keterangan, jenis, stok, beratBarang) VALUES (?,?,?,?,?,?,?)";
                        $param1 = array($a, $name, $harga, $desc, $jenis, $qty, $berat); 
                        $sql1 = sqlsrv_query($conn, $tsql1, $param1);

                        if($sql1) {
                                $errTyp = "success" ;
                                $errMSG = "Data berhasil masuk !!";
                            } else {
                                $errTyp = "danger";
                                $errMSG = "ERROR : Rollback perubahan";   
                        }

                        $target_dir = "../gambar_produk/";
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                        // Check if image file is a actual image or fake image
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if($check !== false) {
                                echo "File is an image - " . $check["mime"] . ".";
                                $uploadOk = 1;
                            } else {
                                echo "File is not an image.";
                                $uploadOk = 0;
                            }
                        // Check if file already exists
                        if (file_exists($target_file)) {
                            echo "Sorry, file already exists.";
                            $uploadOk = 0;
                        }
                        // Check file size
                        if ($_FILES["fileToUpload"]["size"] > 500000) {
                            echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                        }
                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                        // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                $sql = sqlsrv_query($conn,"SELECT MAX(ID_Produk) FROM produk where email_Penjual = '$_SESSION[user]'");
                                $id = sqlsrv_fetch_array($sql);

                                echo $id[0]."</br>";
                                echo $_SESSION['user']."</br>";
                                echo $imageFileType."</br>";


                                $param = array($id[0],$_SESSION['user'],$imageFileType);
                                $sqls =sqlsrv_query($conn,"EXEC insertGambar ?,?,?",$param);
                                if (!$sqls) {
                            die( print_r( sqlsrv_errors(), true ));
                        }
                                $name = sqlsrv_fetch_array($sqls);
                                rename($target_file,"../gambar_produk/".$id[0].'.'.$imageFileType);
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }

                    }
                ?>
                <?php
                if ( isset($errMSG) ) {
                    
                    ?>
                    <div class="form-group">
                    <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </div>
                    </div>
                    <?php
                }
                ?>
            </form>
            <table class="table table-hover">
                <tr>
                    <th>Nama produk</th>
                    <th>Harga</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                </tr>
                <tbody>
                    <?php 
                        include "../dbconnect.php";
                        $sql=sqlsrv_query($conn, "SELECT nama_produk,harga,jenis,stok FROM produk WHERE email_penjual = '$_SESSION[user]' AND stok != 0 AND harga != 0" ); 
                        while ($data=sqlsrv_fetch_array($sql)){ 
                            echo "<tr>
                                    <td>$data[0]</td>
                                    <td>$data[1]</td>
                                    <td>$data[2]</td>
                                    <td>$data[3]</td>
                                </tr>"; }  
                    ?>
                </tbody>
            </table>
            <div class="page-footer text-left">
                <p>Buku Lapak, Copyright kelompok basdat kelas O</p>
            </div>
        </div>
    </div>
    <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>

</body>
</html>
<?php } ?>

