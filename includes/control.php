<?php
$page = $_REQUEST['page'] ?? "null";
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
switch ($page) {
    case 'files':
        $_SESSION['loc'] = "public";
        include 'content.php';
        break;

    case 'vault':
        $_SESSION['loc'] = "private";
        include 'content.php';
        break;

    case 'homework':
        $_SESSION['loc'] = "homework";
        include 'homework.php';
        break;

    case 'shares':
        $_SESSION['loc'] = "shares";
        include 'content.php';
        break;

    case 'signup':
        include 'signup.php';
        break;

    case 'servers':
        include 'servers.php';
        break;

    case 'login':
        include 'login.php';
        break;

    case 'logout':
        $_SESSION['username'] = "guest";
        echo "<script> location.reload(); </script>";
        header("Refresh:0");
        break;

    default:
	$_SESSION['loc'] = "public";
        include 'content.php';
        break;
}
