<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Панель управления</title>
</head>
<body class="center">
	<h1>Добро пожаловать, <?php echo $_SESSION['login']; ?>!</h1>
	
	<nav class="menu">
		<ul>
			<li><a href="?admin=categories">Управление вопросами</a></li>
			<li><a href="?admin=list">Управление администраторами</a></li>
			<li><a href="index.php">На главную</a></li>			
			<li><a href="?logout=yes">Выход</a></li>			
		</ul>
	</nav>
	
</body>
</html>