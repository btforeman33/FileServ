<?php
    if(session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

$homework = fopen("homework.txt", "r") or die("Unable to open file!");

echo "<p>";

while(($txt = fgets($homework))){
    echo $txt;
    echo "<br>";
}

echo "</p>";
?>