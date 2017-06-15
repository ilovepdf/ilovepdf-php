<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Ilovepdf;
use Ilovepdf\SplitTask;

// start the manager classy
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$ilovepdf = new Ilovepdf('project_public_id','project_secret_key');

// and get the task tool
$myTask = $ilovepdf->newTask('split');

// or you can call task class directly, this set the same tool as before
$myTask = new SplitTask('project_public_id','project_secret_key');


// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/document.pdf');

// set ranges to split the document
$myTask->setRanges("2-4,6-8");

// set we want splitted files to be merged in new one
$myTask->setMergeAfter(true);

// and name for merged document
$myTask->setOutputFilename('split');

// process files
$myTask->execute();

// and finally download file. If no path is set, it will be downloaded on current folder
$myTask->download('path/to/download');