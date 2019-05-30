<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Ilovepdf;


//this is a sample for a chined task. You can perform multiple tasks on a files uploading just once.

// you can call task class directly
// to get your key pair, please visit https://developer.iloveimg.com/user/projects
$ilovepdf = new Ilovepdf('project_public_id','project_secret_key');

$splitTask = $ilovepdf->newTask('split');

$splitTask->addFile('your_file.pdf');

//get the 2nd page
$splitTask->setRanges("2");
// run the task
$splitTask->execute();

//and create a new task from last action
$convertTask = $splitTask->next('pdfjpg');

// process files
$convertTask->execute();

// and finally download file. If no path is set, it will be downloaded on current folder
$convertTask->download('path/to/download');