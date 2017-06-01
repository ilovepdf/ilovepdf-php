<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Ilovepdf;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$ilovepdf = new Ilovepdf('project_public_id','project_secret_key');

// and get the task tool
$myTask = $ilovepdf->newTask('merge');

// file var keeps info about server file id, name...
// it can be used latter to cancel a specific file
$fileA = $myTask->addFile('/path/to/file/document_a.pdf');
$fileB = $myTask->addFile('/path/to/file/document_b.pdf');

// process files
$myTask->execute();

// and finally download file. If no path is set, it will be downloaded on current folder
$myTask->download();