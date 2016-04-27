<?php
$OK = true;
$db = new mysqli("localhost", "root","","library");
if($db->connect_error)
{
    $OK=false;
}
$file= file_get_contents('Library.SQL');

$res = $db->multi_query($file);
if($res)
{
    do {
        if ($result = $db->store_result()) {
            if($result == false)
            {
                $OK = false;
            }
            $result->free();
        }
        $db->more_results();
    } while ($db->next_result());

}
else
{
    $OK=false;
}
$db->close();
if ($OK) {
    echo "Database has been succesfully reset.";
} else {
    echo "Database failed to reset.";
}