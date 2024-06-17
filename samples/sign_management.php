<?php
//include the autoloader
require_once('../vendor/autoload.php');
//if manual installation has been used comment line that requires the autoload and uncomment this line:
//require_once('../init.php');

use Ilovepdf\SignatureManagement;

$signatureRequest = new SignatureManagement("publickey", "secretkey");
$signatureToken = "token_requester";
$receiverToken = "receivertoken";

// Get a list of all created signature requests
$signatureRequest->getSignaturesList();

// Get the first page, with max number of 50 entries per page (default is 20, max is 100).
$signatureRequest->getSignaturesList(0, 50);

// Get the current status of the signature:
$signatureRequest->getSignatureStatus($signatureToken);

// Get information about a specific receiver:
$signatureRequest->getReceiverInfo($receiverToken);

// Download the audit file on the filesystem
$signatureRequest->downloadAuditFile($signatureToken, "./", "audit3");

// Download the original files on the filesystem:
$signatureRequest->downloadOriginalFiles($signatureToken, "./", "original3");

// Download the created signed files on the filesystem:
$signatureRequest->downloadSignedFiles($signatureToken, "./", "signed4");

// Correct the email address of a receiver in the event that the email was delivered to an invalid email address
$signatureRequest->fixReceiverEmail($receiverToken, "newemail@email.com");

// Correct the mobile number of a signer in the event that the SMS was delivered to an invalid mobile number
$signatureRequest->fixSignerPhone($receiverToken, "34666666666");

// This endpoint sends an email reminder to pending receivers. It has a daily limit quota (check the docs to know the daily quota)
$signatureRequest->sendReminders($signatureToken);

// Increase the number of days to '4' in order to prevent the request from expiring and give receivers extra time to perform remaining actions.
$signatureRequest->increaseExpirationDays($signatureToken, 4);

// Void a signature that is currently in progress
$signatureRequest->voidSignature($signatureToken);
