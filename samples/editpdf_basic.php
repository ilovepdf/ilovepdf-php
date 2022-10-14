<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\EditpdfTask;
use Ilovepdf\Editpdf\ImageElement;

// This is a sample for an Editpdf task.

// you can call task class directly
// to get your key pair, please visit https://developer.iloveimg.com/user/projects
$editpdfTask = new EditpdfTask('project_public_id', 'project_secret_key');
// Upload PDF file to Ilovepdf servers
$pdfFile = $editpdfTask->addFile('your_file.pdf');

// Upload Image file to Ilovepdf servers
$imageFile = $editpdfTask->addFile('your_image.jpg');

// Create ImageElement
$imageElem = new ImageElement();
$imageElem->setFile($imageFile);

// Add image element to Editpdf task
$editpdfTask->addElement($imageElem);

$editpdfTask->setOutputFilename('editpdf-basic');
$editpdfTask->execute();
$editpdfTask->download('downloads');
