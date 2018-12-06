<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Главная страница</title>
</head>
<body class="center">
    <?php if (!empty($_SESSION['admin_id'])): ?>

	<h1>Добро пожаловать, <?php echo $_SESSION['login']; ?>!</h1>

	<nav class="menu">
		<ul>
			<li><a href="?question=list">Список вопросов</a></li>
			<li><a href="?admin=main">Панель управления</a></li>
			<li><a href="?logout=yes">Выйти</a></li>			
		</ul>
	</nav>
	
    <?php else: ?>
	
	<nav class="menu">
		<ul>
			<li><a href="?auth=yes">Войти как администратор</a></li>
			<li><a href="?question=list">Список вопросов</a></li>
			<li><a href="?question=add">Задать вопрос</a></li>
		</ul>		
	</nav>

    <?php endif; ?>
	
</body>
</html>