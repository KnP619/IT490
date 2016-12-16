<?php
$ip = "192.168.56.110";
//print_r($output);
//echo $status . '\n';
 
do{
    exec("ping -c 2 ".$ip, $output, $status);
    if($status == 1){
        echo "Primary machine has gone offline - switching to primary \n";
        break;
    }
    else {
        echo "Primary machine is online \n";
    }
}while($status == 0);
 
echo "loop broken - code to be executed \n";
