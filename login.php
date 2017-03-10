<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';
    
    if ( isset($_SESSION['user'])!="" ) {
        header('location: homepage.php');
        exit();
    }
    
    $error = false;
    
    if( isset($_POST['btn-login']) ) {  
        
        $email = trim($_POST['email']);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);
        
        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);
        
        if(empty($email)){
            $error = true;
            $errMSG = "Masukkan alamat email anda";

        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = true;
            $errMSG = "Masukkan alamat email yang benar.";
        }
        
        if(empty($pass)){
            $error = true;
            $errMSG = "Masukkan password";
        }
        
        if (!$error){
            $connectionInfo = array( "Database"=>"Indokraf");
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            
            $userParam = array($email,$pass);
            $count=sqlsrv_query($conn,"SELECT * FROM akun WHERE email= ? AND password = ?",$userParam);
            $row = sqlsrv_fetch_array($count);
            $admin = sqlsrv_query($conn,"SELECT * FROM admin");
            $adminRow = sqlsrv_fetch_array($admin);
            if ($email == $adminRow['email'] && $pass == $adminRow['password']) {
                $_SESSION['user'] = 'admin';
                header("Location: admin");
            }else if($row['email'] == $email && $row['password']==$pass && $row['status']=='aktif') {
                $_SESSION['user'] = $row['email'];
                header("Location: homepage.php");
            }else {
                $errMSG = "email atau password anda salah, coba lagi";
            }
                
        }
        
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login User Indokraf</title>
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bgcolor="#0066FF">

<div class="container">

	<div id="login-form">
    <form method="post" action="" autocomplete="off">

    	<div class="logo-image">
    		<a href="localhost/index.php">
  				<img src="images/logo-login.png" alt="bukulapak" style="border:0; height:20%;width:100%;">
			</a> 
    
    	<div class="col-md-12">
        
        	<div class="form-group">
            	<h2 class="">Sign In.</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-danger">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Email" maxlength="40" />
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
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="register.php">Belum terdaftar ? Registrasi disini..</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>