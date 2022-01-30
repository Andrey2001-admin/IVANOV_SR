<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";
	
	db_connect();

	if(!empty($_POST)) 
		if(isset($_POST["product"])) {
		

			$category = htmlentities(mysqli_real_escape_string($conn,$_POST["category"]));
			$name = htmlentities(mysqli_real_escape_string($conn,$_POST["name"]));
			$description = htmlentities(mysqli_real_escape_string($conn,$_POST["description"]));
			$price = htmlentities(mysqli_real_escape_string($conn,$_POST["price"]));

			$property_name = $_POST["property-name"];
			$property_value = $_POST["property-value"];

			
			
			
			
			for($len = count($property_name), $i = 0; $i < $len; ++$i) {
				$property["name"][] = htmlentities(mysqli_real_escape_string($conn,$property_name[$i]));
				$property["value"][] = htmlentities(mysqli_real_escape_string($conn,$property_value[$i]));
			}
			
			
			
			
			$property = json_encode($property, JSON_UNESCAPED_UNICODE);

			if( $_FILES["img"]["error"] == UPLOAD_ERR_OK )
				if ( is_uploaded_file($_FILES["img"]["tmp_name"])) {
						$tmpPath = $_FILES["img"]["tmp_name"];
						$toBuffer = file_get_contents($tmpPath);  
						$type = mime_content_type($tmpPath); 
						$img = "data:$type;base64," . base64_encode($toBuffer);
						
						
					} 
			
			add_product($category, $name, $description, $img, $property, $price);
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
				
		
		<form id="product" class="add" method="post" enctype="multipart/form-data">
			
			<div class="box">
				<label>Категория продукта</label>
				<select name="category">
					<option value="Защита" selected>Защита</option>
					<option value="Моторезина">Моторезина</option>
					<option value="Шлема">Шлема</option>
					<option value="Экипировка">Экипировка</option>
				</select>
				
				<label>Название</label>
				<input type="text" placeholder="Название" name="name" maxlength="50" required>
				
				<label>Выберите изображение</label>
				<input type="file" name="img" accept="image/jpeg,image/png">
				
				<label>Описание</label>
				<textarea placeholder="Описание" name="description" required rows="4" style="resize: none;" maxlength="255"></textarea>
				
				<label>Цена</label>
				<input type="number" placeholder="Цена" name="price" step="0.1" required>
				
				
			</div>
			
			<input type="submit" name="product" value="Записать в БД">
			
		</form>
		
		<?php 
		require_once "block/footer.php";
	?>
		
	</main>
	

</body>

</html>