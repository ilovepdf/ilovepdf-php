<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\StartException;

/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class Task extends Ilovepdf
{
    // @var string The Ilovepdf API Task ID.
    public $task = null;
    //private $server = null;
    public $files = array();
    public $tool;
    public $packaged_filename;
    public $output_filename;
    public $ignore_errors = true;
    public $ignore_password = true;

    const STATUS_WAITING = 'TaskWaiting';
    const STATUS_PROCESSING = 'TaskProcessing';
    const STATUS_SUCCESS = 'TaskSuccess';
    const STATUS_SUCCESSWITHWARNINGS = 'TaskSuccessWithWarnings';
    const STATUS_ERROR = 'TaskError';
    const STATUS_DELETED = 'TaskDeleted';
    const STATUS_NOTFOUND = 'TaskNotFound';


    /**
     * Task constructor.
     * @param null $publicKey
     * @param null $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        parent::__construct($publicKey, $secretKey);

        $response = parent::sendRequest('get', 'start/' . $this->tool, null);
        if (empty($response->body->server)) {
            var_dump($response);
            throw new StartException('no server assigned on start');
        };
        $this->setWorkerServer('https://' . $response->body->server);
        $this->setTask($response->body->task);
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getFilesArray()
    {
        foreach ($this->files as $file) {
            $filesArray[] = $file->getFileOptions();
        }
        return $filesArray;
    }

    public function getStatus()
    {
        $response = Request::get('https://api.ilovepdf.com/v1/task/' . $this->task, array(
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . self::getJWT()
        ));
        return $response->body->status;
    }

    /**
     * @param string $filePath
     * @return File
     */
    public function addFile($filePath)
    {
        $file = $this->uploadFile($this->task, $filePath);
        array_push($this->files, $file);
        return end($this->files);
    }

    /**
     * @param string $url
     * @return File
     */
    public function addFileFromUrl($url)
    {
        $file = $this->uploadUrl($this->task, $url);
        array_push($this->files, $file);
        return end($this->files);
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

        $response = $this->sendRequest('post', 'upload', $body);
        return new File($response->body->server_filename, basename($filepath));
    }

    /**
     * @param string $task
     * @param string $url
     *
     * @return File
     *
     * @throws Exceptions\AuthException
     * @throws Exceptions\ProcessException
     * @throws UploadException
     */
    public function uploadUrl($task, $url)
    {
        $data = array('task' => $task, 'cloud_file' => $url);
        $body = Request\Body::Form($data);
        $response = parent::sendRequest('post', 'upload', $body);
        return new File($response->body->server_filename, basename($url));
    }

    /**
     * @param null|string $path
     * @param null|string $file
     */
    public function download($path = null, $file = null)
    {
        //$download = new Download();
        $this->downloadFile($this->task, $path, $file);
        return;
    }

    /**
     * @param string $task
     * @param string $path
     *
     * @throws Exceptions\AuthException
     * @throws Exceptions\ProcessException
     * @throws Exceptions\UploadException
     */
    public function downloadFile($task, $path = null)
    {
        $response = parent::sendRequest('get', 'download/' . $task, null);
        preg_match('/ .*filename=\"([\W\w]+)\"/', $response->headers['Content-Disposition'], $matches);

        $filename = str_replace('"', '', $matches[1]);
        if (is_null($path)) $path = '.';
        $destination = $path . '/' . $filename;
        $file = fopen($destination, "w+");
        fputs($file, $response->raw_body);
        fclose($file);
    }

    /**
     * @param $value
     */
    public function sendEncryptedFiles($value)
    {
        self::$encrypted = $value;
    }

    /**
     * @param $value
     * @return bool
     */
    public function getEncrypted($value)
    {
        return self::$encrypted;
    }


    /**
     * @return mixed
     * @throws Exceptions\AuthException
     * @throws Exceptions\ProcessException
     * @throws Exceptions\UploadException
     */
    public function execute()
    {
        $data = array_merge(
            get_object_vars($this),
            array('task' => $this->task, 'files' => $this->files));
        $body = Request\Body::multipart($data);
        $response = parent::sendRequest('post', 'process', urldecode(http_build_query($body)));
        return $response->body;
    }


    /**
     * @param string $filename Set filename for downloaded zip file
     */
    public function setPackagedFilename($filename)
    {
        $this->packaged_filename = $filename;
    }

    /**
     * @param string $filename Set filename for individual file/s
     */
    public function setOutputFilename($filename)
    {
        $this->output_filename = $filename;
    }

    /**
     * @param boolean $value If true, and multiple archives are processed it will ignore files with errors and continue process for all others
     */
    public function ignoreErrors($value)
    {
        $this->ignore_errors = $value;
    }

    /**
     * @param boolean $value
     */
    public function ignorePassword($value)
    {
        $this->ignore_password = $value;
    }
}
