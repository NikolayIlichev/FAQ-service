<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Список категорий</title>
</head>
<body class="center">

	<nav class="menu">
		<ul>
			<li><a href="?admin=main">Панель управления</a></li>
			<li><a href="index.php">Главная</a></li>
			<li><a href="?logout=yes">Выход</a></li>			
		</ul>
	</nav>

<h1>Список категорий</h1>
<?php if (!empty($data)): ?>

	<table>
		<thead>
			<tr>
				<td>ID</td>
				<td>Название категории</td>
				<td>Всего вопросов</td>
				<td>Без ответа</td>
				<td>Скрыто</td>
				<td>Опубликовано</td>
				<td>Удалить тему и все вопросы в ней</td>
			</tr>
		</thead>
		<tbody>

            <?php foreach ($data as $category): ?>
			
			<tr>
				<td><?php echo $category['id']?></td>
				<td><a href="?category=<?php echo $category['id']?>"><?php echo $category['category_name']?></a></td>
				<td><?php echo $category['count_questions']?></td>
				<td><?php echo $category['unanswered_question']?></td>
				<td><?php echo $category['unactive_question']?></td>
				<td><?php echo $category['active_question']?></td>
				<td>
					<form action="" method="POST">
						<input name="category_id" type="hidden" value="<?php echo $category['id']?>"> 
						<button type="submit" name="category_remove" value="remove">Удалить категорию</button>
					</form>
				</td>
			</tr>

			<?php endforeach; ?>

		</tbody>
	</table>

<?php else: ?>

	<p>Пока не создано ни одной категории.</p>

<?php endif; ?>

	<h2>Создание новой категории</h2>

	<form class="category-add-form" action="" method="POST">
		<input type="text" name="category" value="<?php echo !empty($_POST['category']) ? $_POST['category'] : ''; ?>" placeholder="Название категории">
		<button name="add_category" value="add">Отправить</button>
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
