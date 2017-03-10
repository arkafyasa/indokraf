<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../login.php");
    }
?>
<!DOCTYPE html>
<html class="html" lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>INDOKRAF - Admin Control Panel
    </title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../style.css" type="text/css" />
</head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://localhost/indokraf"><img src="../images/logo.png" alt="indokraf" style="border:0;">
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="index.php">Persetujuan pesanan</a>
                        </li>
                        <li>
                            <a href="ubah-status.php">Ubah status pesanan</a>
                        </li>
                        <li>
                            <a href="edit-akun.php">Edit user</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user"></span>
                                <?php echo $_SESSION['user']; ?>&nbsp;<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="../logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
        </nav>
        <div id="wrapper">
            <div class="container">
                <div class="page-header text-center text-uppercase">
                    <h3>Konfirmasi Pemesanan</h3>
                </div>
                  <table class="table">
                    <thead>
                        <th><p>ID Pesanan</p></th>
                        <th><p>Email Pemesan</p></th>
                        <th><p>Lokasi Pengiriman</p></th>
                        <th><p>Total berat</p></th>
                        <th><p>Total harga</p></th>
                        <th><p>Tentukan Ongkir</p></th>
                        <th><p>Konfirmasi ?</p></th>
                    </tr>
                    </thead>
                      <tbody>
                        <?php  
                            require_once "../dbconnect.php";
                            $sql=sqlsrv_query($conn, "EXEC showTabelKonfirmasiPemesanan"); 
                            while ($data=sqlsrv_fetch_array($sql)){ 
                                echo "<tr>
                                        <td>$data[0]</td>
                                        <td>$data[2]</td>
                                        <td>$data[3]</td>
                                        <td>$data[4] Kg</td>
                                        <td>Rp. $data[5]</td>
                                        <form method='post' action='' autocomplete='off'>
                                            <input type='hidden' name='idPengiriman' value=$data[1]></input>
                                            <input type='hidden' name='idPesanan' value=$data[0]></input>
                                            <input type='hidden' name='totalHarga' value=$data[5]></input>
                                            <td><input type='number' name='ongkir' class='form-control' placeholder='Harga Ongkir'></input></td>
                                            <td><div class='btn-group'>
                                                <button type='submit' class='btn btn-primary' name='btn-konfirm'>Confirm</button>
                                        </form>
                                            <button type='submit' class='btn btn-info' name='btn-detail'>Detail</button>
                                        <form method='get' action='../transaksi/delete-pesanan.php' autocomplete='off'>
                                            <input type='hidden' name='idPesanan' value=$data[0]></input>
                                            <button class='btn btn btn-danger' type='submit' name='idPesanan' value='$data[0]'>delete</button>
                                        </form>
                                        </div></td>
                                    </tr>";
                                }  
                        ?>
                    </tbody>
                </table>
                <?php
                    if (isset($_POST['btn-konfirm'])) {
                        $sql=sqlsrv_query($conn, "EXEC showTabelKonfirmasiPemesanan"); 
                        $data=sqlsrv_fetch_array($sql);
                        $params = array($_POST['idPengiriman'],$_POST['idPesanan'],$_POST['ongkir'],$_POST['totalHarga']);
                        $tsql1 = "EXEC terkonfirmasi ?, ?, ?,?";
                        $sql1 = sqlsrv_query($conn,$tsql1,$params);
                        header("Location: index.php");
                        if (!$sql1) {
                            die( print_r( sqlsrv_errors(), true ));
                        }
                    }
                ?>   
                <div class="page-footer text-left">
                    <p>Ini namanya footer website entahlah mau diiisi apa</p>
                </div>
            </div>
        </div>
        <script src="../scripts/jquery-1.11.3-jquery.min.js"></script>
        <script src="../scripts/bootstrap.min.js"></script>
    </body>
</html>