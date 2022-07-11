<?php
include('connection.php'); //Связь с БД

if (isset($_POST['feedback_btn'])) {
			
			$name = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
			$surname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);

			$text = mysqli_real_escape_string($conn, $_REQUEST['feedback']);
			
			mysqli_query($conn,"INSERT INTO `feedbacks`(`feedback_id`, `name`, `surname`, `text`) VALUES ('','$name','$surname', '$text')");
			echo("<script>alert('Thank you, for your feedback!')</script>");
			echo("<script>window.location = 'index.html';</script>");
		}
?>