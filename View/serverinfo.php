<?php

function webserverInfo($server_ip) {
    $serverInfo = "Active web server: "."<br>";
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
<div class="server-info">
    <?php echo webserverInfo($_SERVER['SERVER_ADDR']);?>
    <br>
    <br>
    <?php $server_id = $db->getServerId();?>
    <?php echo databaseInfo($server_id);?>
</div>
