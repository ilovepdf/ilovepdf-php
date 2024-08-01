<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Lib\SignExtraUploadParams;
use Ilovepdf\SignTask;
$signTask = new SignTask("public_key", "secret_key");
// We first upload the files that we are going to use
$uploadParams = (new SignExtraUploadParams())->setPdfInfo(true);
$file = $signTask->addFile('/path/to/file/document.pdf',$uploadParams);
var_dump($file->pdf_page_number); # Gets the amount of pages of that document
var_dump($file->getSanitizedPdfPages()); #Gets 
$pages = $file->getSanitizedPdfPages();