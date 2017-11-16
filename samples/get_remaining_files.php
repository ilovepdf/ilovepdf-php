<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Ilovepdf;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$ilovepdf = new Ilovepdf('project_public_id', 'project_secret_key');


//get remaining files
$remainingFiles = $ilovepdf->getRemainingFiles();


//print your remaining files
echo $remainingFiles;

//only start new process if you have enough files
if($remainingFiles>0) {
    //start the task
    $myTask = $ilovepdf->newTask('merge');
}