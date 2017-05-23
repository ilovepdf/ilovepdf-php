<?php
//include the autoloader
require_once('../vendor/autoload.php');

use Ilovepdf\PdfaTask;


//you can call task class directly
$myTask = new PdfaTask("PUBLIC_KEY", "SECRET_KEY");

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/document.pdf');

// we can set conformance level
$file->setConformance('pdfa-2a');

// and set if we allow a downgrade if your conformance level fails
$myTask->setAllowDowngrade(false);

// and set name for output file.
// the task will set the correct file extension for you.
$myTask->setOutputFilename('pdfa');

// process files
$myTask->execute();

// and finally download file. If no path is set, it will be downloaded on current folder
$myTask->download('path/to/download');