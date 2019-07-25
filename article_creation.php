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

			$article_name = '';
			$article_text = '';
			$author =  '';

			if(isset($_POST['article_name']) && isset($_POST['article_text']) && isset($_POST['author']))
			{
				// если в форме остаются пустыне поля, то значения заполненных полей остаются
				if($_POST['article_name'] != '' && $_POST['article_text'] != '' && $_POST['author'] != '' )
				{
					$creation_date = date('Y-m-d');
					$new_article = new Article();
					$new_article->initialize(htmlspecialchars($_POST['article_name']), htmlspecialchars($_POST['article_text']), $creation_date, htmlspecialchars($_POST['author']));
					$articles_db->create_new_article($new_article);
					header('location: index.php' . '?search_query=' .  $new_article->name);
				}
				else
				{
					$article_name = htmlspecialchars($_POST['article_name']);
					$article_text = htmlspecialchars($_POST['article_text']);
					$author = htmlspecialchars($_POST['author']);
					echo '<center>Не все поля были заполнены!</center>';
				}
			}

		?>
		<table class='creation_table'>
			<form action='' method='POST' name='creation_form'>
				<tr>
					<td>Название статьи</td>
				</tr>
				<tr>
					<td>
						<input type='text' name='article_name' class='name_field' value=<?php echo $article_name; ?>>
					</td>
				</tr>
				<tr>
					<td>Текст статьи</td>
				</tr>
				<tr>
					<td>
						<textarea name='article_text' class='text_field'><?php echo $article_text; ?></textarea>
					</td>
				</tr>
				<tr>
					<td>Автор</td>
				</tr>
				<tr>
					<td>
						<input type='text' name='author' class='name_field' value=<?php echo $author; ?>>
					</td>
				</tr>
				<tr>
					<td>
						<input type='submit' class='create_button' value='Создать'>
					</td>
				</tr>
			</form>
		</table>
		
	</div>
</body>

</html>
