<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Добавление вопроса</title>
</head>
<body class="center">
	<nav class="menu">
		<ul>
			<li><a href="index.php">На главную</a></li>
			<li><a href="?question=list">Список вопросов</a></li>	
		</ul>
	</nav>

	<h1>Задайте свой вопрос через форму ниже</h1>
	<form class="add-question" action="?question=add" method="POST">
		<input type="text" name="author" value="<?php echo !empty($_POST['author']) ? $_POST['author'] : ''; ?>" placeholder="Имя">
		<input type="text" name="email" value="<?php echo !empty($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Email">
		<select name="category_id">
			<option value="" disabled>Выберите категорию</option>

            <?php foreach ($data as $category): ?>

			<option value="<?php echo $category['id']?>" <?php echo (!empty($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : ''; ?>><?php echo $category['category_name']?></option>

            <?php endforeach; ?>

		</select>
		<textarea name="question" placeholder="Напишите здесь свой вопрос"><?php echo !empty($_POST['question']) ? $_POST['question'] : ''; ?></textarea>
		<button name="add_question" value="add">Отправить</button>
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