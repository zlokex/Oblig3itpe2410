<?php

class DB {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "library";

    private $conn; // Database link/connection

    function __construct() {
        $this->connect();
    }
    
    function connect() {
        // Create connection
        $this->conn=new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $this->conn->set_charset("utf8");
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function displayAllBooks() {
        $query = "SELECT b.bookid, b.title, a.name, b.pub_year, b.available 
                  FROM books b, authors a 
                  WHERE a.authorid = b.authorid
                  ORDER BY b.bookid";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table id='booksTable'>";
            echo "<tr><th>S.N</th><th>Book title</th><th>Author name</th><th>Published year</th><th>Available</th>";

            while ($row = $result->fetch_object()) {
                echo "<tr><td>$row->bookid</td><td>$row->title</td><td>$row->name</td>
                      <td>$row->pub_year</td><td>$row->available</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No results for library books";
        }
    }

    function addAuthor($name) {
        $name = $this->conn->real_escape_string($name);
        $query = "INSERT INTO authors(name) VALUES
        ('$name')";
        $result = $this->conn->query($query);
        if ($result->affected_rows > 0) {
            return mysqli_insert_id($this->conn);
        } else {
            return -1;
        }
    }

    function getAuthorId($name) {
        $name = $this->conn->real_escape_string($name);
        $query = "SELECT authorid FROM authors
                  WHERE name = '$name'";
        $result = $this->conn->query($query);
        if ($result->affected_rows > 0) {
            return $result->fetch_object()->authorid;
        } else {
            return -1;
        }
    }

    function addBook($title, $author, $ISBN, $pub_year, $available) {
        $title = $this->conn->real_escape_string($title);
        //$author = $this->conn->real_escape_string($author);
        $ISBN = $this->conn->real_escape_string($ISBN);
        $pub_year = $this->conn->real_escape_string($pub_year);
        $available = $this->conn->real_escape_string($available);

        $authorid = $this->getAuthorId($author);
        if ($authorid == -1) { // Author does not allready exist
            // Add author and get the new authorid.
            $authorid = $this->addAuthor($author);
        }

        $query = "INSERT INTO books (authorid, title, ISBN, pub_year, available) VALUES
        ('$authorid, $title', '$ISBN', $pub_year, '$available')";

        $result = $this->conn->query($query);
        if ($result->affected_rows > 0) {
            return "Success. '$title' has now been added to the library database.";
        } else {
            return "Oops. We were not able to add '$title' to the library database. Please check to see if all fields
            are entered correctly.' If the problem persists try again later or contact us via our support page.";
        }
    }
}