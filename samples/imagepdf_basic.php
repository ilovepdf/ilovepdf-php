<?php
//include the autoloader
require_once('../vendor/autoload.php');

use Ilovepdf\ImagepdfTask;


//you can call task class directly
$myTask = new ImagepdfTask("PUBLIC_KEY", "SECRET_KEY");

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/photo.png');

// process files
$myTask->execute();

// and finally download file. If no path is set, it will be donwloaded on current folder
$myTask->download();