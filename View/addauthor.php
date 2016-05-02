<?php
include_once 'navbar.php';
$authorErr = "";
$author = "";
$ok = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ok = true;
    if (empty($_POST["author"])) {
        $authorErr = "Required field";
        $ok = false;
    } else {
        $author = test_input($_POST["author"]);
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
    <h1>Add a new author the database</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <label for="author">Name of author:</label>
        <span class="error">* <?php echo $authorErr;?></span>
        <input type="text" name="author" placeholder="e.g. J.R.R. Tolkien" value="<?php echo $author;?>"/>

        <input type="submit" value="Add author" name="submit"/>
    </form>
</div>

<?php
if ($ok) {
    $exists = $db->getAuthorId($author);
    if ($exists != -1) {
        echo "$author allready exists in the database.";
    } else {
        $success = $db->addAuthor($author);
        if ($success == -1) {
            echo "Oops. Could not add $author to the database.";
        } else {
            echo "$author has been succesfully added to the database with the author id: $success";
        }
    }
}
?>

<?php
include_once 'serverinfo.php';
?>
</body>
</html>
