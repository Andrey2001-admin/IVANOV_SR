<?php
	require_once "include/session.php"; // на каждой странице
	require_once "include/mysqli.php";
	db_connect();
	if(!empty($_SESSION["login"])) {
		
		$user = $_SESSION["login"];
		
	} else
		header("Location: /");
	
if(!empty($_POST)) 
		if(isset($_POST["product"])) {
		
			global $id_tov;
			$field = htmlentities(mysqli_real_escape_string($conn,$_POST["field"]));
			

			$property_name = $_POST["property-name"];
			$property_value = $_POST["property-value"];

			
			
			
			
			for($len = count($property_name), $i = 0; $i < $len; ++$i) {
				$property["name"][] = htmlentities(mysqli_real_escape_string($conn,$property_name[$i]));
				$property["value"][] = htmlentities(mysqli_real_escape_string($conn,$property_value[$i]));
			}
			
			
			
			
			$property = json_encode($property, JSON_UNESCAPED_UNICODE);

			
			
			add_trans($field, $id_tov);
		}
	
	db_close();
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "block/head.php"; ?>
	
	<link rel="stylesheet" href="css/trash.css">
</head>

<body>

	<?php 
		require_once "block/header.php"; // шапка сайта
		require_once "block/nav.php"; // меню 
		
	?>
	
	<main>
		<h2>Корзина пользователя <?=$user?></h2>
		<?php
		
			if(isset($_SESSION["trash"])) {
				global $id_tov;
				$total_price = 0; // 0 рублей
				$id_tov = array();
				foreach($_SESSION["trash"] as $key => $val){
					$id = $val["id"];
					$name = $val["name"];
					$price = $val["price"];
					$decsription = $val["description"];
					$img = $val["img"] == "" ? "img/no-img.png" : $val["img"];
					array_push($id_tov, $id);
					$total_price += $price;
					
					$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img src="$img">
								</figure>
							
							<p class="description">$decsription</p>
							</div>
							<div class="price">$price</div>
							<div class="p">
							<a href="viewer.html?product=$id" class="btn">Подробнее</a>
							</div>
						</article>
_OUT;

					echo $article;
					
				}
				
					echo <<<_OUT
						<div class="total">
							Итого: $total_price рублей
						</div>
_OUT;
					$_SESSION["total_price"] = $total_price;
				
			?>
			<?php
			
			db_connect();
			global $conn;
			$sql = "SELECT * FROM custom";
			$result_select = mysqli_query($conn, $sql);
			
			
			
?>			<form id="product" class="add" method="post" enctype="multipart/form-data">
				<div class="box">
					<select name="field">
					<option disabled>Выберите имя</option>
					<?php while($object = mysqli_fetch_object($result_select)):
					?>
					<option value ="<?=$object->id?>"><?=$object->fname?></option>
					<?php
					endwhile;
					?>
					</select>
				</div>
				<input type="submit" name="product" value="Записать в БД">
			</form>
			<?php } else {?>
				<p>Ваша корзина пуста</p>
			<?php }
			?>
			
	
			<?php 
		require_once "block/footer.php";
	?>
	</main>
	

</body>

</html>