<?php
@session_start();
$file = $_GET['file'] ?? null;
$filepath = $_SESSION['dir']."/".$_GET['file'];
$folder = $_GET['folder'] ?? null;
$program = $_GET['program'] ?? null;
/*
if($file == "/" || $folder == "/" || substr($folder,0,3) == "../" || substr($file,0,3) == "../")
    die("nice try");

if($program == true){
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=\"program.7z\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Type: binary/octet-stream");
    //readfile("program.7z");
} 
*/
if($_GET['type'] == "download"){
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=".$_GET['file']."");
    header("Content-Transfer-Encoding: binary");
    header("Content-Type: binary/octet-stream");
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
}
else if(isset($_GET['folder'])){
    $dirname = $_SESSION['dir']."/".$_GET['folder'];
    if (is_dir($dirname)) {
        $dir = new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS);
        foreach (new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST) as $object) {
            if ($object->isFile()) {
                unlink($object);
            } elseif($object->isDir()) {
                rmdir($object);
            } else {
                die('Unknown object type: '. $object->getFileName());
            }
        }
        rmdir($dirname); // Now remove myfolder
    } else {
        die('This is not a directory');
    }
    die('Successfully removed');
}
else if($_GET['type'] == "delete"){
    unlink($_SESSION['dir']."/".$_GET['file']);
    echo "Item successfully removed";
}
else{
    echo "Error";
}
