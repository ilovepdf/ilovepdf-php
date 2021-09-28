<?php

namespace Ilovepdf;
use Ilovepdf\Request\Body;
use Ilovepdf\Request\Request;
use Ilovepdf\Request\Response;
use stdClass;

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

    public function getSignatureAuditFile(string $signatureId, string $pathToSave): bool{
        $response = parent::sendRequest("get","signatures/{$signatureId}/download-audit");
        return file_put_contents($pathToSave,$response->raw_body);
    }

    public function getSignatureOriginalFile(string $signatureId, string $pathToSave): bool{
        $response = parent::sendRequest("get","signatures/{$signatureId}/download-original");
        return file_put_contents($pathToSave,$response->raw_body);
    }

    public function getSignatureSignedFile(string $signatureId, string $pathToSave): bool{
        $response = parent::sendRequest("get","signatures/{$signatureId}/download-signed");
        return file_put_contents($pathToSave,$response->raw_body);
    }

    public function getSignerInfo(string $signerId): bool{
        return parent::sendRequest("get","signature/signerview/{$signerId}")->body;
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
}