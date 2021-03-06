<?php
/**
 * navbar.php
 *
 * Needs to be loaded in the beggining of each webpage to display the navigation bar as well as initialising and
 * creating a database connection variable.
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="stylesheet" href="/Oblig3itpe2410/View/style.css">
</head>
<body>

<?php
// Create DB connection
require $_SERVER['DOCUMENT_ROOT'] . "/Oblig3itpe2410/DAL/DB.php";
$db = new DB();
?>

<div class="header">
<a href="/Oblig3itpe2410/index.php">
    <img src = "/Oblig3itpe2410/images/logo.png">
</a>
</div>
<div class="nav">
    <ul>
        <li>
            <a href="/Oblig3itpe2410/index.php" title="Homepage of the website">Home</a>
        </li>
        <li>
            <div class="dropdown">
                <a href="" class="dropbtn">Library database</a>
                <div class="dropdown-content">
                    <a href="/Oblig3itpe2410/View/books.php" title="Browse and delete from all library books">Books</a>
                    <a href="/Oblig3itpe2410/View/authors.php" title="Browse and delete from all authors">Authors</a>
                </div>
            </div>
        </li>
        <li>
            <div class="dropdown">
                <a href="" class="dropbtn">Register content</a>
                <div class="dropdown-content">
                    <a href="/Oblig3itpe2410/View/addbook.php" title="Add a new book to the library">Add book</a>
                    <a href="/Oblig3itpe2410/View/addauthor.php" title="Add a new author to the library">Add author</a>
                </div>
            </div>
        </li>
        <li style="float:right"><a href="http://www.1112.net/lastpage.html">Sign out</a></li>
    </ul>
</div>
