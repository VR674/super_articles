<?php 
echo <<<article
	<div>
		<h1>$obj->name</h1> 
		$obj->text 
		<br>
		<br>
		Добавил: $obj->author ($obj->creation_date)
		<hr>
	</div>
article;
?>

