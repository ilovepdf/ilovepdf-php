<?php

namespace Ilovepdf;

/**
 * Class Ilovepdf
 *
 * @todo Add params as needed, because we don't want this class extends Task. Currently not used
 *
 * @package Ilovepdf
 */
use Ilovepdf\Exceptions\UploadException;

class Upload extends Task
{

    /**
     * Upload constructor.
     * @param string $tool The Ilovepdf public API key to be used for requests.
     */
    function __construct($publicKey, $private)
    {
        return true;
    }


    /**
     * @param string $task
     * @param string $filepath
     *
     * @return File
     *
     * @throws Exceptions\AuthException
     * @throws Exceptions\ProcessException
     * @throws UploadException
     */
    public function uploadFile($task, $filepath)
    {
        $data = array('task' => $task);
        $files = array('file' => $filepath);
        $body = Request\Body::multipart($data, $files);
        $response = parent::sendRequest('post', 'upload', $body);
        return new File($response->body->server_filename, basename($filepath));
    }


}
