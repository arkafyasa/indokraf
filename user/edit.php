<?php
    ob_start();
    session_start();
    require_once '../dbconnect.php';
	$idproduk = $_GET['idproduk'];
	$a = $_SESSION['user'];
	$query = "SELECT * FROM akun WHERE email= '$a' ";
	$res= sqlsrv_query($conn,$query);
	$userRow= sqlsrv_fetch_array($res);
    $query2 = "SELECT * FROM produk WHERE email_penjual = '$a' and id_produk = $idproduk ";
    $res2= sqlsrv_query($conn,$query2);
    if ($res2) {
        echo "query2 sukses";
    }else{
        echo "gagal";
    }
    $produkRow= sqlsrv_fetch_array($res2);  
?>
<!DOCTYPE html>
<html class="html" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Dagangan</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="../style.css" type="text/css" />
<style>
	#wrapper{
		padding-top: 2%;
	}
	.navbar-right{
		padding-right: 1%;
	}
	.container{
		width: 80%;
	}
	.input-group {
    position: relative;
    display: table;
    border-collapse: separate;
    width: 40%;
}
</style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://localhost/indokraf"><img src="../images/logo.png" alt="indokraf logo" style="border:0;">
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
                <h3>Edit Barang Dagangan</h3>
            </div>
            <form method="post" action="" autocomplete="off">
                <h6>Nama</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php  echo $produkRow['nama_Produk'] ?>" ></input>
                        </div>
                </div>
                <h6>Harga</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="number" name="harga" class="form-control" placeholder="Harga" value="<?php  echo $produkRow['harga'] ?>"  ></input>
                        </div>
                </div>
                <h6>Jumlah</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah barang yang dijual" value="<?php  echo $produkRow['stok'] ?>" ></input>
                        </div>
                </div>

                <h6>Berat barang</h6>
                <div class="form-group">
                        <div class="input-group">
                        <input type="number" name="berat" class="form-control" placeholder="Jumlah barang yang dijual" value="<?php  echo $produkRow['beratBarang'] ?>" ></input>
                        </div>
                </div>

                <?php  echo $produkRow['keterangan'] ?>
                <h6>Deskripsi</h6>
                 <div class="form-group">
                      <textarea class="form-control" limit="50" name="desc" ><?php  echo $produkRow['keterangan'] ?></textarea>
                </div>

                <h6>Jenis</h6>
                <div class="form-group select-list">
                    <select class="form-control" id="sel1" name="tipe" onchange="showfield(this.options[this.selectedIndex].value)" value=<?php $produkRow['jenis'] ?>>
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
                <h6 id ="div1"></h6>

                <h6>Upload gambar</h6>
                 <div class="form-group">
                      <input type="file" name="fileToUpload" id="fileToUpload">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="btn-add">Simpan perubahan</button>
                    <a href="<?php echo$_SERVER['HTTP_REFERER']?>" class="btn btn-danger" role="button">Batalkan</a>
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

                        /*TRANSAKSI SQL*/
                        if ( sqlsrv_begin_transaction( $conn ) === false ) {
                                 die( print_r( sqlsrv_errors(), true ));
                        }

                        $tsql1 = "UPDATE produk SET nama_produk = ? WHERE id_produk = ? AND email_penjual = ?";
                        $tsql2 = "UPDATE produk SET harga = ? WHERE id_produk = ? AND email_penjual = ?";
                        $tsql3 = "UPDATE produk SET keterangan = ? WHERE id_produk = ? AND email_penjual = ?";
                        $tsql4 = "UPDATE produk SET jenis = ? WHERE id_produk = ? AND email_penjual = ?";
                        $tsql5 = "UPDATE produk SET stok = ? WHERE id_produk = ? AND email_penjual = ?";
                        /*$tsql6 = "UPDATE menjual SET gambar = ? WHERE id_produk = ? AND email_penjual = ?";*/
                        $tsql7 = "UPDATE produk SET beratBarang = ? WHERE id_produk = ? AND email_penjual = ?";
                        
                        $param1 =  array($name,$idproduk,$_SESSION['user']);
                        $param2 =  array($harga,$idproduk,$_SESSION['user']);
                        $param3 =  array($desc,$idproduk,$_SESSION['user']);
                        $param4 =  array($jenis,$idproduk,$_SESSION['user']);
                        $param5 =  array($qty,$idproduk,$_SESSION['user']);
                        $param7 =  array($berat,$idproduk,$_SESSION['user']);

                        $sql1 = sqlsrv_query($conn,$tsql1,$param1);
                        
                        $sql2 = sqlsrv_query($conn,$tsql2,$param2);
                        
                        $sql3 = sqlsrv_query($conn,$tsql3,$param3);
                        $sql4 = sqlsrv_query($conn,$tsql4,$param4);

                        $sql5 = sqlsrv_query($conn,$tsql5,$param5);

                        $sql7 = sqlsrv_query($conn,$tsql7,$param7);

                        if($sql1 && $sql2 && $sql3 && $sql4 && $sql5 && $sql7) {
                                sqlsrv_commit( $conn );
                                $errTyp = "success" ;
                                $errMSG = "Data berhasil diubah!!";
                            } else {
                                sqlsrv_rollback( $conn );
                                $errTyp = "danger";
                                $errMSG = "ERROR : Rollback perubahan";   
                        }

                        /*AKHIR TRANSAKSI SQL*/
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
            <div class="page-footer text-left">
                <p>Buku Lapak, Copyright kelompok basdat kelas O</p>
            </div>
        </div>
    </div>
    <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
</body>
</html>


