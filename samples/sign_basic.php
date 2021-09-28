<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\SignTask;
use Ilovepdf\Sign\Receivers\Signer;
use Ilovepdf\Sign\SignatureFile;
use Ilovepdf\Sign\Elements\ElementSignature;
$signTask = new SignTask("project_public_key",
                            "private_secret_key");

// We first upload the file that we are going to use
$file = $signTask->addFile('/path/to/file');


// Add signers and their elements;
$signer = new Signer("name","signeremail@email.com");
$signatureFile = new SignatureFile($file);

$signatureElement = new ElementSignature();
$signatureElement->setPosition("20 -20");
$signatureFile->addElement($signatureElement);


$signer->addFile($signatureFile);

$signTask->addReceiver($signer);
$signature = $signTask->execute()->result;