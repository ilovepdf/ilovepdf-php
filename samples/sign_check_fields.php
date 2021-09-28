<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\SignatureRequest;

$signatureRequest = new SignatureRequest("public_key","protected_key");
$token_requester = "tokenrequester";
$signer_token = "signertoken";

// Get the list of the signatures
$signatureRequest->getSignaturesList();

// Get the first page, with max amount per page of 50 (default is 20, max is 100).
$signatureRequest->getSignaturesList(0,50);

// Get the information about the signature:
$signatureRequest->getSignature($token_requester);

// Get the information about an specific signer:
$signatureRequest->getSignerInfo($signer_token);

// Save audit file on the filesystem
$signatureRequest->getSignatureAuditFile($token_requester,"/path/to/save/file");
// Save the original file on the filesystem:
$signatureRequest->getSignatureOriginalFile($token_requester,"/path/to/save/file");

// Save the original file on the filesystem:
$signatureRequest->getSignatureSignedFile($token_requester,"/path/to/save/file");
