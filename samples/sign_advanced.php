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
$brandLogoFile = $signTask->uploadBrandLogo('/path/to/file/image.png');
# Additionaly we can download it from the cloud
#$brandLogoFile = $signTask->uploadBrandLogo('https://urltoimage/image.png');
$signTask->setBrand('My brand name', $brandLogoFile);

//////////////
// ELEMENTS //
//////////////
// Let's define the elements to be placed in the documents
$elements = [];

# Gravity positioning
# Xvalues: ['left','center','right']
# YValues: ['top','middle','bottom']
# horizontal_position_adjustment: integer
# vertical_position_adjustment: integer
$signatureElement = new ElementSignature();
$signatureElement->setGravityPosition("left", "top",3,-2) 
                 ->setPages("1,2"); //we can define the pages with a comma

$dateElement = new ElementDate();
$dateElement->setPosition(30, -30)
            ->setPages("1-2"); // ranges can also be defined this way

$initialsElement = new ElementInitials();
$initialsElement->setPosition(40, -40)
                ->setPages("1,2,3-6"); // You can define multiple ranges

$inputElement = new ElementInput();
$inputElement->setPosition(50, -50)
             ->setLabel("Passport Number")
             ->setText("Please put your passport number")
             ->setPages("-2,-1"); // Set the last and second to last page

$nameElement = new ElementName();
$nameElement->setPosition(60, -60)
            ->setSize(40)
            ->setPages("1");

$textElement = new ElementText();
$textElement->setPosition(70, -70)
            ->setText("This is a text field")
            ->setSize(40)
            ->setPages("1");

// Add Elements
$elements[]= $signatureElement;
$elements[]= $dateElement;
$elements[]= $initialsElement;
$elements[]= $inputElement;
$elements[]= $nameElement;
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
var_dump($signature);