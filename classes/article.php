<?php
	class Article
	{
		public $name;
		public $text;
		public $creation_date;
		public $author;

		public function initialize($name, $text, $creation_date, $author)
		{
			$this->name = $name;
			$this->text = $text;
			$this->creation_date = $creation_date;
			$this->author = $author;
		}
	}
?>
