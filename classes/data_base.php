<?php

	class Data_base
	{
		public $pdo;

		public function __construct($host, $db_name, $charset, $user, $pass)
		{
			$dsn = 'mysql:host=' . $host . ';dbname=' . $db_name . ';charset=' . $charset;
			$this->pdo = new PDO($dsn, $user, $pass);
			$this->pdo->exec("SET NAMES = utf8");
			$this->pdo->exec("SET CHARACTER SET UTF8");
		}

		/**
		 * Поиск статьи по запросу
		 * @param string $query
		 * return Article array
		 */
		public function find_text($query)
		{ 
			$prepared_query = '%' . $query . '%';

			// поиск статьи, в которой совпадения в названии, тексте или имени автора
			$stmt = $this->pdo->prepare('SELECT articles.name, articles.text, articles.creation_date, authors.name as author FROM articles INNER JOIN authors ON articles.author_id = authors.id WHERE (articles.text LIKE :query OR authors.name LIKE :query OR articles.name LIKE :query) ORDER BY articles.name ASC');
			$stmt->execute(array('query' => $prepared_query));

			// получение результата будет в виде объекта класса Article
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

			// получение результата запроса в массив, тк найденных статей мб много
			$articles = array();
			while($res = $stmt->fetch())
				$articles[] = $res;

			return $articles;
		}

		/**
		 * Получение всех статей
		 * return Article array
		 */
		public function get_all_articles()
		{ 

			// запрос для получения всех статей(без id таблицы articles)
			$stmt = $this->pdo->prepare('SELECT articles.name, articles.text, articles.creation_date, authors.name as author FROM articles INNER JOIN authors ON articles.author_id = authors.id');
			$stmt->execute();

			// получение результата будет в виде объекта класса Article
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

			// получение результата запроса в массив, тк найденных статей мб много
			$articles = array();
			while($res = $stmt->fetch())
				$articles[] = $res;

			return $articles;
		}


		/**
		 * Добовление новой статьи
		 * @param Article $new_article
		 */
		public function create_new_article($new_article)
		{
			$stmt = $this->pdo->prepare("INSERT IGNORE INTO authors (name) VALUES (:author); INSERT INTO articles (name, text, creation_date, author_id) VALUES (:name, :text, :creation_date, (SELECT id FROM authors WHERE name = :author));");
			$stmt->execute(array('name' => $new_article->name, 'text' => $new_article->text, 'creation_date' => $new_article->creation_date, 'author' => $new_article->author));
		}
	}	
?>
