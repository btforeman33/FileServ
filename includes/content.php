<?php
@session_start();
if(!isset($_SESSION['access'])) $_SESSION['access'] = [];

$_POST['change'] = $_POST['change'] ?? "";
if($_POST['change'] != "move") $_SESSION['change'] = $_POST['change'];
$change = $_SESSION['change'];

if($change == "") $dirDisplay = "/"; 
else $dirDisplay = $change;
if($_SESSION['loc'] == "shares" && $change != ""){
    $vault = explode("/",$change)[1];
}

//Change directory to store things here, as well as verify the directory exists
$dir = "/var/www/webfiles/";

//If statements are for each instance, public vault, private vault, shared vaults.
if($_SESSION['username'] != "guest" && $_SESSION['loc'] == "private"){
    $_SESSION['access']=[];
    $dir = $dir.$_SESSION['username']."".$change;
    if(!file_exists($dir)){
	echo $dir;
        mkdir($dir,0777);
    }
    $_SESSION['dir'] = $dir;
}
else if($_SESSION['loc'] == "shares"){
    $dir = $dir."shares".$change;
    $_SESSION['dir'] = $dir;
}
else{
    $_SESSION['access']=[];
    $dir = $dir."/files".$change;
    $_SESSION['dir'] = $dir;
}
//If location is set, create a new folder and reload, called from makeFolder in JS
if(isset($_POST['loc'])){
    //Sanitize input so no symbols
    $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $_POST['loc']);
    if($text == ""){
        echo "<p style='color:red'>Please enter a valid name</p>";
    }
    elseif (is_dir($dir."/".$text)){
        echo "<p style='color:red'>Directory already exists!</p>";
    }
    else{
        mkdir($dir."/".$text,0777);
	echo var_dump(error_get_last());
    }
    echo $dir."/".$text; 
}


//Setting up database call if inside shares
include("pdo.php");

//grab all shares user has access to, and don't if it is already set
if($_POST != 'guest' && $_SESSION['access'] == [] && $_SESSION['loc'] == "shares"){
    $stmt = $pdo->prepare("SELECT vaults FROM users WHERE username=?");
    $stmt->execute([$_SESSION['username']]);
    $finish=$stmt->fetch();

    $vaults = $finish['vaults'];
    $vaults = explode(",",$vaults);
    $_SESSION['access'] = $vaults;
}

//set invite text
if(isset($vault)){
    $stmt = $pdo->prepare("SELECT invite FROM vaultdb WHERE vault=?");
    $stmt->execute([$vault]);
    $finish=$stmt->fetch();
    $_SESSION['invite'] = $finish['invite'];
}

//handles when to show buttons
if($_SESSION['loc'] == "shares"){
    if($_SESSION['change'] != "") echo '<button id="uploadbutton" onclick="uploadMenu();"><b>Upload</b></button>';
    if($change == ""){
        echo '<button id="uploadbutton" onclick="shareMenu();"><b>Create Share</b></button>
        <input id="shareUpdateInput" type="text" placeholder="Add a new share..."></input>
        <button id="uploadbutton" onclick="shareUpdate();"><b>Update Shares</b></button>
        <div id="shareUpdateOutput"></div>';
    }
    else{ echo "Give this code to someone else to give them access: ".$_SESSION['invite'];
    }
}
else{
    echo '<button id="uploadbutton" onclick="uploadMenu();"><b>Upload</b></button>';
    echo '<button onclick="makeFolder();" style="float:right">Create Folder</button>
    <input type="text" id="loc" style="float:right" placeholder="Enter name of a new folder...">';
} 

include("upload.php");
include("shares.php");

/*
function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        $size+=$file->getSize();
    }
    return $size;
}
*/


$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
if($pageWasRefreshed){
    echo "<script>ajaxNavigation();</script>";
}
//Filewalker section
try
{
    echo "<br>";
    if ($handle = opendir($dir)) {
        echo "<table>";
        while (false !== ($entry = readdir($handle))) {
            if($entry == "."){
                continue;
            }
            //when it goes into try statement, it is echoing a folder, if it falls back to catch it is echoing a file.
            try{
                echo "<tr>";
                @$test = opendir($dir."/".$entry);
                if($_SESSION['loc'] == "shares" && $change == "" && in_array($entry,$_SESSION['access']) != 1 && $entry != "..") continue;
                if($test == null)
                    throw new Exception("L");
                if($entry == ".."){
                    $temp = explode("\\",$change);
                    unset($temp[count($temp)-1]);
                    $change2 = implode("\\",$temp);
                    echo "\n<td id=\"$entry\" onclick='DirInto(\"$change2\")'>";
                }else{
                    echo "\n<td id=\"$entry\" onclick=\"return DirInto('".$change."/".$entry."')\">";
                }
                echo "📁$entry</td></tr>";
            }
            catch (Exception $e)
            {
                //here is where to change stuff attached to file row on the right of the filewalker
                //<button onclick='return fileGrab(\"$entry\",\"delete\")' style=\"float:right;\">Delete</button> showFile() was meant to be a function to see a file (word document, powerpoint, etc.) but wasn't fully created.
                echo "<td>🗎$entry<button onclick='return fileGrab(\"$entry\",\"download\")' style=\"float:right;\">Download</button></td>";
            }
        }
        echo "</table>";
        closedir($handle);
    }
    else{
	//Failed to load directory
        echo "9";
    }
}
catch(Error $e){
    echo "No files to be found!";
}
    
?>
