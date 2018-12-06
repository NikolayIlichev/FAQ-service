<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="view/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="view/css/style.css"> <!-- Resource style -->
	<script src="view/js/modernizr.js"></script> <!-- Modernizr -->
	<title>FAQ</title>
</head>
<body>
<header>
	<h1>FAQ</h1>
</header>
<nav class="menu center">
	<ul>
		<li><a href="index.php">На главную</a></li>	
	</ul>
</nav>

<section class="cd-faq">

<?php if ($data): ?>

	<ul class="cd-faq-categories">

        <?php foreach ($data as $questions): ?>

		<li><a href="#<?php echo $questions[0]['category_id']; ?>"><?php echo $questions[0]['category_name']; ?></a></li>

        <?php endforeach; ?>
	</ul> <!-- cd-faq-categories -->

	<div class="cd-faq-items">

        <?php foreach ($data as $questions): ?>

		<ul id="<?php echo $questions[0]['category_id']; ?>" class="cd-faq-group">
			<li class="cd-faq-title"><h2><?php echo $questions[0]['category_name']; ?></h2></li>
			
            <?php foreach ($questions as $question): ?>

			<li>
				<a class="cd-faq-trigger" href="#0"><?php echo $question['question']; ?></a>
				<div class="cd-faq-content">
					<p><?php echo $question['answer']; ?></p>
				</div> <!-- cd-faq-content -->
			</li>

            <?php endforeach; ?>

		</ul> <!-- cd-faq-group -->
		
        <?php endforeach; ?>

	</div> <!-- cd-faq-items -->
	<a href="#0" class="cd-close-panel">Close</a>

<?php else: ?>

	<h3>Опубликованных вопросов пока нет!</h3>

<?php endif; ?>

</section> <!-- cd-faq -->
<script src="view/js/jquery-2.1.1.js"></script>
<script src="view/js/jquery.mobile.custom.min.js"></script>
<script src="view/js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>