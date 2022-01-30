<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";
	
	db_connect();

	if(!empty($_POST)) 
		if(isset($_POST["custom"])) {
		

			$fname = htmlentities(mysqli_real_escape_string($conn,$_POST["fname"]));
			$sname = htmlentities(mysqli_real_escape_string($conn,$_POST["sname"]));
			$patronymic = htmlentities(mysqli_real_escape_string($conn,$_POST["patronymic"]));
			
			
			add_custom($fname, $sname, $patronymic);
		}
	
	db_close();
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "block/head.php"; ?>
	
	<link rel="stylesheet" href="css/add.css">
	<script src="js/add.js"></script>
</head>

<body>

	<?php 
		require_once "block/header.php"; 
		require_once "block/nav.php"; 
		
	?>
	
	<main>
		
		<h2>Добавление</h2>
				
		
		<form id="custom" class="add" method="post" enctype="multipart/form-data">
			
			<div class="box">
				
				<label>Имя</label>
				<input type="text" placeholder="Имя" name="fname" maxlength="50" required>
				<label>Фамилия</label>
				<input type="text" placeholder="Фамилия" name="sname" maxlength="50" required>
				<label>Отчество</label>
				<input type="text" placeholder="Отчество" name="patronymic" maxlength="50" required>
				
				
			</div>
			
			<input type="submit" name="custom" value="Записать в БД">
			
		</form>
		
		<?php 
		require_once "block/footer.php";
	?>
		
	</main>
	

</body>

</html>