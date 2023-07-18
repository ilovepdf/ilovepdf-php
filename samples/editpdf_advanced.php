<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\EditpdfTask;
use Ilovepdf\Editpdf\ImageElement;
use Ilovepdf\Editpdf\TextElement;
use Ilovepdf\Editpdf\SvgElement;

// This is a sample for an Editpdf task.

// you can call task class directly
// to get your key pair, please visit https://developer.iloveimg.com/user/projects
$editpdfTask = new EditpdfTask('project_public_id', 'project_secret_key');
// Upload PDF file to Ilovepdf servers
$pdfFile = $editpdfTask->addFile('your_file.pdf');

// Upload Image file to Ilovepdf servers
$imageFile = $editpdfTask->addFile('your_image.jpg');
$svgFile = $editpdfTask->addFile('your_svg.svg');

// Create ImageElement
$imageElement = new ImageElement();
$imageElement->setCoordinates(300, 600)
          ->setPages(3)
          ->setOpacity(40)
          ->setFile($imageFile);

// Create TextElement
$textElement = new TextElement();
$textElement->setText("This is a sample text")
            ->setCoordinates(300, 600)
            ->setPages(2)
            ->setTextAlign("center")
            ->setFontFamily("Times New Roman")
            ->setFontColor("#FB8B24") // Orange
            ->setBold();

// Create SvgElement
$svgElement = new SvgElement();
$svgElement->setFile($svgFile);

// Add elements to Editpdf task in order of drawing (important if elements overlap!)
$editpdfTask->addElement($imageElement);
$editpdfTask->addElement($textElement);
$editpdfTask->addElement($svgElement);

foreach($editpdfTask->getElements() as $editpdfElement){
  $isElemValid = $editpdfElement->validate();

  if(!$isElemValid){
    $validationErrors = $editpdfElement->getErrors();
    
    // Output what went wrong
    echo "{$editpdfElement->getType()} element has errors:\n";
    var_dump($validationErrors);
    exit(1);
  }
}

$editpdfTask->setOutputFilename('editpdf-advanced');
$editpdfTask->execute();
$editpdfTask->download('downloads');
