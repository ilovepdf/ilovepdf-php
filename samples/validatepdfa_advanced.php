<?php
//include the autoloader
require_once('../vendor/autoload.php');

use Ilovepdf\ValidatepdfaTask;


//you can call task class directly
$myTask = new ValidatepdfaTask("PUBLIC_KEY", "SECRET_KEY");

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/document.pdf');

// we can set conformance level to validate
$file->setConformance('pdfa-2a');

// process files
$myTask->execute();

foreach($myTask->result->validations as $file){
    var_dump($file);
}