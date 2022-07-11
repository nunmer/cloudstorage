<?php
session_start();
error_reporting(0);

if($_SESSION['id']){
	header('Location: http://www.localhost/cloudstorage/profile.php?userid='.$_SESSION['id']);
}
$link = mysqli_connect("localhost", "root", "", "cloudstorage");
//Связь с БД

if($link === true) {
	//Проверка
	echo("success");
}
if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}


if (isset($_POST["registerbutton"])) {
$email = mysqli_real_escape_string($link, $_REQUEST['email']);
$password = mysqli_real_escape_string($link, $_REQUEST['password']); 
//Берем введенные данные	
		if($email == "admin" && $password == "admin"){
			echo("<script>alert('Welcome, Admin!')</script>");
			echo("<script>window.location = 'admin.php';</script>");
			
		}else{
			$sql = "SELECT * FROM users WHERE username='$email'";
			$result = mysqli_query($link,$sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC); //Массив
			//Проверка пароля введенного пользователя
			if ($row['password']==$password){
				$_SESSION['user_name']=$row['user_name'];
				$_SESSION['id']=$row['user_id'];
				$url = $_SESSION['id'];
				header('Location: http://www.localhost/cloudstorage/profile.php?userid='.$url);
			} else {			
				$invpass=1;
			}
		}
}

 ?>
<html>
<head>
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="loginstyle.css">
<body>

	<div id="navbar">
		  <a href="index.html">Home</a>
	</div>
    <div class="loginbox">
	<?php
		if ($_SESSION['user_email']=="") {
			
			if ($invpass==1){
				echo "Incorrect password or login";
			}
		}
	?>	
	
		
    <img src="upload/profile.png" class="avatar">
        <h1>Login Here</h1>
        <form method="post">
            <p>Username</p>
            <input type="text" name="email" placeholder="Enter Username">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" name="registerbutton" value="Login">
            <a href="#">Lost your password?</a><br>
            <a href="register.php">Don't have an account?</a>
        </form>
        
    </div>

</body>
</head>
</html>