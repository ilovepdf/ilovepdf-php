<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\SignTask;
use Ilovepdf\Sign\Receivers\Signer;
use Ilovepdf\Sign\SignatureFile;
use Ilovepdf\Sign\Elements\ElementSignature;
$signTask = new SignTask("project_public_6d8160ca929409eab330cd6cf7b1164a_UuLiW383045d01ef1df3767a325d46fb7bf30",
                            "secret_key_6aa1ba9745e41682940f50b86d7055b5_LOxoeb15108b113f609967c7b89fa9f09c621");

// We first upload the file that we are going to use
$file = $signTask->addFile('./sample.pdf');


// Add signers and their elements;
$signer = new Signer("Guillem","guillem.vidal+1@iloveimg.com");
$signatureFile = new SignatureFile($file);

$signatureElement = new ElementSignature();
$signatureElement->setPosition("20 -20");
$signatureFile->addElement($signatureElement);


$signer->addFile($signatureFile);

$signTask->addReceiver($signer);
$signature = $signTask->execute()->result;