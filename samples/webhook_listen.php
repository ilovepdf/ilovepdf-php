<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Task;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$myTask = new Task('project_public_id','project_secret_key');

// get info from the webhook
$myTask->setWorkerServer($_POST['server']);
$myTask->setTask($_POST['task']);

//and download the file
$myTask->download();