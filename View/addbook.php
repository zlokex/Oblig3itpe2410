<?php
include_once 'navbar.php';
var_dump( $_POST );
$titleErr = $authorErr = $ISBNErr = $yearErr = $availableErr = "";
$title = $author = $ISBN = $year = $available = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_REQUEST["title"])) {
        $titleErr = "Required field";
    } else {
        $title = test_input($_POST["title"]);
    }

    if (empty($_POST["author"])) {
        $authorErr = "Required field";
    } else {
        $author = test_input($_POST["author"]);
    }

    if (empty($_POST["ISBN"])) {
        $ISBNErr = "Required field";
    } else {
        $ISBN = test_input($_POST["ISBN"]);
    }

    if (empty($_POST["pub_year"])) {
        $yearErr = "Required field";
    } else {
        $year = test_input($_POST["year"]);
    }

    if (empty($_POST["available"])) {
        $availableErr = "Required field";
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

<div class="form-addbook">
    <h1>Add a new book to the library</h1>
    <form name = "form1" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
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
include_once '../DAL/DB.php';
$db = new DB();
?>
</body>
</html>
