<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="view/css/style.css">
	<title>Список администраторов</title>
</head>
<body class="center">
	<nav class="menu">
		<ul>
			<li><a href="index.php">На главную</a></li>
			<li><a href="?admin=main">В панель администратора</a></li>
			<li><a href="?logout=yes">Выйти</a></li>
		</ul>		
	</nav>

<?php if (!empty($data)): ?>	
<h1>Список администраторов</h1>		
	<table>
		<thead>
			<tr>
				<td>ID</td>
				<td>Логин</td>
				<td>Пароль</td>
				<td>Удалить</td>
				<!-- <td>Исполнитель</td> -->
			</tr>
		</thead>
		<tbody>

        <?php foreach ($data as $key => $admin): ?>

			<tr>
				<td><?php echo $admin['id']?></td>
				<td><?php echo $admin['login']?></td>
				<td>
					<form class="save-pass"  action="" method="POST">
						<input name="password" type="password" value="<?php echo $admin['password']?>"> 
						<input name="admin_id" type="hidden" value="<?php echo $admin['id']?>">  
						<button type="submit" name="pass_change" value="pass_change">Сохранить пароль</button>
					</form>
				</td>
				<?php if($admin['id'] != $_SESSION['admin_id']):?>
				<td>
					<form action="" method="POST">
						<input name="admin_id" type="hidden" value="<?php echo $admin['id']?>"> 
						<button type="submit" name="admin_remove" value="admin_remove">Удалить администратора</button>
					</form>
				</td>
				<?php else:?>
				<td class="<?php echo $user_id?>">К сожалению, вы не можете удалить самого себя</td>
				<?php endif;?>	
				
			</tr>

        <?php endforeach; ?>

		</tbody>
	</table>

<?php endif; ?>	
	
	<h2>Добавление нового администратора</h2>

	<form class="admin-list-form" action="" method="POST">
		<input type="text" name="login" value="<?php echo !empty($_POST['login']) ? $_POST['login'] : ''; ?>" placeholder="Логин" required>
		<input type="password" name="password" placeholder="Пароль" required>
		<input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
		<button type="submit" name="admin_add" value="admin_add">Добавить администратора</button>
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

	