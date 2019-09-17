<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Главная страницы</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<style type="text/css">
		body {
			background-color: #EDEEF0;
		}
		.index_regist {
			border-radius: 20px;
			margin-top: 100px;
			margin-left: 25%;
			background-color: #AC9B91;
			width: 50%;
			height: 400px;
		}
		.index_regist a {
			background-color: grey;
			text-align: center;
			padding-top: 60px;
		}
		.last-button-regist {
			border-radius: 0 0 20px 20px;
			border-top: 2px solid black;
		}
		p {
			text-align: center;
			padding-top: 50px;
			font-size: 25px;
		}
		a:link {text-decoration: none; color: black;} 
   		a:visited { text-decoration: none; color: black;} 
   		a:active { text-decoration: none; color: black;}
   		a:hover {text-decoration: none; color: black; background-color: #A3A3A3;} 
		@media (max-width: 600px) {
			.index_regist {
				width: 100%;
				height: 500px;
				margin-left: 0;
				border-radius: 0;
				margin-top: 0;
				user-select: none;
			}
			.last-button-regist {
				border-radius: 0;
			}
			p {
				padding-top: 70px;
			}
		}

	</style>
	<?php 
	require 'db.php';
	?>

	<?php if ( isset ($_SESSION['logged_user']) ) : ?>
		Авторизован! <br/>
		Привет, <?php echo $_SESSION['logged_user']->login; ?>!<br/>

		<a href="logout.php">Выйти</a>

	<?php else : ?>
	<div class="index_regist row">
	<p class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Вы не авторизованы</p>
	<a href="login.php" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Авторизация</a>
	<a href="signup.php" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 last-button-regist">Регистрация</a>
	</div>
	<?php endif; ?>
</body>
</html>



