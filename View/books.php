<?php
include_once 'navbar.php';
$output ="";
$books ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        if (!empty($_POST['bookcbs'])){
            $bookcbs = $_POST['bookcbs'];
            include_once '../DAL/DB.php';

            $db = new DB();

            $output = $db->deleteBooks($bookcbs);
        } else {
            $output = "No book(s) selected.";
        }
    }
    if (isset($_POST['searchButton'])) {
        include_once '../DAL/DB.php';
        $db = new DB();
        if (!empty($_POST['searchText'])) {
            $filter = $_POST['searchText'];
            $books = $db->displayBooks($filter);
        } else {
            $books = $db->displayAllBooks();
        }
    }
}
?>


<div class="main-wrapper">
<h1>List of all library books</h1>
<div class="search-wrapper">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <input type="text" name="searchText" placeholder="Filter by title, author, etc..."\>
        <input type="submit" name="searchButton" value="Filter">
    </form>
</div>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<?php
include_once '../DAL/DB.php';
if ($books == "") {
    $db = new DB();

    $books = $db->displayAllBooks();
    echo $books;
} else {
    echo $books;
}
?>
<input id="deleteButton" type="submit" name="delete" value="Delete selected book(s)">
</form>
<?php
echo $output;
?>
</div>


