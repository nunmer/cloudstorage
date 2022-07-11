<?php
session_start(); //Сессия для пользователя
include('connection.php'); //Связь с БД

if(!$_SESSION['id']){
	//Проверка на авторизацию
	header('Location: http://www.localhost/cloudstorage/login.php');
}

 if (isset($_POST["image"])) {
	 //Если кнопка "Выбрать файл" нажата
	$fileInfo = PATHINFO($_FILES["image"]["name"]); //Двумерный массив для файла
	$url=$_GET['userid'];
	$size = $_FILES['image']['size']; //Берем объем файла
	echo $size.'bytes'; //Выводим размер файла
	if ($size >= 2000000) {
		//Если размер файла больше 2МБ
		?>
		<script>
			window.alert('Uploaded photo is to big!');
			window.history.back();
		</script>
		<?php
	}
	elseif (empty($_FILES["image"]["tmp_name"])){ //Если ничего не загружено
		?>
			<script>
				window.alert('Sorry photo is not uploaded!');
				window.history.back();
			</script>
		<?php
	}
	else{
	    //Проверка на правильность формат файла
		if ($fileInfo['extension'] == "jpg" OR $fileInfo['extension'] == "png" OR $fileInfo['extension'] == "jpeg") { 
			$name_file = $_FILES['image']['name'];
			$tmp_name = $_FILES['image']['tmp_name'];
			$newFilename = $fileInfo['filename'] .$fileInfo['extension'];
			move_uploaded_file($tmp_name, "upload/".$name_file);
			$location = "upload/" . $name_file;
			//Берем файл, даем название с папкой и вводим в БД
			mysqli_query($conn,"INSERT INTO `photo`(`photoid`, `userid`, `photo`) VALUES ('','$url','$location')");
	        //Вводим в таблицу с ID пользователя
			?>
				<script>
					window.alert('Photo updated successfully!');
					window.history.back();
				</script>
			<?php
		}
		else{
			?>
				<script>
					window.alert('Photo not updated. Please upload JPG or PNG files only!');
					window.history.back();
				</script>
			<?php
		}
	}
}

if (isset($_POST['log'])){
	session_unset();
	header('Location: http://www.localhost/cloudstorage/login.php');
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>profile page</title>
	<link rel="stylesheet" type="text/css" href="profile.css"> <!-- Связь с CSS папкой -->
	<link rel="stylesheet" type="text/css" href="table.css">
</head>
<body>

	<div id="navbar">
		  <a href="index.html">Home</a>
	</div>



<?php
	$url=$_GET['userid'];

	$query=mysqli_query($conn,"select * from `users` where user_id='$url'");
	//Берем все строки пользователя
	while($row=mysqli_fetch_array($query)){
	//Вставим все в одномерный массив
?>	
	<div class="profilepage"> <!-- Контейнер с данными о пользователе -->
		<img src="upload/profile.png" style="height:80%; width:40%; position:relative; top:15px; left:10px; border-radius: 20px;" alt="<?php echo $row['username'] ?>" >
		<div class="profile_info">
			<p style="font-size:20px; font-weight: bold;">User: <?php echo $row['username'] ?></p>
			
			<!-- Trigger/Open The Modal -->
			<button id="myBtn">Add photo</button>

			<!-- The Modal -->
			<div id="myModal" class="upload">

				<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
						<span class="close">&times;</span>
						<br><h2>Adding photo...</h2>
					</div>
					<form method="post" action="" enctype='multipart/form-data'>
						<div class="modal-body">
						  <p>Photo:</p>
						  <input type="file" style="width:350px;" class="form-control" name="image">
						</div>
					
						<div class="modal-footer" >
							<button type="button" class="cancel_btn" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
							<button id="Myclose" type="submit" class="upload_btn" name="image">Upload</button>
						</div>
					</form>
				</div>
			</div>
			
			<form  method="post"> 
				<div id="log"> <!-- Кнопка для выхода -->
				<input type="submit" value="Log out" name="log" id="logout">
				</div>
			</form>
		</div>
	</div>
<?php

	}	
?>

	<center>
		<div class="table-wrapper">
			<table class="fl-table">
				<thead>
					<tr>
						<th>All photos</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$url=$_GET['userid'];
					
					$query2=mysqli_query($conn,"select * from `photo` where userid='$url'");
					//Берем все строки с таблицы с фотографиями пользователя
					while($row2=mysqli_fetch_array($query2)){
					//Вставляем все в одномерный массив
					?>
					<tr>
						
						<td>
							<div>
							<a target="_blank" href="<?php echo $row2['photo']; ?>">
							<img id="photobox" src="<?php echo $row2['photo']; //Показ всех фотографии пользователя?>">
							</div>
						</td>
						<td>
							<form method="post"> <!-- Кнопка для удаления фотографии -->
							<input type="submit" value="DELETE" name="<?php echo $row2['photoid'] ?>" id="delete">
							</form>
						</td>
					</tr>
					<?php
						if (isset($_POST[$row2['photoid']])) {
							$url = $_SESSION['id'];
							// Удаление фотографии
							$photo = $row2['photoid'];
							mysqli_real_query($conn,"DELETE FROM `photo` WHERE photoid='$photo'");
							header('Location: http://www.localhost/cloudstorage/profile.php?userid='.$url);
						}
					}
				?>
				
				</tbody>
			</table>
		</div>
	</center>
</body>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

var cls = document.getElementsByClassName("cancel_btn")[0];
//Cancel button

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

cls.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</html>