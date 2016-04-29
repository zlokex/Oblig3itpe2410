<?php

class DB
{

    // Database login fields:
    private $servername = "libraryDB";
    private $username = "root";
    private $password = "";
    private $dbname = "library";

    private $conn; // Database link/connection

    /**
     * DB constructor.
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * Creates a connection to the database.
     */
    function connect()
    {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $this->conn->set_charset("utf8");
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * Create a formatted table with books matching the provided filter.
     *
     * @param $filter string to filter the SELECT query
     * @return string with formatted html table tags and data
     */
    function displayBooks($filter)
    {
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

        return $this->buildBooksTable($result);
    }

    /**
     * Create a formatted table containing all books in the database.
     *
     * @return string with formatted html table tags and data
     */
    function displayAllBooks()
    {
        $query = "SELECT b.bookid, b.title, a.name, b.pub_year, b.available 
                  FROM books b, authors a 
                  WHERE a.authorid = b.authorid
                  ORDER BY b.bookid";
        $result = $this->conn->query($query);

        return $this->buildBooksTable($result);
    }

    /**
     * Helper method that returns a formatted html table with data from a
     * mysqli->query() books result.
     *
     * @param $result from a mysqli->query()
     * @return string with formatted html table tags and data
     */
    private function buildBooksTable($result)
    {
        if ($result->num_rows > 0) {
            $output = "<table class='booksTable' width='690px' style='text-align:center'>";
            $output .= "<thead><tr><th>Select</th><th>S.N</th><th>Book title</th>
                        <th>Author name</th><th>Published year</th><th>Available</th></tr></thead>";
            $output .= "<tbody>";
            while ($row = $result->fetch_object()) {
                $output .= "<tr><td><input type='checkbox' name='bookcbs[]' value='$row->bookid'></td>
                      <td>$row->bookid</td><td>$row->title</td><td>$row->name</td>
                      <td>$row->pub_year</td><td>$row->available</td></tr>";
            }
            $output .= "</tbody></table>";
            return $output;
        } else {
            $output = "No results for library books";
            return $output;
        }
    }

    /**
     * Deletes one or more rows/books in in the books table.
     *
     * @param $books array containing books.bookid of the books that are to be deleted.
     * @return string notifying the success of the query.
     */
    function deleteBooks($books)
    {
        if (count($books) > 0) {
            $query = "DELETE FROM books WHERE bookid IN ($books[0]";
            for ($i = 1; $i < count($books); $i++) {
                $query .= ",$books[$i]";
            }
            $query .= ")";
            $result = $this->conn->query($query);
            if (mysqli_affected_rows($this->conn) > 0) {
                return "Book(s) have been succesfully deleted.";
            } else {
                return "Ooops. We had problems handling your delete request. Please try again later or contact us through our support page.";
            }
        } else {
            return "No books are selected.";
        }
    }

    /**
     * Create a formatted table containing all authors in the database.
     *
     * @return string with formatted html table tags and data
     */
    function displayAllAuthors()
    {
        $query = "SELECT a.authorid, a.name, 
                  COUNT(b.authorid) AS bookcount
                  FROM authors AS a
                      LEFT JOIN books AS b
                       ON a.authorid = b.authorid
                  GROUP BY a.authorid";
        $result = $this->conn->query($query);

        return $this->buildAuthorsTable($result);
    }

    /**
     * Create a formatted table with authors matching the provided filter.
     *
     * @param $filter string to filter the SELECT query
     * @return string with formatted html table tags and data
     */
    function displayAuthors($filter)
    {
        // Prevent injections:
        $filter = $this->conn->real_escape_string($filter);
        // Build query:
        $query = "SELECT a.authorid, a.name, 
                  COUNT(b.authorid) AS bookcount
                  FROM authors AS a
                      LEFT JOIN books AS b
                       ON a.authorid = b.authorid
                       WHERE b.title LIKE '%$filter%'
                       OR b.ISBN = '%$filter%'
                       OR a.authorid = '$filter'
                       OR a.name LIKE '%$filter%'
                  GROUP BY b.authorid";

        $result = $this->conn->query($query);

        return $this->buildAuthorsTable($result);
    }

    /**
     * Helper method that returns a formatted html table with data from a
     * mysqli->query() authors result.
     *
     * @param $result from a mysqli->query()
     * @return string with formatted html table tags and data
     */
    private function buildAuthorsTable($result)
    {
        if ($result->num_rows > 0) {
            $output = "<table class='booksTable' width='690px' style='text-align:center'>";
            $output .= "<col style='width:10%'>
                      <col style='width:10%'>
                      <col style='width:55%'>
                      <col style='width:25%'>";
            $output .= "<thead><tr><th>Select</th><th>S.N</th><th>Author name</th>
                        <th>Library books</th></tr></thead>";
            $output .= "<tbody>";
            while ($row = $result->fetch_object()) {
                $output .= "<tr><td><input type='checkbox' name='authorscbs[]' value='$row->authorid'></td>
                      <td>$row->authorid</td><td>$row->name</td><td>$row->bookcount</td></tr>";
            }
            $output .= "</tbody></table>";
            return $output;
        } else {
            $output = "No results for authors";
            return $output;
        }
    }

    /**
     * Deletes one or more rows/authors in in the authors table.
     *
     * @param $authors array containing authors.authorid of the authors that are to be deleted.
     * @return string notifying the success of the query.
     */
    function deleteAuthors($authors)
    {
        if (count($authors) > 0) {
            $query = "DELETE FROM authors WHERE authorid IN ($authors[0]";
            for ($i = 1; $i < count($authors); $i++) {
                $query .= ",$authors[$i]";
            }
            $query .= ")";
            $result = $this->conn->query($query);
            if (mysqli_affected_rows($this->conn) > 0) {
                return "Authors(s) have been succesfully deleted.";
            } else {
                return "Ooops. We had problems handling your delete request. Please try again later or contact us through our support page.";
            }
        } else {
            return "No authors are selected.";
        }
    }

    /**
     * Returns number of books the author matching the authorid has in the books table.
     *
     * @param $authorid
     * @return mixed
     */
    function getAuthorBookCount($authorid)
    {
        $query = "SELECT COUNT(*) AS bookcount
                  FROM books 
                  WHERE authorid = $authorid";
        $result = $this->conn->query($query);
        return $result->fetch_object()->bookcount;

    }


    /**
     * Attempts to create a new author to the authors table. Each authors.name needs
     * to be unique to succeed.
     *
     * @param $name full name of the author to be created
     * @return int|string the authorid of the newly created author. -1 if query was unsuccessful.
     */
    function addAuthor($name)
    {
        $name = $this->conn->real_escape_string($name);
        $query = "INSERT INTO authors(name) VALUES ('$name')";
        $result = $this->conn->query($query);
        if (mysqli_affected_rows($this->conn) > 0) {
            return mysqli_insert_id($this->conn); // Return last inserted id
        } else {
            return -1;
        }
    }

    /**
     * Searches for the authorid of the given author by its name in the authors table. Returns -1 if
     * the authors does not exist.
     *
     * @param $name full name of the author to find
     * @return int authorid of the author matching the given name. Returns -1 if author does not exist.
     */
    function getAuthorId($name)
    {
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

    /**
     * Adds a new book to the books table. If the author of the book does not yet exist in
     * the authors table, a new entry is created for that author. The same book can have
     * several entries, and is not unique a part from having a unique (PK) bookid.
     *
     * @param $title of the book
     * @param $author name of the author. Goes in the authors table
     * @param $ISBN of the book
     * @param $pub_year Published year of the book
     * @param $available Yes/No of the books current availability.
     * @return string determining the success of the function
     */
    function addBook($title, $author, $ISBN, $pub_year, $available)
    {
        $title = $this->conn->real_escape_string($title);
        //$author = $this->conn->real_escape_string($author); // Atm redundant.
        $ISBN = $this->conn->real_escape_string($ISBN);
        $pub_year = $this->conn->real_escape_string($pub_year);
        $available = $this->conn->real_escape_string($available);

        // Find the authorid of the given author:
        $authorid = $this->getAuthorId($author);
        // Check if the author exists:
        if ($authorid == -1) { // If our last function call gave us -1, we don't yet have an entry for that author
            // Add author and get the new authorid.
            $authorid = $this->addAuthor($author);
            // Check to see if adding the author failed:
            if ($authorid == -1) {
                // If so, we exit the function withour attempting to add the book:
                return "Oops. We were not able to add '$author' to the library database, and can therefore not
                add '$title' to the library database at the current moment. Please try again later or feel free
                to contact us via our support page.";
            }
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

    function getServerId() {
        $query = "SELECT @@server_id";
        $result = $this->conn->query($query);
        $row = $this->conn->fetch_assoc($result);
        return $row["server_id"];
    }
}
