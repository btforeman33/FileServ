<?php
if(@$_POST['submit'] == true){
    if($_POST['type'] == 'tables'){

        //Creating a PDO call for setting up the db, as you can't create a db with the standard pdo.php, as the database does not exist yet.        
        $host = '127.0.0.1';
        $db = '';
        $user = 'fileServ';
        $pass = 'Password123!';
        $dsn = "mysql:host=$host;";
        $options = [
        PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
		echo $e->getMessage();
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        $stmt = $pdo->prepare("CREATE DATABASE `fileServ`");
        $stmt->execute();
        $finish=$stmt->fetch();

        if($finish == false) echo "Successfully created fileServ Database!\n";
        else die($finish);
        
        $stmt = $pdo->prepare("CREATE TABLE `fileServ`.`users` (`username` VARCHAR(20) NOT NULL , `password` VARCHAR(100) NOT NULL , `LastLogin` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `UserID` INT(20) NULL , `vaults` VARCHAR(255) NOT NULL );");
        $stmt->execute();
        $finish=$stmt->fetch();
        
        if($finish == false) echo "Successfully created users table!\n";
        else die($finish);

        $stmt = $pdo->prepare("CREATE TABLE `fileServ`.`vaultdb` (`vault` VARCHAR(255) NULL , `invite` VARCHAR(255) NOT NULL );");
        $stmt->execute();
        $finish=$stmt->fetch();
        
        if($finish == false) echo "Successfully created vaultdb table!\n";
        else die($finish);
    }
    if($_POST['type'] == 'files'){
        if(!is_dir($_POST['location'])){
            mkdir($_POST['location']);
            echo 'Successfully created directory!<br>';
            $file = fopen('settings.php', 'w');
            $string = '<?php $dir = "'.$_POST['location'].'" ?>';
            fwrite($file, $string);
            fclose($file);
            echo 'Successfully wrote settings in settings.php!<br>';
        }
        else{
            die('Directory exists!');
        }
    }
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    function runSetup(type){
        var formData = {
                'type' : type,
                'location' : $('#fileDir').val(),
                'submit' : true
            };
        $.ajax({
            url: "setup.php",
            type: "POST",
            data: formData,
            success: function(result){$("#output").html(result);},
            error: function(result,status,err){$("#output").html(err)}
        });
    }
</script>


<br>

<h1> SETUP PAGE </h1>

<hr>

<h2>Directories</h2>
<input id="fileDir" value="<?php echo getcwd()."\\files"; ?>"></input> - Where the files for uploads will be stored <br>
<button onclick="runSetup('files')">Create Folders</button>

<hr>

<h2>Database Setup</h2>
<p>
    Running the following commands are necessary for allowing the website to access and modify the databases it needs. Enter into your mySQL CLI and paste both commands. If you want to change the password or username, make sure to change it in includes/pdo.php as well.
    <br>
    CREATE USER 'fileServ'@'localhost' IDENTIFIED BY 'password';
    <br>
    GRANT ALL ON fileServ.* TO 'fileServ'@'localhost';
</p>
<br>
<p>
    After running the commands, press the following button to finish setting up tables inside the database.
</p>
<button onclick="return runSetup('tables');">Create tables</button>

<hr>
<div>
    Output
    <textarea id="output" style="width:90%;height:10%">
    </textarea>
</div>

<?php
//making folders
/*
if(!opendir($filesDir)){
    mkdir($filesDir);
}
mkdir($filesDir."files");
mkdir($filesDir."shares");
*/
