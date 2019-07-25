<html>
<head>
	<title>Super Articles</title>
	<meta charset='utf-8'>
	<link rel='stylesheet' href='style\style.css'>
</head>

<body>
	<?php include 'templates\header.php';?>
	<div class='body_block'>
		<?php include 'templates\options.php';?>

		<?php
			spl_autoload_register(function($class_name)
			{
				include 'classes' . DIRECTORY_SEPARATOR . strtolower($class_name) . '.php';
			});

			// поделючение к бд
			$host = '127.0.0.1';
			$db_name = 'articles';
			$charset = 'utf8';
			$user = 'root';
			$pass = '1';
			$articles_db = new Data_base($host, $db_name, $charset, $user, $pass);

			if(isset($_GET['search_query']))
			{
				if($_GET['search_query'] == '')
				{
					echo 'В строке поиска ничего не введено.';
				}
				else
				{
					$query = htmlspecialchars($_GET['search_query']);
					$found_articles = $articles_db->find_text($query);

					if(count($found_articles) == 0)
						echo 'По запросу "' . $query . '" ничего не найдено!';
					else
					{
						foreach ($found_articles as $index => $obj) {
							include 'templates\pasteboard_of_article.php';
						}
					}
				}
			}

			if(isset($_GET['get_all_button']))
			{
				$found_articles = $articles_db->get_all_articles();
				if(count($found_articles) == 0)
					echo 'Ничего не найдено!';
				else
				{
					foreach ($found_articles as $index => $obj) {
						include 'templates\pasteboard_of_article.php';
					}
				}
			}			
		?>
	</div>
</body>

</html>
