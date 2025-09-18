<?php
@session_start();
echo "<h1>This page is a work in progress!</h1><hr>";
/*
if($_SESSION['username'] != "btforeman33"){
    die("Not allowed!");
}

$services = ["enshrouded","JMusic"];

//functions for grabbing something from one of the servers.
function processPID($query){
    $process = shell_exec('tasklist | find "enshrouded_server.exe"');
    if($query == 'start'){
        if($process != NULL) return false;
        $cmd = 'F:\SteamLibrary\steamapps\common\EnshroudedServer\enshrouded_server.exe';
        pclose(popen("start /B ". $cmd, "r"));
        return true;
    }
    if($process == NULL) return false;
    else{
        $process = explode("      ",trim($process))[1];
        $shroudPID = explode(" ",trim($process))[0];
        if(is_numeric($shroudPID)){
            if($query == 'query') return $shroudPID;
            if($query == 'kill') return shell_exec("taskkill /PID ".$shroudPID." /F");
        };
    }
}

function musicPID($query){
    echo $query;
    $output = trim(shell_exec("jps"));
    $botCommand = explode("\n",$output);
    $process = NULL;
    for($i = 0; $i < sizeof($botCommand); $i++){
        $indice = explode(" ",$botCommand[$i]);
        if(substr($indice[1],0,2) == "Mu"){
            $process = $indice;
        }
    }
    if($query == 'start'){
        if($process != NULL) return false;
        $cmd = 'java -Dnogui=true -jar "C:\Users\Brayden\Desktop\Music Bot\JMusicBot-0.3.9.jar"';
        pclose(popen("start /B ". $cmd, "r"));
        return true;
    }
    if($process == NULL) return false;
    else{
        $botPID = $process[0];
        if(is_numeric($botPID)){
            if($query == 'query') return $botPID;
            if($query == 'kill'){
                shell_exec('taskkill /PID '.$botPID." /F");
            }
        };
    }
}




if(isset($_POST['target'])){
    echo "Command Received, please wait approximately 5 seconds for change to take effect.";
    switch ($_POST['target']){
        case 'enshrouded':
            processPID($_POST['change']);
            break;
        case 'music':
            musicPID($_POST['change']);
            break;
    }
}
else{
    $status = [];

    //currently the status being returned is a arbitrary number based on the order of the functions below, 0 is enshrouded, 1 is music.
    if(processPID('query') == false) $status[0] = 0;
    else $status[0] = 1;

    if(musicPID('query') == false) $status[1] = 0;
    else $status[1] = 1;



    echo "<table><tbody>";
    for($i = 0; $i < sizeof($services); $i++){
        $id = $services[$i];
        echo "<tr>";
        echo "<td>";
        echo "<button id='$id' onclick=\"serverQuery(this.id, 'start')\">Start $id</button>";
        echo "</td><td>";
        echo "<button id='$id' onclick=\"serverQuery(this.id, 'kill')\">Kill $id</button>";
        echo "</td><td>";
        echo "$id running: ".(boolval($status[$i]) ? "true" : "false");
        echo "</td></tr>";
    }
    echo "</tbody></table>";

    echo '<div id="serverOutput"></div>';

    


}
*/
?>