<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Ilovepdf;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$ilovepdf = new Task('project_public_id', 'project_secret_key');


//start the task
$myTask = $ilovepdf->newTask('merge');

//get remaining files
$remainingFiles = $myTask->getRemainingFiles();

//print your remaining files
echo $remainingFiles;