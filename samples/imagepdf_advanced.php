<?php
//include the autoloader
require_once('../vendor/autoload.php');

use Ilovepdf\ImagepdfTask;


//you can call task class directly
$myTask = new ImagepdfTask("PUBLIC_KEY", "SECRET_KEY");

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/photo.jpg');
$file = $myTask->addFile('/path/to/file/image.tiff');

// set merge after
$myTask->setMergeAfter(false); //default is true. If false will download a zip file with a pdf for each image

// and set name for output file.
// the task will set the correct file extension for you.
$myTask->setOutputFilename('pdf_file_name');
$myTask->setPackagedFilename('zip_file_name');

// process files
// time var will have info about time spent in process
$time = $myTask->execute();

// and finally download file. If no path is set, it will be donwloaded on current folder
$myTask->download();