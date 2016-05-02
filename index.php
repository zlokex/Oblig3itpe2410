<?php
include_once 'View/navbar.php';
?>

<div class="main-wrapper">
<h1>Welcome to the website of The Great Library of Group38</h1>
<par>
    This website is part of the final group project in the subject "Nettverk og skytjenester" (ITPE2410).
    As part of the task this website is deployed on a configuration consisting of eight Virtual Machines:
    <ul>
        <li>One Database master</li>
        <li>Two additional Database slaves</li>
        <li>Connected to four synced webservers</li>
        <li>Who in turn are managed by a single loadbalancer</li>
    </ul>
</par>
</div>
<?php
$server_id ="";
include_once 'serverinfo.php';
?>