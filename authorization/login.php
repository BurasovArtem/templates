
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Авторизация</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<style type="text/css">
		body {
			background-color: #EDEEF0;
		}
		.login_form {
			border-radius: 20px;
			margin-top: 100px;
			margin-left: 25%;
			background-color: #AC9B91;
			width: 50%;
			height: 400px;
		}
		.butt_auth {
			position: absolute;
			width: 40vw;
			border: none;
			background-color: #D5B352;
			margin-left: 2%;
			height: 50px;
			border-radius: 30px;
		}
		.butt_auth:hover {
			background-color: #D5FF59;
		}
		table {
			width: 100%;
			border-spacing: 30px;
			border-collapse: inherit;
		}
		strong {
			margin-left: 5vw;
		}
		input {
			width: 20vw;
			border-radius: 15px;
			border: none;
			padding-left: 15px;
			height: 35px;
		}
		p {
			padding-top: 20px;
			text-align: center;
			font-size: 30px;
			font-weight: 600;
		}
		@media (max-width: 600px) {
			.login_form {
				width: 100%;
				height: 500px;
				margin-left: 0;
				border-radius: 0;
				margin-top: 0;
				user-select: none;
			}
			input {
				width: 50vw;
				height: 35px;
			}
			.butt_auth {
				width: 80vw;
			}
		}
	</style>
	<form action="login.php" method="POST" class="login_form">
		<table>
			<tr>
				<p>Авторизация</p>
			</tr>
			<tr>
				<td>
					<strong>Логин</strong>
				</td>
				<td>
					<input type="text" name="login" value="<?php echo @$data['login']; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Пароль</strong>
				</td>
				<td>
					<input type="password" name="password" value="<?php echo @$data['password']; ?>">
				</td>
			</tr>
			<tr>
				<td class="last-td">
					<button type="submit" name="do_login" class="butt_auth">Войти</button>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

<?php 
	require 'db.php';

	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		$user = R::findOne('users', 'login = ?', array($data['login']));
		if ( $user )
		{
			//логин существует
			if ( password_verify($data['password'], $user->password) )
			{
				//если пароль совпадает, то нужно авторизовать пользователя
				$_SESSION['logged_user'] = $user;
				echo '<div style="color:green;">Вы авторизованы!<br/> Можете перейти на <a href="index.php">главную</a> страницу.</div><hr>';
			}else
			{
				$errors[] = 'Неверно введен пароль!';
			}

		}else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}
		
		if ( ! empty($errors) )
		{
			//выводим ошибки авторизации
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
		}

	}

?>