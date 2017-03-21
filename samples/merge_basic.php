<?php
//include the autoloader
require_once('../vendor/autoload.php');

use Ilovepdf\Ilovepdf;


// start the manager classy
$ilovepdf = new Ilovepdf("PUBLIC_KEY", "SECRET_KEY");

// and get the task tool
$myTask = $ilovepdf->newTask('merge');

// file var keeps info about server file id, name...
// it can be used latter to cancel a specific file
$fileA = $myTask->addFile('/path/to/file/document_a.pdf');
$fileB = $myTask->addFile('/path/to/file/document_b.pdf');

// process files
// time var will have info about time spent in process
$time = $myTask->execute();

// and finally download file. If no path is set, it will be downloaded on current folder
$myTask->download();