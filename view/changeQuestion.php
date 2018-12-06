<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Редактирование вопроса</title>
</head>
<body class="center">
	
	<nav class="menu">
		<ul>
			<li><a href="index.php">На главную</a></li>
			<li><a href="?category=<?php echo $data['changeQuestion'][0]['category_id']; ?>">Управление вопросами</a></li>
			<li><a href="?question=list">Страница вопросов</a></li>			
		</ul>
	</nav>

	<h1>Редактирование вопроса</h1>
	<form class="edit-question-form" action="" method="POST">
		<input type="hidden" name="question_id" value="<?php echo $data['changeQuestion'][0]['question_id'] ?: ''; ?>">
		<input type="text" name="author" value="<?php echo $data['changeQuestion'][0]['author'] ?: ''; ?>" placeholder="Имя">
		<select name="category_id">
			<option value="" disabled>Выберите категорию</option>

            <?php foreach ($data['categories'] as $category): ?>

			<option value="<?php echo $category['id']?>" <?php echo $data['changeQuestion'][0]['category_id'] == $category['id'] ? 'selected' : ''; ?>><?php echo $category['category_name']?></option>

            <?php endforeach; ?>

		</select>
		<textarea name="question" placeholder="Вопрос"><?php echo $data['changeQuestion'][0]['question'] ?: ''; ?></textarea>
		<textarea name="answer" placeholder="Ответ"><?php echo $data['changeQuestion'][0]['answer'] ?: ''; ?></textarea>
		Опубликовать <input type="checkbox" name="active" <?php echo ($data['changeQuestion'][0]['active'] == 'Y') ? 'checked' : ''; ?>>
		<button name="change_question" value="change">Отправить</button>
	</form>

	<span class="message">
		
    <?php
    if (!empty($msg)) 
    {
        echo $msg;
    }
    ?>

	</span>

	
</body>
</html>