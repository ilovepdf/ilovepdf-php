<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\SignTask;

use Ilovepdf\Sign\Elements\ElementSignature;
use Ilovepdf\Sign\Elements\ElementDate;
use Ilovepdf\Sign\Elements\ElementInitials;
use Ilovepdf\Sign\Elements\ElementInput;
use Ilovepdf\Sign\Elements\ElementName;
use Ilovepdf\Sign\Elements\ElementText;
use Ilovepdf\Sign\Receivers\Signer;
use Ilovepdf\Sign\Receivers\Validator;
use Ilovepdf\Sign\Receivers\Witness;

$signTask = new SignTask("public_key", "secret_key");

// Set the Signature settings
$emailSubject = "My subject";
$emailBody = "Body of the first message";

$reminderDays = 3;
$daysUntilSignatureExpires = 130;
$taskLanguage = "en-US";

$signTask = $signTask->
                setVerifySignatureVerification(true)->
                setSubject($emailSubject)->
                setMessage($emailBody)->
                setReminders($reminderDays)->
                setLockOrder(false)->
                setExpirationDays($daysUntilSignatureExpires)->
                setLanguage($taskLanguage)->
                setUuidVisible(true);

// We first upload the files that we are going to use
$file = $signTask->addFile('/path/to/file/document.pdf');

// Set brand
$brandLogo = $signTask->addFile('/path/to/file/brand_logo.png');
$signTask->setBrand('My brand name', $brandLogo);

//////////////
// ELEMENTS //
//////////////
// Let's define the elements to be placed in the documents
$elements = [];

$signatureElement = new ElementSignature();
$signatureElement->setPosition(20, -20);
//we can define the pages with a comma
$signatureElement->setPages("1,2");
$elements[]= $signatureElement;

// Now add a date element to that signer
$dateElement = new ElementDate();
$dateElement->setPosition(30, -30);
//ranges can also be defined this way
$dateElement->setPages("1-2");
$elements[]= $dateElement;

$initialsElement = new ElementInitials();
$initialsElement->setPosition(40, -40);
//You can define multiple ranges
$initialsElement->setPages("1,2,3-6");
$elements[]= $initialsElement;

$inputElement = new ElementInput();
$inputElement->setPosition(50, -50);
$inputElement->setLabel("Passport Number");
$inputElement->setText("Please put your passport number");
$elements[]= $inputElement;

// If not specified, the default page is 1.
$nameElement = new ElementName();
$nameElement->setPosition(60, -60);
$elements[]= $nameElement;

$textElement = new ElementText();
$textElement->setPosition(70, -70);
$textElement->setText("This is a text field");
$elements[]= $textElement;

///////////////
// RECEIVERS //
///////////////
// Create the receivers
$signer = new Signer("Signer","signer@email.com");
$validator = new Validator("Validator","validator@email.com");
$witness = new Witness("Witness","witness@email.com");

// Add elements to the receivers that need it
$signer->addElements($file, $elements);

// Add all receivers to the Sign task
$signTask->addReceiver($validator);
$signTask->addReceiver($signer);
$signTask->addReceiver($witness);

// Lastly send the signature request
$signature = $signTask->execute()->result;