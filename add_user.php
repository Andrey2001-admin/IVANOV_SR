<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";
?>
<html lang="ru">
 <?php require_once "block/head.php"; ?>
<body>

<?php 
		require_once "block/header.php"; // шапка сайта
		require_once "block/nav.php"; // меню 
		
	?>

  <?php
	require_once "include/mysqli.php";
    $host = 'localhost';
    $user = 'root';
    $passwords = '';
    $db_status = 'nogovitsin_db';
    $conn = mysqli_connect($host, $user, $passwords, $db_status);

    if (!$conn) {
      echo 'Ошибка с соединением.Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }
			$user = htmlentities(mysqli_real_escape_string($conn, $_POST["login"]));
			$password = htmlentities(mysqli_real_escape_string($conn, $_POST["password"]));
			$status = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));
    if (isset($_POST["status"])) {
      if (isset($_GET['red_id'])) {
          $sql = mysqli_query($conn, "UPDATE `user` SET `status` = '{$_POST['status']}',`login` = '{$_POST['login']}',`password` = '{$_POST['password']}'  WHERE `id`={$_GET['red_id']}");
      } else {
		  add_usr($user, $password, $status);
      }

      if ($sql) {
        echo '<p>Запись добавлена в БД</p>';
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($conn) . '</p>';
      }
    }

    if (isset($_GET['del_id'])) {
      $sql = mysqli_query($conn, "DELETE FROM `user` WHERE `id` = {$_GET['del_id']}");
      if ($sql) {
        echo "<p>Запись удалена</p>";
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($conn) . '</p>';
      }
    }

    if (isset($_GET['red_id'])) {
      $sql = mysqli_query($conn, "SELECT `id`, `status`, `login`,`password` FROM `user` WHERE `id`={$_GET['red_id']}");
      $product = mysqli_fetch_array($sql);
    }
  ?>
  <form action="" method="post">
    <table>
      <tr>
        <td>Доступ:</td>
        <td><select Name="status" value="<?= isset($_GET['red_id']) ? $product['status'] : ''; ?>">
				<option value="admin">Администратор</option>
				<option value="user">Пользователь</option>
			</select></td>

      </tr>
      <tr>
        <td>Логин:</td>
        <td><input type="text" Name="login" size="50" value="<?= isset($_GET['red_id']) ? $product['login'] : ''; ?>"></td>
      </tr>
	  <tr>
        <td>Пароль:</td>
        <td><input type="text" Name="password" size="50" value="<?= isset($_GET['red_id']) ? $product['password'] : ''; ?>"></td>
      </tr>
	  <tr>
        <td>Потверждение пароля:</td>
        <td><input type="text" Name="ppassword" size="50" value="<?= isset($_GET['red_id']) ? $product['password'] : ''; ?>"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Добавить"></td>
      </tr>
    </table>
  </form>
  <table border='1'>
    <tr>
      <td>Доступ</td>
      <td>Логин</td>
	  <td>Пароль</td>
    </tr>
    <?php
      $sql = mysqli_query($conn, 'SELECT `id`, `status`, `login`,`password` FROM `user`');
      while ($result = mysqli_fetch_array($sql)) {
        echo '<tr>' .
             "<td>{$result['status']}</td>" .
             "<td>{$result['login']} </td>" .
			 "<td>{$result['password']}</td>" .
             '</tr>';
      }
    ?>
  </table>
  
</body>
</html>