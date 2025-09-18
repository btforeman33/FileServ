<?php
include("pdo.php");

$myfile = fopen("validation.log", "w") or die('failed to open file!');
$username = $_POST['user'] ?? null;
$password = $_POST['pass'] ?? null;
$passcheck = $_POST['passcheck'] ?? null;
$userdata = array();
$passdata = array();
$errors = 0;
$txt = "STARTING VALIDATION OF $username AND password\n\n";
fwrite($myfile, $txt);
$txt = "Is username not empty...";
$stmt = $pdo->prepare("SELECT username FROM users WHERE username=?");
$stmt->execute([$username]);
$finish=$stmt->fetch();
if($finish == true)
    die("<a style='color:red'>Username is taken!</a>");

if ($username != null){
    $txt = $txt."PASSED\n";
    fwrite($myfile, $txt);

    $txt = "Checking username length...";

    if (strlen($username) >= 6 && strlen($username) <= 12){
        $userdata[] = "<a style='color:green'>(✓) Username between 6-12 characters.</a>";
        $txt = $txt."PASSED\n";
    }
    else{
        $userdata[] = "<a style='color:red'>(✗) Username between 6-12 characters.</a>";
        $errors += 1;
        $txt = $txt."FAILED\n";
    }

    fwrite($myfile, $txt);
    $txt = "Checking for alphanumeric characters...";

    if (preg_match("/\W/", $username) == 1){
        $userdata[] = "<a style='color:red'>(✗) Only use alphanumeric characters & underscores in the username.</a>";
        $errors += 1;
        $txt = $txt."FAILED\n";
    }
    else{
        $userdata[] = "<a style='color:green'>(✓) Only use alphanumeric characters & underscores in the username.</a>";
        $txt = $txt."PASSED\n";
    }

    foreach ($userdata as $data){
        echo $data;
        echo "<br>";
    } 
}
elseif ($username == null){
    echo "<a style='color:red'>(✗) Empty Username</a>";
    $txt = $txt."FAILED\nNo more username validation required\n";
    fwrite($myfile, $txt);
    $errors += 1;
}
echo "<br><br>";

$txt = "\nIs password not empty...";

if ($password != null){
    $txt = $txt."PASSED\n";
    fwrite($myfile, $txt);
    $txt = "Do passwords match...";
    if ($password == $passcheck){
        $passdata[] = "<a style='color:green'>(✓) Passwords match</a>";
        $txt = $txt."PASSED\n";
    }
    else{
        $passdata[] = "<a style='color:red'>(✗) Passwords match</a>";
        $txt = $txt."FAILED\n";
        $errors += 1;
    }

    fwrite($myfile, $txt);
    $txt = "Do passwords fit length...";

    if (strlen($password) >= 8 && strlen($password) <= 16){
        $passdata[] = "<a style='color:green'>(✓) Password 8-16 characters</a>";
        $txt = $txt."PASSED\n";
        
    }
    else{
        $passdata[] = "<a style='color:red'>(✗) Password 8-16 characters</a>";
        $txt = $txt."FAILED\n";
        $errors += 1;
    }

    fwrite($myfile, $txt);
    $txt = "Check for number...";

    if (preg_match("/[0-9]/", $password) == 1){
        $passdata[] = "<a style='color:green'>(✓) Atleast one number</a>";
        $txt = $txt."PASSED\n";
    }

    else{
        $passdata[] = "<a style='color:red'>(✗) Atleast one number</a>";
        $txt = $txt."FAILED\n";
        $errors += 1;
    }

    fwrite($myfile, $txt);
    $txt = "Check for lowercase...";

    if (preg_match("/[a-z]/", $password) == 1){
        $passdata[] = "<a style='color:green'>(✓) Atleast one undercase character</a>";
        $txt = $txt."PASSED\n";
    }
    else{
        $passdata[] = "<a style='color:red'>(✗) Atleast one undercase character</a>";
        $txt = $txt."FAILED\n";
        $errors += 1;
    }

    fwrite($myfile, $txt);
    $txt = "Check for uppercase...";

    if (preg_match("/[A-Z]/", $password) == 1){
        $passdata[] = "<a style='color:green'>(✓) Atleast one uppercase character</a>";
        $txt = $txt."PASSED\n";
    }
    else{
        $passdata[] = "<a style='color:red'>(✗) Atleast one uppercase character</a>";
        $txt = $txt."FAILED\n";
        $errors += 1;
    }

    fwrite($myfile, $txt);
    $txt = "Check no spaces...";

    if (strpos($password," ") == true){
        $passdata[] = "<a style='color:red'>(✗) Password contains no spaces</a>";
        $txt = $txt."FAILED\n";
        $errors += 1;
    }
    else{
        $passdata[] = "<a style='color:green'>(✓) Password contains no spaces</a>";
        $txt = $txt."PASSED\n";
    }

    fwrite($myfile, $txt);
    $txt = "Check for special character...";

    if (preg_match("/[!#$%&'()*\",-.\/:;<=>?@[^\]_`{|}~]/", $password)){
        $passdata[] = "<a style='color:green'>(✓) Atleast one special characters</a>";
        $txt = $txt."PASSED\n";
    }
    else{
        $passdata[] = "<a style='color:red'>(✗) Atleast one special characters</a>";
        $txt = $txt."FAILED\n";
        $errors += 1;
    }

    fwrite($myfile, $txt);

    foreach($passdata as $output){
        echo "<br>";
        echo $output;
    }
    echo "<br><br>";

    if ($errors == 0){
        $hash = password_hash($password,1);
	$mysqltime = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("INSERT INTO users (username, password, LastLogin, UserID, vaults) VALUES (?, ?, '".$mysqltime."', NULL, '');");
        $stmt->execute([$username,$hash]);
        //mkdir("../../users/$username"); Handled Elsewhere
        echo "Creation successful!";
    }
}
else
    echo "<a style='color:red'>(✗) Password empty</a>";
    $txt = $txt."FAILED\nNo more password validation required\n";
    fwrite($myfile, $txt);
