<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\WatermarkTask;


// you can call task class directly
// to get your key pair, please visit https://developer.ilovepdf.com/user/projects
$myTask = new WatermarkTask('project_public_id','project_secret_key');

// file var keeps info about server file id, name...
// it can be used latter to cancel file
$file = $myTask->addFile('/path/to/file/document.pdf');

// set mode to text
$myTask->setMode("text");

// set the text
$myTask->setText("watermark text");

// set pages to apply the watermark
$myTask->setPages("1-5,7");

// set vertical position
$myTask->setVerticalPosition("top");

// set horizontal position
$myTask->setHorizontalPosition("right");

// adjust vertical position
$myTask->setVerticalPositionAdjustment("100");

// adjust horizontal position
$myTask->setHorizontalPositionAdjustment("100");

// set mode to text
$myTask->setFontFamily("Arial");

// set mode to text
$myTask->setFontStyle("Italic");

// set the font size
$myTask->setFontSize("12");

// set color to red
$myTask->setFontColor("#ff0000");

// set transparency
$myTask->setTransparency("50");

// set the layer
$myTask->setLayer("below");

// and set name for output file.
// the task will set the correct file extension for you.
$myTask->setOutputFilename('watermarked');

// process files
$myTask->execute();

// and finally download the unlocked file. If no path is set, it will be downloaded on current folder
$myTask->download('path/to/download');