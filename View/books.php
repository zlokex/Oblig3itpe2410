<?php
include_once 'navbar.php';
$output ="";
$books ="";
$server_id ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        if (!empty($_POST['bookcbs'])){
            $bookcbs = $_POST['bookcbs'];
            include_once '../DAL/DB.php';

            $db = new DB();
            $server_id = $db->getServerId();

            $output = $db->deleteBooks($bookcbs);
        } else {
            $output = "No book(s) selected.";
        }
    }
    if (isset($_POST['searchButton'])) {
        include_once '../DAL/DB.php';
        $db = new DB();
        $server_id = $db->getServerId();
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
    <span class="spanFormat">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<?php
include_once '../DAL/DB.php';
if ($books == "") {
    $db = new DB();

    $books = $db->displayAllBooks();
    $server_id = $db->getServerId();
}
echo $books;
echo "<br>".$server_id;

?>

        <input id="deleteButton" type="submit" name="delete" value="Delete selected book(s)">
        <button id="deleteButton" formaction="../DAL/initDB.php" target="_blank">Reset database to default</button>
    </form>
</span>
<!--    
<span class="spanFormat">
    <form action="../DAL/initDB.php" target="_blank">
    <input type="submit" id="deleteButton" value="Reset database to default">
    </form>
</span>
-->
<?php
echo "<br>".$output;
?>
</div>


