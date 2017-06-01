<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\ValidatepdfaTask;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$myTask = new ValidatepdfaTask('project_public_id','project_secret_key');

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