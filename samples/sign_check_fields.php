<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\SignatureRequest;

$signatureRequest = new SignatureRequest("publickey","secretkey");
$token_requester = "tokenrequester";
$signer_shared_token = "signersharedtoken";

// Get the list of the signatures
$signatureRequest->getSignaturesList();

// Get the first page, with max amount per page of 50 (default is 20, max is 100).
$signatureRequest->getSignaturesList(0,50);

// Get the information about the signature:
$signatureRequest->getSignature($token_requester);

// Get the information about an specific signer:
$signatureRequest->getSignerInfo($signer_shared_token);

// Save audit file on the filesystem
$signatureRequest->getSignatureAuditFile($token_requester,"./","audit3");
// Save the original file on the filesystem:
$signatureRequest->getSignatureOriginalFile($token_requester,"./","original3");

// Save the original file on the filesystem:
$signatureRequest->getSignatureSignedFile($token_requester,"./","signed4"); 