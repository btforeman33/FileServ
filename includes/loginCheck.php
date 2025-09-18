<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
     session_start();
}

include("pdo.php");

$username = $_POST['user'];
$password = $_POST['pass'];

$statement = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$statement->execute([$username]);
$account = $statement->fetch();


//$date = date('Y/m/d H:i:s');    Deprecated
//$statement = $pdo->prepare("INSERT INTO login_log VALUES (Null,?,?)");
//$statement->execute([$username,$date]);
if($account != false){
     $hash = $account['password'];
     if(password_verify($password,$account['password']) == 1){
          //$_POST['type'] was used for possible c# clientside program not relevant in the context of the website
          if(isset($_POST['type'])){
               echo "PASSED";
          }else{
               $_SESSION['username'] = $account['username'];
               //$_SESSION['accesslevel'] = $account['accessLevel'];
               echo "1";
          }
     }
     else{
          if(isset($_POST['type'])){
               echo "Username/Password Invalid!";
          }else{
               echo "<a style='color:red'>Username/Password Invalid!</a>";
          }
     }
}else{
     echo "<a style='color:red'>Username/Password Invalid!</a>";
}
