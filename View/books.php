<?php
include_once 'navbar.php';
$output ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $books = $_POST['bookcbs'];
    if (count($books) > 0) {
        include_once '../DAL/DB.php';

        $db = new DB();

        $output = $db->deleteBooks($books);
    } else {
        $output = "No book(s) selected.";
    }
    
}
?>



<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<h1>List of all library books</h1>
<div class="search-wrapper">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <input type="text" name="searchText" placeholder="Filter by title, author, etc..." required>
        <input type="button" name="searchButton" value="Filter">
    </form>
</div>
<?php
include_once '../DAL/DB.php';

$db = new DB();

$books = $db->displayAllBooks();
?>
<input type="submit" name="delete" value="Delete selected book(s)">
</form>
<?php
echo $output;
?>


