<?php
include_once 'navbar.php';
?>
<div id ="pagewrap">
<h1>List of all library books</h1>
<?php
include_once '../DAL/DB.php';

$db = new DB();

$books = $db->displayAllBooks();
?>
</div>

