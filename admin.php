<?php
include('connection.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin page</title>

        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
		<link rel="stylesheet" type="text/css" href="profile.css"> <!-- Связь с CSS папкой -->
		<link rel="stylesheet" href="table.css" media="screen" type="text/css" />
		
		<div id="navbar">
		  <a href="index.html">Main page</a>
		</div>
		
    </head>
    <body style="margin: 0;"  id="home">
		<br><br><br><br><br><br><br><br>
	<div class="table-wrapper">
    <table class="fl-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Occupation</th>
            <th>Feedback</th>
        </tr>
        </thead>
        <tbody>
		<?php
			$query2=mysqli_query($conn,"select * from `feedbacks`");
			//Берем все сообщения с таблицы
			while($row2=mysqli_fetch_array($query2)){
			//Вставляем все в одномерный массив
		?>
        <tr>
            <td><?php echo $row2['name']; ?></td>
            <td><?php echo $row2['surname']; ?></td>
            <td><?php echo $row2['text']; ?></td>
            <td>
				<form method="post"> <!-- Кнопка для удаления фотографии -->
					<input type="submit" value="DELETE" name="<?php echo $row2['feedback_id'] ?>" id="delete">
				</form>
			</td>
        </tr>
		<?php
			if (isset($_POST[$row2['feedback_id']])) {
				// Удаление feedback
				$feedback = $row2['feedback_id'];
				mysqli_real_query($conn,"DELETE FROM `feedbacks` WHERE feedback_id='$feedback'");
				header('Location: http://www.localhost/cloudstorage/admin.php');
				}
			}
		?>
        <tbody>
    </table>
</div>
    </body>
</html>