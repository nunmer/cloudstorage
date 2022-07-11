<?php
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
	$cpassword = mysqli_real_escape_string($link, $_REQUEST['cpassword']); 
	//Берем введенные пользователем данные

	if ($password==$cpassword){
			function phpAlert($msg) {
				echo '<script type="text/javascript">alert("' . $msg . '")</script>';
			}
			//Если пароли совпадают вводим данные нового пользователя в БД
			$sql = "INSERT INTO users (user_id, username, password) VALUES 
			 ('','$email', '$password')";
			if (mysqli_query($link, $sql)){
				echo("<script>alert('Welcome! You may login now!')</script>");
				echo("<script>window.location = 'login.php';</script>");
			}
	}else{
		echo "<script>alert('Пароли не совпадают!');</script>";
	}
}
 ?>
<html>
<head>
<title>Register</title>
    <link rel="stylesheet" type="text/css" href="loginstyle.css">
</head>
<body>
	<div id="navbar">
		<a href="index.html">Home</a>
	</div>
    <div class="loginbox">
    <img src="upload/profile.png" class="avatar">
        <h1>Registration</h1>
        <form method="post">
            <p>Username</p>
            <input type="text" name="email" placeholder="Enter Username">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="password" name="cpassword" placeholder="Confirm Password">
            <input type="submit" name="registerbutton" value="Register">
            <a href="#">Lost your password?</a>
            <a href="login.php">Already have an account?</a>
        </form>
        
    </div>

</body>

</html>