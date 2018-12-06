<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Управление вопросами</title>
</head>
<body class="center">
	<nav class="menu">
		<ul>
			<li><a href="?admin=categories">Список категорий</a></li>
			<li><a href="?admin=main">Панель управления</a></li>
			<li><a href="index.php">Главная</a></li>			
			<li><a href="?logout=yes">Выход</a></li>			
		</ul>
	</nav>
	
	<h1>Вопросы в категории <?php echo $data['category_name']; ?></h1>

<?php if($data['questions']): ?>

	<table>
		<thead>
			<tr>
				<td>ID</td>
				<td>Вопрос</td>
				<td>Ответ</td>
				<td>Автор</td>
				<td>Публикация</td>
				<td>Дата создания</td>
				<td>Категория</td>
				<td>Удаление</td>
				<td>Редактирование</td>
			</tr>
		</thead>
		<tbody>

            <?php foreach ($data['questions'] as $question): ?>
			
			<tr>
				<td><?php echo $question['question_id']?></td>
				<td><?php echo $question['question']?></a></td>
				<td><?php echo $question['answer']?></td>
				<td><?php echo $question['author']?></td>
				<td>
					<form action="" method="POST">
						<input name="question_id" type="hidden" value="<?php echo $question['question_id']?>">
						<input name="active" type="hidden" value="<?php echo ($question['active'] == 'N') ? 'Y' : 'N'; ?>"> 
						<button type="submit" name="question_active" value="change"><?php echo ($question['active'] == 'N') ? 'Опубликовать' : 'Снять с публикации'; ?></button>
					</form>
				</td>
				<td><?php echo $question['date_create']?></td>
				<td>
					<form class="change-category-form" action="" method="POST">
						<input name="question_id" type="hidden" value="<?php echo $question['question_id']?>"> 
						<select name="new_category_id">
							<option value="" disabled>Выберите категорию</option>

                            <?php foreach ($data['categories'] as $category): ?>

							<option value="<?php echo $category['id']?>" <?php echo $question['category_id'] == $category['id'] ? 'selected' : ''; ?>><?php echo $category['category_name']?></option>

                            <?php endforeach; ?>

						</select>
						<button name="change_category" value="change">Сохранить</button>
					</form>
				</td>
				<td>
					<form action="" method="POST">
						<input name="question_id" type="hidden" value="<?php echo $question['question_id']?>"> 
						<button type="submit" name="question_remove" value="remove">Удалить вопрос</button>
					</form>
				</td>
				<td><a href="?question_change=<?php echo $question['question_id']?>">Редактировать</a></td>
			</tr>

            <?php endforeach; ?>

		</tbody>
	</table>

<?php else: ?>

	<h3>Вопросов в данной категории пока нет!</h3>

<?php endif; ?>

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