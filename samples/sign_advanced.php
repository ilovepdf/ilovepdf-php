<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\SignTask;

use Ilovepdf\Sign\SignatureFile;
use Ilovepdf\Sign\Elements\ElementSignature;
use Ilovepdf\Sign\Elements\ElementDate;
use Ilovepdf\Sign\Elements\ElementInitials;
use Ilovepdf\Sign\Elements\ElementInput;
use Ilovepdf\Sign\Elements\ElementName;
use Ilovepdf\Sign\Elements\ElementText;
use Ilovepdf\Sign\Receivers\Signer;
use Ilovepdf\Sign\Receivers\Validator;
use Ilovepdf\Sign\Receivers\Witness;

$signTask = new SignTask("public_key",
                            "secret_key");

// We first upload the file that we are going to use
$file = $signTask->addFile('/path/to/file/document.pdf');


// Add signers and their elements;
$signer = new Signer("Signer","signer@email.com");
$elements = [];

$signatureElement = new ElementSignature();
$signatureElement->setPosition("20 -20");
//we can define the pages with a comma
$signatureElement->setPages("1,2");
$elements[]= $signatureElement;

// Now add a date element to that signer
$dateElement = new ElementDate();
$dateElement->setPosition("30 -30");
//ranges can also be defined this way
$dateElement->setPages("1-2");
$elements[]= $dateElement;

$initialsElement = new ElementInitials();
$initialsElement->setPosition("40 -40");
//You can define multiple ranges
$initialsElement->setPages("1,2,3-6");
$elements[]= $initialsElement;



$inputElement = new ElementInput();
$inputElement->setPosition("50 -50");
$inputElement->setLabel("Passport Number");
$inputElement->setDescription("Please put your passport number");
$elements[]= $inputElement;


// If not specified, the default page is 1.
$nameElement = new ElementName();
$nameElement->setPosition("60 -60");
$elements[]= $nameElement;

$textElement = new ElementText();
$textElement->setPosition("70 -70");
$textElement->setText("This is a text field");
$elements[]= $textElement;

$signatureFile = new SignatureFile($file,$elements);

$validator = new Validator("Validator","validator@email.com");

$signer->addFile($signatureFile);
$signTask->addReceiver($signer);

$signatureFile2 = new SignatureFile($file);
$validator->addFile($signatureFile2);
$signTask->addReceiver($validator);

$witness = new Witness("Witness","witness@emamil.com");
$signatureFile3 = new SignatureFile($file);
$witness->addFile($signatureFile3);
$signTask->addReceiver($witness);

$signature = $signTask->execute()->result;