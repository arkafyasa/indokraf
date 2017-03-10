<?php
	ob_start();
	session_start();
	if( isset($_SESSION['user'])!="" ){
		header("Location: homepage.php");
	}
	require_once 'dbconnect.php';
	$error = false;

	if ( isset($_POST['btn-signup']) ) {
		echo "1";
		$name = trim($_POST['name']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);

		$tel = trim($_POST['phoneNumber']);
		$tel = strip_tags($tel);
		$tel = htmlspecialchars($tel);
		
		if (empty($name)) {
			$error = true;
			$nameError = "Masukkan username yang ingin anda pakai";
			echo "2";
		} else if (strlen($name) < 3) {
			$error = true;
			$nameError = "Username harus lebih dari 3 karakter";
			echo "3";
		} else if (!preg_match("/^[a-zA-Z]+$/",$name)) {
			$error = true;
			$nameError = "Username harus terdapat huruf alfabet";
			echo "4";
		}
		
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Email sudah didaftarkan.";
			$errMSG = $emailError;
			echo "5";
		} else {
			$count=sqlsrv_query($conn,"SELECT count(*) as jum FROM akun WHERE email= '$email' ");
			$row = sqlsrv_fetch_array( $count, SQLSRV_FETCH_NUMERIC);
			$count =  $row[0];
			echo "6";
			if($count!=0){
				$error = true;
				$emailError = "Email telah didaftarkan, gunakan email yang lain.";
				$errMSG = $emailError;
				echo "7";
			}
		}
		if (empty($pass)){
			$error = true;
			$passError = "Masukkan password.";
			echo "8";
		} else if(strlen($pass) < 6) {
			$error = true;
			$passError = "Password minimal 6 karakter.";
			echo "9";
		}

		if (empty($tel)){
			$error = true;
			$passError = "Masukkan no. telepon";
			echo "10";
		}else if(strlen($tel) < 11) {
			$error = true;
			$passError = "No. Telepon tidak valid";
			echo " 11";
		}
		if( !$error ) {
			if ( sqlsrv_begin_transaction( $conn ) === false ) {
                 die( print_r( sqlsrv_errors(), true ));
            }
            echo " 12";

			$tsql = "INSERT INTO akun(nama,email,password,noHP) VALUES(?,?,?,?)";
			$arrayName = array($name,$email,$pass,$tel);
			$sql = sqlsrv_query($conn,$tsql,$arrayName);
			if ($sql) {
				echo "sql1 Berhasil";
			}

			$tsql2 = "INSERT INTO Pembeli(email_Pembeli) VALUES ('$email')";
			$sql2 = sqlsrv_query($conn,$tsql2);
			if ($sql2) {
				echo "sql2 berhasil";
			}

			if ($sql && $sql2) {
				sqlsrv_commit( $conn );
				$errTyp = "success";
				$errMSG = "Registrasi Berhasil ! Login sekarang";
				unset($name);
				unset($email);
				unset($pass);
			} else {
				sqlsrv_rollback( $conn );
				$errTyp = "danger";
				$errMSG = "Kesalahan pada database atau input,\n mohon coba lagi";	
			}	
				
		}
		
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrasi User</title>
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

	<div id="login-form">
    <div class = "logo-image">
    <a href="localhost/indokraf/index.php">
  				<img src="images/logo-login.png" alt="bukulapak" style="border:0; height:20%;width:100%;">
			</a> 
            </div>
    <form method="post" action="" autocomplete="off">
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Sign Up.</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
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
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="name" class="form-control" placeholder="Nama" maxlength="50" />
                </div>
                <span class="text-danger"><?php echo $nameError = ""; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Email" maxlength="40"/>
                </div>
                <span class="text-danger"><?php echo $emailError = ""; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="pass" class="form-control" placeholder="Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError = ""; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
            	<input type="tel" name="phoneNumber" class="form-control" placeholder="No. Telepon" />
                </div>
                <span class="text-danger"><?php echo $passError = ""; ?></span>
            </div>


            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="login.php">Sudah terdaftar ? Sign in sekarang</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>