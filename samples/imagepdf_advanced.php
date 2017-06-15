<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\ImagepdfTask;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$myTask = new ImagepdfTask('project_public_id','project_secret_key');

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
$myTask->execute();

// and finally download file. If no path is set, it will be downloaded on current folder
$myTask->download();