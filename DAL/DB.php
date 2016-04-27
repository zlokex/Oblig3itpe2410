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

    function displayBooks($filter) {
        // Prevent injections:
        $filter = $this->conn->real_escape_string($filter);
        // Build query:
        $query = "SELECT b.bookid, b.title, a.name, b.pub_year, b.available 
                  FROM books b, authors a 
                  WHERE (a.authorid = b.authorid)
                  AND (b.bookid LIKE '%$filter%'
                  OR b.title LIKE '%$filter%'
                  OR b.ISBN LIKE '%$filter%'
                  OR b.pub_year LIKE '%$filter%'
                  OR b.available LIKE '%$filter%'
                  OR a.name LIKE '%$filter%')
                  ORDER BY b.bookid";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $output= "<table class='booksTable'>";
            $output.= "<tr><th>Select</th><th>S.N</th><th>Book title</th><th>Author name</th><th>Published year</th><th>Available</th></tr>";

            while ($row = $result->fetch_object()) {
                $output.= "<tr><td><input type='checkbox' name='bookcbs[]' value='$row->bookid'></td>
                      <td>$row->bookid</td><td>$row->title</td><td>$row->name</td>
                      <td>$row->pub_year</td><td>$row->available</td></tr>";
            }
            $output.= "</table>";
            return $output;
        } else {
            $output= "No results for library books";
            return $output;
        }
    }

    function displayAllBooks() {
        $query = "SELECT b.bookid, b.title, a.name, b.pub_year, b.available 
                  FROM books b, authors a 
                  WHERE a.authorid = b.authorid
                  ORDER BY b.bookid";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $output= "<table class='booksTable'>";
            $output.= "<tr><th>Select</th><th>S.N</th><th>Book title</th><th>Author name</th><th>Published year</th><th>Available</th></tr>";

            while ($row = $result->fetch_object()) {
                $output.= "<tr><td><input type='checkbox' name='bookcbs[]' value='$row->bookid'></td>
                      <td>$row->bookid</td><td>$row->title</td><td>$row->name</td>
                      <td>$row->pub_year</td><td>$row->available</td></tr>";
            }
            $output.= "</table>";
            return $output;
        } else {
            $output= "No results for library books";
            return $output;
        }
    }

    function deleteBooks($books) {
        $query = "DELETE FROM books WHERE bookid IN ($books[0]";
        for ($i = 1; $i < count($books); $i++) {
            $query.=",$books[$i]";
        }
        $query.=")";
        $result = $this->conn->query($query);
        if (mysqli_affected_rows($this->conn) > 0) {
            return "Book(s) have been succesfully deleted.";
        } else {
            return "Ooops. We had problems handling your delete request. Please try again later or contact us through our support page.";
        }
    }

    function addAuthor($name) {
        $name = $this->conn->real_escape_string($name);
        $query = "INSERT INTO authors(name) VALUES ('$name')";
        $result = $this->conn->query($query);
        if (mysqli_affected_rows($this->conn) > 0) {
            return mysqli_insert_id($this->conn); // Return last inserted id
        } else {
            return -1;
        }
    }

    function getAuthorId($name) {
        $name = $this->conn->real_escape_string($name);
        $query = "SELECT authorid FROM authors
                  WHERE name = '$name'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
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
        echo "<br>";
        echo $authorid;
        echo "<br>";
        if ($authorid == -1) { // Author does not allready exist
            // Add author and get the new authorid.
            $authorid = $this->addAuthor($author);
        }
        $query = "INSERT INTO books (authorid, title, ISBN, pub_year, available) VALUES
        ($authorid, '$title', $ISBN, $pub_year, '$available')";

        $result = $this->conn->query($query);
        if (mysqli_affected_rows($this->conn) > 0) {
            return "Success. '$title' has now been added to the library database.";
        } else {
            return "Oops. We were not able to add '$title' to the library database. Please check to see if all fields
            are entered correctly. If the problem persists try again later or contact us via our support page.";
        }
    }
}