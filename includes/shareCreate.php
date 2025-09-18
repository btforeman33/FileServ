<?php
@session_start();
//PHP call for share creation
$input = $_POST['shareInput'];
$dir = $_SESSION['dir'];

//Sanitize input so no symbols
$text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $input);


if ($handle = opendir($dir)) {
    while (false !== ($entry = readdir($handle))) {
        if($entry == $text){
            die("Invalid name for share, choose another!");
        }
    }
}
else{
    die('Failed!');
}

echo $dir."/".$text;
mkdir($dir."/".$text);
$_SESSION['access'] = [];

//Setting up database call for modifying access to shares
include("pdo.php");


//Grabbing and updating user access vaults
$stmt = $pdo->prepare("SELECT vaults FROM users WHERE username=?");
$stmt->execute([$_SESSION['username']]);
$finish=$stmt->fetch();

$vaults = $finish['vaults'];
$vaults = explode(",",$vaults);
$vaults[] = $text;
$vaults = implode(",",$vaults);

$stmt = $pdo->prepare("UPDATE users SET vaults='$vaults' WHERE username=?");
$stmt->execute([$_SESSION['username']]);
$finish=$stmt->fetch();

//making new entry is vaultdb, which is for some reason named vaultdb and i don't know how to change it
$stmt = $pdo->prepare("INSERT INTO vaultdb (vault,invite) VALUES(?,?)");
$stmt->execute([$text,md5($text)]);
$finish=$stmt->fetch();

echo "Successfully created share, refresh directory to have it appear.";

?>
