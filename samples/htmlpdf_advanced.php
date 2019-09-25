<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');


use Ilovepdf\HtmlpdfTask;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$myTask = new HtmlpdfTask('project_public_id','project_secret_key');

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addUrl('https://ilovepdf.com');

// set page margin
$myTask->setPageMargin(20);

// set one large page
$myTask->setSinglePage(true);

// and set name for output file.
// the task will set the correct file extension for you.
$myTask->setOutputFilename('ilovepdf_web');

// process files
$myTask->execute();

// and finally download file. If no path is set, it will be downloaded on current folder
$myTask->download('path/to/download');