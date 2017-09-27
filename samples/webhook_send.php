<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\CompressTask;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$myTask = new CompressTask('project_public_id','project_secret_key');

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/document.pdf');

//set the webhook that will recibe the notification once file is ready to download
$myTask->setWebhook('http://your_url.com');


// We don't download here because with the webhook we ordered the files must be processed in background.
// Notification will be sent once it's ready
