<?php 
	require 'db.php';

	$data = $_POST;

	function captcha_show(){
		$questions = array(
			1 => 'Столица России',
			2 => 'Столица США',
			3 => '2 + 3',
			4 => '15 + 14',
			5 => '45 - 10',
			6 => '33 - 3'
		);
		$num = mt_rand( 1, count($questions) );
		$_SESSION['captcha'] = $num;
		echo $questions[$num];
	}

	//если кликнули на button
	if ( isset($data['do_signup']) )
	{
    // проверка формы на пустоту полей
		$errors = array();
		if ( trim($data['login']) == '' )
		{
			$errors[] = 'Введите логин';
		}

		if ( trim($data['email']) == '' )
		{
			$errors[] = 'Введите Email';
		}

		if ( $data['password'] == '' )
		{
			$errors[] = 'Введите пароль';
		}

		if ( $data['password_2'] != $data['password'] )
		{
			$errors[] = 'Повторный пароль введен не верно!';
		}

		//проверка на существование одинакового логина
		if ( R::count('users', "login = ?", array($data['login'])) > 0)
		{
			$errors[] = 'Пользователь с таким логином уже существует!';
		}
    
    //проверка на существование одинакового email
		if ( R::count('users', "email = ?", array($data['email'])) > 0)
		{
			$errors[] = 'Пользователь с таким Email уже существует!';
		}

		//проверка капчи
		$answers = array(
			1 => 'москва',
			2 => 'вашингтон',
			3 => '5',
			4 => '29',
			5 => '35',
			6 => '30'
		);
		if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
		{
			$errors[] = 'Ответ на вопрос указан не верно!';
		}


		if ( empty($errors) )
		{
			//ошибок нет, теперь регистрируем
			$user = R::dispense('users');
			$user->login = $data['login'];
			$user->email = $data['email'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
			R::store($user);
			echo '<div style="color:dreen;">Вы успешно зарегистрированы!</div><hr>';
		}else
		{
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
	<meta charset="utf-8">

</head>
<body>
	<style type="text/css">
		body {
			background-color: #EDEEF0;
		}
		a {
			text-align: center;
		}
		.form_regist {
			border-radius: 20px;
			margin-top: 100px;
			margin-left: 25%;
			background-color: #AC9B91;
			width: 50vw;
			height: 450px;
		}
		.form_regist button {
			height: 50px;
			border-radius: 20px;
			border: none;
			background-color: #D5B352;
			position: absolute;
			margin-left: 2vw;
			width: 30vw;
		}
		.form_regist button:hover {
			background-color: #D5FF59;
		}
		.form_regist input {
			border-radius: 10px;
			border: none;
			padding-left: 10px;
			width: 20vw;
			height: 30px;
		}
		table {
			margin-left: 5vw;
			border-spacing: 20px;
		}
		td {
			height: 40px;
		}
		.singlup_auth {
			position: absolute;
			width: 35vw;
		}
		a:link {text-decoration: none; color: blue;} 
   		a:visited {text-decoration: none; color: blue;} 
   		a:active {text-decoration: none; color: blue;}
   		a:hover {text-decoration: none; color: blue;} 
		@media (max-width: 600px) {
			.form_regist {
				width: 100%;
				height: 500px;
				margin-left: 0;
				border-radius: 0;
				margin-top: 0;
				user-select: none;
			}
			.form_regist button {
				height: 50px;
				border-radius: 20px;
				border: none;
				background-color: #D5B352;
				position: absolute;
				margin-left: 2vw;
				width: 70vw;
			}
			.singlup_auth {
				width: 73vw;
			}
		}
		@media (max-width: 700px) {
			.form_regist input {
				margin-left: -25px;
			}
		}
		/*@media (max-width: 800px) {
			.singlup_auth {
				position: absolute;
				margin-left: 8vw;
			}
		}*/
		@media (max-width: 600px) {
			.form_regist input {
				margin-left: 20px;
				width: 40vw;
			}
		}
	</style>
	<form action="signup.php" method="POST" class="form_regist row">
		<table>
			<tr>
				<td>
					<strong>Ваш логин</strong>
				</td>
				<td>
					<input type="text" name="login" value="<?php echo @$data['login']; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Ваш Email</strong>
				</td>
				<td>
					<input type="email" name="email" value="<?php echo @$data['email']; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Ваш пароль</strong>
				</td>
				<td>
					<input type="password" name="password" value="<?php echo @$data['password']; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong>Повторите пароль</strong>
				</td>
				<td>
					<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<strong class="block_inline"><?php captcha_show(); ?></strong>
				</td>
				<td>
					<input type="text" name="captcha" >
				</td>
			</tr>
			<tr>
				<td>
					<button type="submit" name="do_signup" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Регистрация</button>
				</td>
			</tr>
			<tr>
				<td>
					<a href="login.php" class="singlup_auth col-xs-12 col-sm-12 col-md-12 col-lg-12">Авторизируйтесь</a>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
