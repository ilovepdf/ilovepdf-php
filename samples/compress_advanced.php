<?php
//include the autoloader
require_once('../vendor/autoload.php');

use Ilovepdf\CompressTask;


//you can call task class directly
$myTask = new CompressTask("PUBLIC_KEY", "SECRET_KEY");

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/document.pdf');

// we can set rotate to file
$file->setRotation(90);

// set compression level
$myTask->setCompressionLevel('extreme');

// and set name for output file.
// the task will set the correct file extension for you.
$myTask->setOutputFilename('lowlow_compression');

// process files
// time var will have info about time spent in process
$time = $myTask->execute();

// and finally download file. If no path is set, it will be donwloaded on current folder
$myTask->download('path/to/download');