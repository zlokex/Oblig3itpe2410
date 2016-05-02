<?php
/**
 * serverinfo.php
 * 
 * Needs to be loaded not before, but after all database queries on the active webpage are completed.
 * 
 */


/**
 * Creates a formatted String displaying name and IP of the web server given
 * by an IP as long as the ip-address matches one of the four ips that are part
 * of our current system (hardcoded in)
 *
 * @param $server_ip ip of web server
 * @return string Formatted String showing information of the given web server
 */
function webserverInfo($server_ip) {
    $serverInfo = "Web server used: "."<br>";
    switch ($server_ip) {
        case "10.2.38.5":
            $serverInfo .= "Dats38-web-1"."<br>";
            break;
        case "10.2.38.10":
            $serverInfo .= "Dats38-web-2"."<br>";
            break;
        case "10.2.38.6":
            $serverInfo .= "Dats38-web-3"."<br>";
            break;
        case "10.2.38.8":
            $serverInfo .= "Dats38-web-4"."<br>";
            break;
        default:
            break;
    }
    $serverInfo .= "IP: ".$server_ip;
    return $serverInfo;
}

/**
 * Creates a formatted String displaying name and IP of the database server given
 * by server_id as long as the server_id matches one of the three server ids that are part
 * of our current system (hardcoded in)
 *
 * @param $server_id Server id of database server
 * @return string Formatted String showing information of the given database server
 */
function databaseInfo($server_id) {
    $serverInfo = "Last used database: "."<br>";
    switch ($server_id) {
        case "1":
            $serverInfo .= "Dats38-db-1 (Master)"."<br>";
            $serverInfo .= "IP: 10.2.30.7";
            break;
        case "2":
            $serverInfo .= "Dats38-db-2 (Slave)"."<br>";
            $serverInfo .= "IP: 10.2.30.9";
            break;
        case "3":
            $serverInfo .= "Dats38-db-3 (Slave)"."<br>";
            $serverInfo .= "IP: 10.2.30.11";
            break;
        default:
            $serverInfo .= "No queries have been made";
            break;
    }
    return $serverInfo;
}
?>
<!-- CSS class: server-info will display the server information in the top right corner of the window -->
<div class="server-info">
    <!-- Display web server info -->
    <?php echo webserverInfo($_SERVER['SERVER_ADDR']);?>
    <br>
    <br>
    <?php
    $server_id = "";
    $server_id = $db->getServerId();
    ?>
    <!-- Display database server info -->
    <?php echo databaseInfo($server_id);?>
</div>
