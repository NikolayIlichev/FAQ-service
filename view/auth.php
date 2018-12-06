<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Авторизация</title>
</head>
<body class="center">
	<nav class="menu">
		<ul>
			<li><a href="?question=list">Список вопросов</a></li>
			<li><a href="index.php">На главную</a></li>	
		</ul>
	</nav>

	<h2>Пожалуйста, авторизуйтесь</h2>

	<form class="auth" action="" method="POST">
		<input type="text" name="login" value="<?php echo !empty($login) ? $login : ''; ?>" placeholder="Логин" required>
		<input type="password" name="password" placeholder="Пароль" required>
		<button type="submit" name="log_in" value="log_in">Войти</button>
	</form>

    <span class="message">
		
    <?php
    if (!empty($msg)) {
        echo $msg;
    }
    ?>

	</span>
</body>
</html>