<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\Lib\SignExtraUploadParams;
use Ilovepdf\SignTask;
use Ilovepdf\Sign\Elements\ElementInput;
use Ilovepdf\Sign\Elements\ElementSignature;
use Ilovepdf\Sign\Elements\ElementText;
use Ilovepdf\Sign\Receivers\Signer;

$signTask = new SignTask("public_key", "secret_key");
// We first upload the files that we are going to use
$uploadParams = (new SignExtraUploadParams())->setPdfInfo(true)->setPdfForms(true);
$file = $signTask->addFile('/path/to/file/document.pdf',$uploadParams);
var_dump($file->pdf_page_number); # Gets the amount of pages of that document 
# Gets an array of the sizes of each page
# Each row is an array with the keys "width" and "height". For instance:
# ["width" => 234.54,"height" => 555.56];
var_dump($file->getSanitizedPdfPages());
$elements = [];
# How to use pdf forms information
$file->eachPdfFormElement(function($formElement, $pdfPageInfo){
    $typeOfField = $formElement["typeOfField"];
    if(!in_array($typeOfField,['textbox','signature'])){
        return;
    }
    $fieldId = $formElement['fieldId'];
    $widgets = $formElement["widgetsInformation"]; 
    $position = $widgets[0];
    $currentPage = $position['page'];
    
    $leftPos = $position['left'];
    $topPosition = $position['top'] - $pdfPageInfo['height'];
    $size = floor($position['left'] - $position['bottom']);
    # This is an array of the position of each related elements, specially useful when dealing with 
    

    if($typeOfField === 'textbox'){
        if($formElement["multilineFlag"] === true || $formElement['passwordFlag'] === true){
            return;
        }
        $textValue = $formElement["textValue"];
        # For instance, we want to create an input element if the label of the form contains the word "Input".
        if(str_contains($fieldId, '_input')){
            $inputElement = new ElementInput();
            $inputElement->setPosition($leftPos,$topPosition)
                        ->setSize($size)
                        ->setLabel($textValue)
                        ->setPages(strval($currentPage));
            $elements[]=$inputElement;
        }else{
            $textElement = new ElementText();
            $textElement->setPosition($leftPos,$topPosition)
                        ->setSize($size)
                        ->setText($textValue)
                        ->setPages(strval($currentPage));
            $elements[]=$textElement;
        }
    }elseif($typeOfField === 'signature'){
        $signatureElement = new ElementSignature();
        $signatureElement->setPosition($leftPos,$topPosition)
                        ->setSize($size);
        $elements[]=$signatureElement;
    }
});

$signer = new Signer("Signer","signer@email.com");

// Add elements to the receivers that need it
$signer->addElements($file, $elements);
// Lastly send the signature request
$signature = $signTask->execute()->result;
var_dump($signature);

