 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title>db</title>
 	<script type="text/javascript" src="scripts/script.js"></script>
 	<!-- <script type="text/javascript">
		window.onload = () => {
			make_XHR("GET", "DBcreate.php", true, "", console.log);
		}
	</script> -->
 </head>
 <body>
 	<!-- add -->
	<form action="" method="post">
		<h2>Добавление</h2>
		<p>Имя</p>
	    <input type="text" name="name">
	    <p>Фамилия</p>
	    <input type="text" name="surname">
	    <p>Номер</p>
	    <input type="text" name="numberr"><br><br>
		<input type="submit" value="OK">
	</form>
	<!-- drop -->
	<form action="" method="post">
		<h2>Удаление</h2>
		<p>ID</p>
	    <input type="text" name="id"><br><br>
		<input type="submit" value="OK">
	</form>
	<!-- edit -->
	<form action="" method="post">
		<h2>Изменение</h2>
		<p>ID</p>
	    <input type="text" name="id">
		<p>Имя</p>
	    <input type="text" name="name">
	    <p>Фамилия</p>
	    <input type="text" name="surname">
	    <p>Номер</p>
	    <input type="text" name="numberr"><br><br>
		<input type="submit" value="OK">
	</form>
	<!-- getting -->
	<div>
		<h2>Получение</h2>
		<div>
			<?php 
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = '';
			$dbname = 'test_db';
			$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
			if(! $conn ){
				echo 'Connected failure<br>';
			}
			// getting
			$q = "SELECT * FROM test_table";
			$result = mysqli_query($conn, $q);
			while ($r = mysqli_fetch_assoc($result)) {
				echo "
					<table>
						<tr>
							<td>{$r['id']}</td>
							<td>{$r['name']}</td>
							<td>{$r['surname']}</td>
							<td>{$r['numberr']}</td>
						</tr>
					</table>
					";
			}
			?>
		</div>
	</div>
 </body>
 </html>

<?php 
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'test_db';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if(! $conn ){
		echo 'Connected failure<br>';
	}

	// add
	if (isset($_POST["name"])) {
	    $sql = mysqli_query($conn, "INSERT INTO `test_table` (`name`, `surname`, `numberr`) VALUES ('{$_POST['name']}', '{$_POST['surname']}', '{$_POST['numberr']}')");
	    if ($sql) {
	      echo '<p>Данные успешно добавлены в таблицу.</p>';
	      header("Location: index.php");
	    } else {
	      echo '<p>Произошла ошибка: ' . mysqli_error($conn) . '</p>';
	    }
	}

	// drop
	if(isset($_POST['id'])) {
		$query ="DELETE FROM test_table WHERE id = '{$_POST['id']}'";
		$result = mysqli_query($conn, $query) or die ("Ошибка " . mysqli_error($conn)); 
		mysqli_close($conn);
		header('Location: index.php');
	}

	// edit
	if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['id']) && isset($_POST['numberr'])) {
	    $query ="UPDATE tovars SET name = '{$_POST['name']}', surname = '{$_POST['surname']}', numberr = '{$_POST['numberr']}' WHERE id='{$_POST['id']}'";
	    $result = mysqli_query($conn, $query) or die ("Ошибка " . mysqli_error($conn)); 
	    mysqli_close($conn);
		header('Location: index.php');
	}
?>