<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$target_path = $_SESSION['dir'];
//For files <100 MB
    foreach(array_keys($_FILES) as $i){
        if (isset($_POST['submit'])){
            $errors = [];
            if(!isset($_FILES[$i]))
                $errors[] = "No File Submitted";
            if (isset($_FILES[$i]['name']) && $_FILES[$i]['name'] != ""){

                //moves uploaded file to correct directory
                $fileName = $_FILES[$i]['name'];
                //echo "<script>console.log(\"wtf\");</script>";
                if (move_uploaded_file($_FILES[$i]['tmp_name'], $target_path."/". $_FILES[$i]['name']) === FALSE){
                    $errors[] = var_dump($_FILES);
                    $errors[] = "Could not move uploaded file to ".$target_path."/".htmlentities($_FILES[$i]['name'])."<br/>\n";
                }
            }
            if (sizeof($errors) != 0){
                foreach ($errors as $error){
                    echo $error.'<br>';
                    }
                }
            else{
                echo ("Successfully uploaded ").$_FILES[$i]['name']."<br>";
            }
        }
    }
    /*
else{
    //For files over 100MB in slices ----> NONE OF THIS MATTERED WTF
    print(var_dump($_FILES['chunk']['size']));
    $rawData = file_get_contents($_FILES['chunk']['tmp_name']);
    $fileName = $_POST['name'].".part";
    if(file_exists($fileName))
        $output = fopen($fileName, "a");
    else
        $output = fopen($fileName, "w");
    fwrite($output,$rawData);
    fclose($output);
    if(filesize($fileName) == $_POST['size']){
        print("<br>".substr($fileName,0,strlen($fileName)-5)."<br>");
        //if((rename($fileName,substr($fileName,0,strlen($fileName)-5))) === FALSE){
        //}
        
    }
    print("done");
}
*/
