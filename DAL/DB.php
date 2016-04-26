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
}