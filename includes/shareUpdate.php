<?php 
@session_start();
$invite = $_POST['invite'];
$invite = trim($invite);
if($invite == ""){
     die("Invalid name entered, try again");
}

//Setting up database call for modifying access to shares
include("pdo.php");

$stmt = $pdo->prepare("SELECT vault FROM usersdb WHERE invite=?");
$stmt->execute([$invite]);
$finish=$stmt->fetch();
$vault = $finish['vault'];

//Grabbing and updating user access vaults
$stmt = $pdo->prepare("SELECT vaults FROM users WHERE username=?");
$stmt->execute([$_SESSION['username']]);
$finish=$stmt->fetch();

$vaults = $finish['vaults'];
if(in_array($vault,explode(",",$vaults))) die("Already have access to that vault!");
echo var_dump($vaults);
$vaults = explode(",",$vaults);
$vaults[] = $vault;
$_SESSION['access'] = $vaults;
$vaults = implode(",",$vaults);

$stmt = $pdo->prepare("UPDATE users SET vaults='$vaults' WHERE username=?");
$stmt->execute([$_SESSION['username']]);
$finish=$stmt->fetch();

echo "<script>ajaxNavigation('shares');</script>";

?>
