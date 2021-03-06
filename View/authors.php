<?php
include_once 'navbar.php';
$output ="";
$authors ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        if (!empty($_POST['authorscbs'])){

            $authorscbs = $_POST['authorscbs'];
            $ok = true;
            foreach ($authorscbs as $authorid) {
                $bookcount = $db->getAuthorBookCount($authorid);
                if ($bookcount != 0) {
                    $ok = false;
                }
            }

            if ($ok) {
                $output = $db->deleteAuthors($authorscbs);
            } else {
                $output = "Can not delete author with books listed in library. The field 'Library books' needs to
                    have a value of 0";
            }
        } else {
            $output = "No author(s) selected.";
        }
    }
    if (isset($_POST['searchButton'])) {
        if (!empty($_POST['searchText'])) {
            $filter = $_POST['searchText'];
            $authors = $db->displayAuthors($filter);
        } else {
            $authors = $db->displayAllAuthors();
        }
    }
}
?>

<div class="main-wrapper">
    <h1>List of all authors in the database</h1>
    <div class="search-wrapper">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <input type="text" name="searchText" placeholder="Filter by author name, published books etc..."\>
            <input type="submit" name="searchButton" value="Filter">
        </form>
    </div>

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <?php
        if ($authors == "") {
            $authors = $db->displayAllAuthors();
            echo $authors;
        } else {
            echo $authors;
        }
        ?>
            <span class="spanFormat">
                <input id="deleteButton" type="submit" name="delete" value="Delete selected author(s)">
                <button id="deleteButton" formaction="../DAL/initDB.php" target="_blank">Reset database to default</button>
            </span>
        </form>
    <?php
    echo "<br>".$output;
    ?>
</div>

<?php
include_once 'serverinfo.php';
?>


