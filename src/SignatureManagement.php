<?php

namespace Ilovepdf;

use Psr\Http\Message\ResponseInterface;
use stdClass;
use Ilovepdf\Exceptions\DownloadException;

/**
 * Class SignatureManagement
 *
 * @package Ilovepdf
 */
class SignatureManagement extends Ilovepdf
{

    /**
     * @param int $page
     * @param int $per_page
     * 
     * @return array
     * @throws \Exception
     */
    public function getSignaturesList($page = 0, $per_page = 20): array
    {
        $data = [
            "page" => $page,
            "per-page" => $per_page
        ];
        $response = parent::sendRequest("get", "signature/list", $data);
        $headers = $response->getHeaders();
        return [
            "signatures" => $response->getBody()->getContents(),
            "pagination" => [
                'totalCount' => $headers && isset($headers['X-Pagination-Total-Count']) ? $headers['X-Pagination-Total-Count'] : '',
                'page' => $headers && isset($headers['X-Pagination-Current-Page']) ? (int)$headers['X-Pagination-Current-Page'] - 1 : '',
                'pageSize' => $headers && isset($headers['X-Pagination-Per-Page']) ? $headers['X-Pagination-Per-Page'] : ''
            ]
        ];
    }

    /**
     * @param string $signatureId
     * 
     * @return stdClass
     * @throws \Exception
     */
    public function getSignatureStatus(string $signatureId): stdClass
    {
        return json_decode(parent::sendRequest("get", "signature/requesterview/{$signatureId}")->getBody()->getContents());
    }

    /**
     * @param string $signatureId
     * @param string $pathToSave
     * @param string $filename
     * 
     * @return bool
     */
    public function downloadAuditFile(string $signatureId, string $pathToSave, string $filename): bool
    {
        $response = parent::sendRequest("get", "signature/{$signatureId}/download-audit");
        return $this->downloadResponseToFile($response, $pathToSave, $filename);
    }

    /**
     * @param string $signatureId
     * @param string $pathToSave
     * @param string $filename
     * 
     * @return string
     */
    public function downloadOriginalFiles(string $signatureId, string $pathToSave, string $filename): string
    {
        $response = parent::sendRequest("get", "signature/{$signatureId}/download-original");
        return $this->downloadResponseToFile($response, $pathToSave, $filename);
    }

    /**
     * @param string $signatureId
     * @param string $pathToSave
     * @param string $filename
     * 
     * @return string
     */
    public function downloadSignedFiles(string $signatureId, string $pathToSave, string $filename): string
    {
        $response = parent::sendRequest("get", "signature/{$signatureId}/download-signed");
        return $this->downloadResponseToFile($response, $pathToSave, $filename);
    }

    /**
     * @param string $receiverTokenRequester
     * @param string $newEmail
     * 
     * @return bool
     */
    public function fixReceiverEmail(string $receiverTokenRequester, string $newEmail): bool
    {
        $body = ['form_params' => [
            "email" => $newEmail
        ]];
        parent::sendRequest("put", "signature/signer/fix-email/{$receiverTokenRequester}", $body, false, true);
        //if above fails, it throws an exception
        return true;
    }

    /**
     * @param string $signerTokenRequester
     * @param string $newPhone
     * 
     * @return bool
     */
    public function fixSignerPhone(string $signerTokenRequester, string $newPhone): bool
    {
        $body = ['form_params' => [
            "phone" => $newPhone
        ]];
        $response = parent::sendRequest("put", "signature/signer/fix-phone/{$signerTokenRequester}", $body, false, true);
        //if above fails, it throws an exception
        return true;
    }

    /**
     * @param string $signatureId
     * 
     * @return bool
     */
    public function sendReminders(string $signatureId): bool
    {
        $body = [];
        parent::sendRequest("post", "signature/sendReminder/{$signatureId}", $body, false, true);
        //if above fails, it throws an exception
        return true;
    }

    /**
     * @param string $signatureId
     * 
     * @return bool
     * @throws \Exception
     */
    public function voidSignature(string $signatureId): bool
    {
        $body = [];
        parent::sendRequest("put", "signature/void/{$signatureId}", $body, false, true);
        //if above fails, it throws an exception
        return true;
    }

    /**
     * @param string $signatureId
     * @param int $amountOfDays
     * 
     * @return bool
     * @throws \Exception
     */
    public function increaseExpirationDays(string $signatureId, int $amountOfDays): bool
    {
        $body = [
            "days" => $amountOfDays
        ];
        parent::sendRequest("put", "signature/void/{$signatureId}", $body, false, true);
        //if above fails, it throws an exception
        return true;
    }

    /**
     * @param string $receiverTokenRequester
     * 
     * @return stdClass
     * @throws \Exception
     */
    public function getReceiverInfo(string $receiverTokenRequester): stdClass
    {
        return json_decode(parent::sendRequest("get", "signature/receiver/info/{$receiverTokenRequester}")->getBody()->getContents());
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
        throw new \Exception("This class is not meant to create a new task; but to manage an existing SignTask");
    }

    private function getExtensionFromMime(string $mime_type)
    {
        return explode("/", $mime_type)[1];
    }

    protected function downloadResponseToFile(ResponseInterface $response, string $pathToSave, string $filename): string
    {
        if (!is_dir($pathToSave)) {
            throw new \Exception("{$pathToSave} is not a directory");
        }
        $mime_type = $response->getHeaders()["Content-Type"];
        $filePath = "{$pathToSave}/{$filename}." . $this->getExtensionFromMime($mime_type[0]);
        $fileContent = $response->getBody()->getContents();
        if (!file_put_contents($filePath, $fileContent)) {
            throw new DownloadException("Download success, but could not save the contents of the file to {$filePath}. Check permissions of the directory", 1, null, $fileContent);
        }
        return $filePath;
    }
}
