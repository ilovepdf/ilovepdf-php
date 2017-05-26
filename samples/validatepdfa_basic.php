<?php
//include the autoloader
require_once('../vendor/autoload.php');

use Ilovepdf\ValidatepdfaTask;


//you can call task class directly
$myTask = new ValidatepdfaTask("PUBLIC_KEY", "SECRET_KEY");

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/document.pdf');

// process files
$result = $myTask->execute();

foreach($result->validations as $file){
    var_dump($file);
}