<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";

	//проверка пользователя
	if(!empty($_POST))
		if( !db_connect() ) {
			
			$usr= htmlentities(mysqli_real_escape_string($conn,$_POST["login"]));
			$passwd = htmlentities(mysqli_real_escape_string($conn,$_POST["password"]));
			
			if (!empty($usr))
				if (!db_login($usr, $passwd)) {
						$ok = "Welcome!!";
						
						$_SESSION["login"] = $usr; //сохраняем имя пользователя
						$_SESSION["status"] = get_user_status($usr); //права пользователя
						header("Location: index1.php"); exit;
						
				} else {
					$error = "Не правильный логин или пароль";
				}
			else 
				$error = "Логин не может быть пустым";
			
			// закрываем соединение
			db_close();			
		} else 
			$error = "Ошибка подключения";
	
?>
<!DOCTYPE html>
<html>

<head>

	
	<!-- -->
	<link rel="stylesheet" href="css/sign-up.css">
	<script src="js/sign-up.js"></script>
	
</head>

<body>

	
	<main>
		<h2>Авторизация</h2>
		<?php
		if(isset($error))
			echo <<<_OUT
				<div id="msg-error" class="msg msg-error">
					<div>$error</div>
					<div class="closed" onclick="msgClose('msg-error')">&#10006;</div>
				</div>
_OUT;
		else if(isset($ok))
			echo <<<_OUT
				<div id="msg-ok" class="msg msg-ok">
					<div>$ok</div>
					<div class="closed" onclick="msgClose('msg-ok')">&#10006;</div>
				</div>
_OUT;
		?>
		
		<form id="sign-up" method="POST">
			<input type="login" name="login" placeholder="E-mail" required>
			<input type="password" name="password" placeholder="Пароль" required>
			<input type="submit" name="sign-up-submit" value="Войти">
			<div class="create_new_ac"><a href="reg.php">Регистрация<a>
		</form>
		
	</main>
	
	

</body>

</html>