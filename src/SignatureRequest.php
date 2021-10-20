<?php

namespace Ilovepdf;
use Ilovepdf\Request\Body;
use Ilovepdf\Request\Request;
use Ilovepdf\Request\Response;
use stdClass;
use Ilovepdf\Exceptions\DownloadException;

/**
 * Class SignatureRequest
 *
 * @package Ilovepdf
 */
class SignatureRequest extends Ilovepdf{
    
    public function getSignaturesList($page = 0,$per_page = 20): array{
        $data = [
            "page" => $page,
            "per-page" => $per_page
        ];
        $response = parent::sendRequest("get","signature/list",$data);
        $headers = $response->headers;
        $return = [
            "signatures" => $response->body,
            "pagination" => [
                'totalCount' => $headers && isset($headers['X-Pagination-Total-Count']) ? $headers['X-Pagination-Total-Count'] : '',
                'page' => $headers && isset($headers['X-Pagination-Current-Page']) ? $headers['X-Pagination-Current-Page'] - 1 : '',
                'pageSize' => $headers && isset($headers['X-Pagination-Per-Page']) ? $headers['X-Pagination-Per-Page'] : ''
            ]
        ];
        return $return;
    }

    public function getSignature(string $signatureId): stdClass{
        return parent::sendRequest("get","signature/requesterview/{$signatureId}")->body;
    }

    public function getSignatureAuditFile(string $signatureId, string $pathToSave,string $filename): bool{
        $response = parent::sendRequest("get","signature/{$signatureId}/download-audit");
        $this->downloadResponseToFile($response,$pathToSave,$filename);
        return $filePath;
    }

    public function getSignatureOriginalFile(string $signatureId, string $pathToSave,string $filename): string{
        $response = parent::sendRequest("get","signature/{$signatureId}/download-original");
        $this->downloadResponseToFile($response,$pathToSave,$filename);
        return $filePath;
    }

    public function getSignatureSignedFile(string $signatureId, string $pathToSave,string $filename): string{
        $response = parent::sendRequest("get","signature/{$signatureId}/download-signed");
        $this->downloadResponseToFile($response,$pathToSave,$filename);
        return $filePath;
    }

    public function fixSignerEmail(string $signerTokenRequester, string $newEmail): bool{
        $body = [
            "email" => $newEmail
        ];
        $response = parent::sendRequest("put","signature/signer/fix-email/{$signerTokenRequester}",$body,false,true);
        //if above fails, it throws an exception
        return true;
    }

    public function fixSignerPhone(string $signerTokenRequester, string $newPhone): bool{
        $body = [
            "phone" => $newPhone
        ];
        $response = parent::sendRequest("put","signature/signer/fix-email/{$signerTokenRequester}",$body,false,true);
        //if above fails, it throws an exception
        return true;
    }

    public function sendReminders(string $signerTokenRequester): bool{
        $body = [
        ];
        $response = parent::sendRequest("put","v1/signature/sendReminder/{$signerTokenRequester}",$body,false,true);
        //if above fails, it throws an exception
        return true;
    }

    public function getSignerInfo(string $signerTokenRequester): stdClass{
        return parent::sendRequest("get","signature/signer/info/{$signerTokenRequester}")->body;
    }

    /**
     * @param string $tool Api tool to use
     * @param bool $makeStart Set to false for chained tasks, because we don't need the start
     *
     * @return mixed Return implemented Task class for specified tool
     *
     * @throws \Exception
     */
    public function newTask($tool = '', $makeStart = true)
    {
        throw new \Exception("Method not valid");
    }

    private function getExtensionFromMime(string $mime_type){
        return explode("/",$mime_type)[1];
    }

    protected function downloadResponseToFile($response,string $pathToSave,string $filename): string{
        if(!is_dir($pathToSave)){
            throw new \Exception("{$pathToSave} is not a directory");
        }
        $mime_type = $response->headers["Content-Type"];
        $filePath = "{$pathToSave}/{$filename}.".$this->getExtensionFromMime($mime_type);
        if(!file_put_contents($filePath,$response->raw_body)){
            throw new DownloadException("Download success, but could not save the contents of the file to {$filePath}. Check permissions of the directory", 1, null, $response);
        }
        return $filePath;
    }
}