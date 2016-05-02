<?php
include_once 'navbar.php';
$titleErr = $authorErr = $ISBNErr = $yearErr = $availableErr = "";
$title = $author = $ISBN = $year = $available = "";
$ok = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ok = true;
    if (empty($_REQUEST["title"])) {
        $titleErr = "Required field";
        $ok = false;
    } else {
        $title = test_input($_POST["title"]);
    }

    if (empty($_POST["author"])) {
        $authorErr = "Required field";
        $ok = false;
    } else {
        $author = test_input($_POST["author"]);
    }

    if (empty($_POST["ISBN"])) {
        $ISBNErr = "Required field";
        $ok = false;
    } else {
        $ISBN = test_input($_POST["ISBN"]);
    }

    if (empty($_POST["pub_year"])) {
        $yearErr = "Required field";
        $ok = false;
    } else {
        $year = test_input($_POST["pub_year"]);
    }

    if (empty($_POST["available"])) {
        $availableErr = "Required field";
        $ok = false;
    } else {
        $available = test_input($_POST["available"]);
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<div class="main-wrapper">
<div class="form-addbook">
    <h1>Add a new book to the library</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <label for="title">Book title:</label>
        <span class="error">* <?php echo $titleErr;?></span>
        <input type="text" name="title" id="title" placeholder="e.g. The Return of The King" value="<?php echo $title;?>"/>


        <label for="author">Name of author:</label>
        <span class="error">* <?php echo $authorErr;?></span>
        <input type="text" name="author" placeholder="e.g. J.R.R. Tolkien" value="<?php echo $author;?>"/>


        <label for="ISBN">ISBN:</label>
        <span class="error">* <?php echo $ISBNErr;?></span>
        <input type="text" name="ISBN" placeholder="e.g. 0-261-10237-0" value="<?php echo $ISBN;?>"/>


        <label for="pub_year">Published year:</label>
        <span class="error">* <?php echo $yearErr;?></span>
        <input type="number" min=1000 max=<?php echo date("Y");?> name="pub_year" placeholder="e.g. 1955" value="<?php echo $year;?>"/>


        <div class="input-radio">
            <label for="available">Available:</label>
            <input type="radio" name="available" value="Yes" checked/>Yes
            <input type="radio" name="available" value="No"/>No
            <span class="error">* <?php echo $availableErr;?></span>
        </div>
        
        <input type="submit" value="Add book" name="submit"/>
    </form>
</div>

<?php
if ($ok) {
    echo $db->addBook($title, $author, $ISBN, $year, $available);
}
?>
</div>
<?php
include_once 'serverinfo.php';
?>

</body>
</html>
