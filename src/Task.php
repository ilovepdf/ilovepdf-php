<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\StartException;
use Ilovepdf\Request\Body;

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
    public $files = [];
    public $tool;
    public $packaged_filename;
    public $output_filename;
    public $ignore_errors = true;
    public $ignore_password = true;
    public $try_pdf_repair = true;
    public $meta = [];

    /**
     * Task constructor.
     * @param null $publicKey
     * @param null $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        parent::__construct($publicKey, $secretKey);
        $data = array('v'=> self::VERSION);
        $body = Body::Form($data);
        $response = parent::sendRequest('get', 'start/' . $this->tool, $body);
        if (empty($response->body->server)) {
            throw new StartException('no server assigned on start');
        };
        $this->setWorkerServer('https://' . $response->body->server);
        $this->setTask($response->body->task);
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getTaskId()
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

    public function getStatus($server=null, $taskId=null)
    {
        if($server!=null && $taskId!=null){
            return parent::getStatus(server, $taskId);
        }
        return parent::getStatus($this->getWorkerServer(), $this->getTaskId());
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
        $data = array('task' => $task, 'v'=> self::VERSION);
        $files = array('file' => $filepath);
        $body = Request\Body::multipart($data, $files);

        $response = $this->sendRequest('post', 'upload', $body);
        return new File($response->body->server_filename, basename($filepath));
    }

    /**
     * @return Task
     */
    public function delete()
    {
        $response = $this->sendRequest('delete', 'task/'.$this->getTaskId());
        return $this;
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
        $data = array('task' => $task, 'cloud_file' => $url, 'v'=> self::VERSION);
        $body = Request\Body::Form($data);
        $response = parent::sendRequest('post', 'upload', $body);
        return new File($response->body->server_filename, basename($url));
    }

    /**
     * @param null|string $path
     * @param null|string $file
     */
    public function download($path = null)
    {
        //$download = new Download();
        $this->downloadFile($this->task, $path);
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
        $data = array('v'=> self::VERSION);
        $body = Request\Body::Form($data);
        $response = parent::sendRequest('get', 'download/' . $task, $body);

        if(preg_match("/filename\*\=utf-8\'\'([\W\w]+)/", $response->headers['Content-Disposition'], $matchesUtf)){
            $filename = urldecode(str_replace('"', '', $matchesUtf[1]));
        }
        else {
            preg_match('/ .*filename=\"([\W\w]+)\"/', $response->headers['Content-Disposition'], $matches);
            $filename = str_replace('"', '', $matches[1]);
        }
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
        if($this->task===null){
            throw new \Exception('Current task not exists');
        }

        $data = array_merge(
            get_object_vars($this),
            array('task' => $this->task, 'files' => $this->files, 'v'=> self::VERSION));
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

    public function deleteFile($file){
        if (($key = array_search($file, $this->files)) !== false) {
            $body = Request\Body::multipart(['task'=>$this->getTaskId(), 'server_filename'=>$file->server_filename, 'v'=> self::VERSION]);
            $this->sendRequest('post', 'upload/delete', $body);
            unset($this->files[$key]);
        }
    }

    /**
     * @param mixed $value
     * @param array $allowed
     */
    public function checkValues($value, $allowedValues){
        if(!in_array($value, $allowedValues)){
            throw new \InvalidArgumentException('Invalid '.$this->tool.' value "'.$value.'". Must be one of: '.implode(',', $allowedValues));
        }
    }

    /**
     * @param boolean $try_pdf_repair
     */
    public function setTryPdfRepair($try_pdf_repair)
    {
        $this->try_pdf_repair = $try_pdf_repair;
    }

    /**
     * @param boolean $ignore_errors
     */
    public function setIgnoreErrors($ignore_errors)
    {
        $this->ignore_errors = $ignore_errors;
    }

    /**
     *
     *
     * @param boolean $ignore_password
     */
    public function setIgnorePassword($ignore_password)
    {
        $this->ignore_password = $ignore_password;
    }


    /**
     * alias for setIgnoreError
     *
     * Will be deprecated on v2.0
     *
     * @param boolean $value If true, and multiple archives are processed it will ignore files with errors and continue process for all others
     */
    public function ignoreErrors($value)
    {
        $this->ignore_errors = $value;
    }

    /**
     * alias for setIgnorePassword
     *
     * Will be deprecated on v2.0
     *
     * @param boolean $value
     */
    public function ignorePassword($value)
    {
        $this->ignore_password = $value;
    }

    /**
     * @param boolean $value
     */
    public function setFileEncryption($value, $encryptKey=null)
    {
        if(count($this->files)>0){
            throw new \Exception('Encrypth mode cannot be set after file upload');
        }

        parent::setFileEncryption($value, $encryptKey);
    }

    /**
     * @param $key
     * @param $value
     *
     * set meta values as http://www.adobe.com/content/dam/Adobe/en/devnet/acrobat/pdfs/pdf_reference_1-7.pdf (page 844)
     */
    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }
}
