<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\AuthException;
use Ilovepdf\Exceptions\DownloadException;
use Ilovepdf\Exceptions\ProcessException;
use Ilovepdf\Exceptions\StartException;
use Ilovepdf\Exceptions\PathException;
use Ilovepdf\Exceptions\UploadException;
use Ilovepdf\Lib\BaseExtraUploadParams;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class Task extends Ilovepdf
{
    /**
     * @var string|null  The Ilovepdf API Task ID.
     */
    public $task = null;

    /**
     * @var array
     */
    public $files = [];

    /**
     * @var string|null
     */
    public $tool;

    /**
     * @var string|null
     */
    public $packaged_filename;

    /**
     * @var string|null
     */
    public $output_filename;

    /**
     * @var bool
     */
    public $ignore_errors = true;

    /**
     * @var bool
     */
    public $ignore_password = true;

    /**
     * @var bool
     */
    public $try_pdf_repair = true;

    /**
     * @var array
     */
    public $meta = [];

    /**
     * @var string|null
     */
    public $webhook;

    //custom data

    /**
     * @var int|null
     */
    public $custom_int = null;

    /**
     * @var string|null
     */
    public $custom_string = null;

    /**
     * @var string[]
     */
    private $statusValues = [
        '',
        'TaskSuccess',
        'TaskDeleted',
        'TaskWaiting',
        'TaskProcessing',
        'TaskSuccessWithWarnings',
        'TaskError',
        'TaskNotFound'
    ];

    //results from execute()
    /**
     * @var string|null
     */
    public $result;

    //downloaded file

    /**
     * @var string|null
     */
    public $outputFile;

    /**
     * @var string|null
     */
    public $outputFileName;

    /**
     * @var string|null
     */
    public $outputFileType;


    /**
     * @var int|null
     */
    public $remainingFiles;

    /**
     * @var int|null
     */
    public $remainingPages;

    /**
     * @var int|null
     */
    public $remainingCredits;

    /**
     * Task constructor.
     * @param string|null $publicKey
     * @param string|null $secretKey
     */
    function __construct(?string $publicKey, ?string $secretKey, bool $makeStart = false)
    {
        parent::__construct($publicKey, $secretKey);

        if ($makeStart) {
            $this->start();
        }
    }

    /**
     * @return void
     * @throws AuthException
     * @throws ProcessException
     * @throws StartException
     * @throws UploadException
     */
    public function start(): void
    {
        if ($this->tool == null) {
            throw new StartException('Tool must be set');
        }
        $data = ['v' => self::VERSION];
        $body = ['form_params' => $data];
        $response = parent::sendRequest('get', 'start/' . $this->tool, $body);
        try {
            $responseBody = json_decode($response->getBody());
        } catch (\Exception $e) {
            throw new StartException('Invalid response');
        }
        if (empty($responseBody->server)) {
            throw new StartException('no server assigned on start');
        };
        $this->_setRemainingFiles($responseBody->remaining_files ?? null);
        $this->_setRemainingPages($responseBody->remaining_pages ?? null);
        $this->_setRemainingCredits($responseBody->remaining_credits ?? null);
        $this->setWorkerServer('https://' . $responseBody->server);
        $this->setTask($responseBody->task);
    }

    /**
     * @param $nextTool
     * @return $this
     * @throws StartException
     */
    public function next(string $nextTool): self
    {
        $data = [
            'v' => self::VERSION,
            'task' => $this->getTaskId(),
            'tool' => $nextTool
        ];
        $body = ['form_params' => $data];

        try {
            $response = parent::sendRequest('post', 'task/next', $body);
            $responseBody = json_decode($response->getBody());
            if (empty($responseBody->task)) {
                throw new StartException('No task assigned on chained start');
            };
        } catch (\Exception $e) {
            throw new StartException('Error on start chained task');
        }

        $next = $this->newTask($nextTool);
        $next->setWorkerServer($this->getWorkerServer());

        $next->setTask($responseBody->task);

        //add files chained
        foreach ($responseBody->files as $serverFilename => $fileName) {
            $next->files[] = new File($serverFilename, $fileName);
        }

        return $next;
    }

    /**
     * @param string|null $task
     * @return $this
     */
    public function setTask(?string $task): self
    {
        $this->task = $task;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaskId(): ?string
    {
        return $this->task;
    }

    /**
     * @param array $files
     * @return void
     */
    public function setFiles(array $files): void
    {
        $this->files = $files;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return array
     */
    public function getFilesArray()
    {
        $filesArray = [];
        foreach ($this->files as $file) {
            $filesArray[] = $file->getFileOptions();
        }
        return $filesArray;
    }

    /**
     * @param string|null $server
     * @param string|null $taskId
     * @return Task
     * @throws \Exception
     */
    public function getStatus(?string $server = null, ?string $taskId = null)
    {
        $server = $server ? $server : $this->getWorkerServer();
        $taskId = $taskId ? $taskId : $this->getTaskId();

        if ($server == null || $taskId == null) {
            throw new \Exception('Cannot get status if no file is uploaded');
        }
        return parent::getStatus($server, $taskId);
    }

    /**
     * @param string $filePath
     * @return File
     */
    public function addFile($filePath, BaseExtraUploadParams $extraParams = null)
    {
        $this->validateTaskStarted();
        /** @psalm-suppress PossiblyNullArgument */
        $file = $this->uploadFile($this->task, $filePath,$extraParams);
        array_push($this->files, $file);
        return end($this->files);
    }

    /**
     * @param string $url
     * @return File
     */
    public function addFileFromUrl($url, $bearerToken = null,BaseExtraUploadParams $extraParams = null)
    {
        $this->validateTaskStarted();
        /** @psalm-suppress PossiblyNullArgument */
        $file = $this->uploadUrl($this->task, $url, $bearerToken,$extraParams);
        array_push($this->files, $file);
        return end($this->files);
    }

    /**
     * @param string $task
     * @param string $filepath
     *
     * @return File
     *
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function uploadFile(string $task, string $filepath, BaseExtraUploadParams $extraParams = null)
    {
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException('File ' . $filepath . ' does not exists');
        }
        $body = $this->getBodyForUploadFile($task,$filepath, $extraParams);
        $response = $this->sendRequest('post', 'upload', $body);
        return $this->getFileFromUploadResponse($response, $filepath);
    }

    protected function getBodyForUploadFile(string $task, string $filePath, BaseExtraUploadParams $extraParams = null){
        $body = [
            'multipart' => [
                $this->getMultipartFileParam('file',$filePath),
                $this->getMultipartContentParam('task',$task),
                $this->getMultipartContentParam('v',self::VERSION)
            ],
        ];
        if(!is_null($extraParams)){
            foreach ($extraParams->getValues() as $key => $value) {
                $body['multipart'][]=$this->getMultipartContentParam($key,$value);
            }
        }
        
        return $body;
    }
    /**
     * @param string $task
     * @param string $filepath
     *
     * @return File
     *
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    protected function getFileFromUploadResponse(ResponseInterface $response, string $filePath): File{
        try {
            $responseBody = json_decode($response->getBody());
        } catch (\Exception $e) {
            throw new UploadException('Upload response error');
        }
        $file = new File($responseBody->server_filename, basename($filePath));
        if(property_exists($responseBody,'pdf_pages')){
            $file->setPdfPages($responseBody->pdf_pages);
        }
        if(property_exists($responseBody,'pdf_page_number')){
            $file->setPdfPageNumber((int)$responseBody->pdf_page_number);
        }
        if(property_exists($responseBody,'pdf_forms')){
            $file->setPdfForms(json_decode(json_encode($responseBody->pdf_forms), true));
        }
        return $file;
    }

    protected function getMultipartFileParam(string $name,string $filePath): array{
        return [
            'Content-type' => 'multipart/form-data',
            'name' => $name,
            'contents' => fopen($filePath, 'r'),
            'filename' => basename($filePath)
        ];
    }

    protected function getMultipartContentParam(string $name,string $value): array{
        return ['name' => $name, 'contents' => $value];
    }

    /**
     * @return Task
     */
    public function delete()
    {
        $this->validateTaskStarted();
        /** @psalm-suppress PossiblyNullOperand */
        $response = $this->sendRequest('delete', 'task/' . $this->getTaskId());
        $this->result = json_decode($response->getBody());
        return $this;
    }

    /**
     * @param string $task
     * @param string $url
     *
     * @return File
     *
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function uploadUrl($task, $url, $bearerToken = null, BaseExtraUploadParams $extraParams = null)
    {
        $body = $this->getBodyForUploadUrlFile($task, $url, $bearerToken,$extraParams);
        $response = $this->sendRequest('post', 'upload', $body);
        return $this->getFileFromUploadResponse($response, $url);
    }

    protected function getBodyForUploadUrlFile(string $task, string $url,$bearerToken = null, BaseExtraUploadParams $extraParams = null){
        $body = [
            'multipart' => [
                $this->getMultipartFileParam('cloud_file',$url),
                $this->getMultipartContentParam('task',$task),
                $this->getMultipartContentParam('v',self::VERSION)
            ],
        ];
        if ($bearerToken) {
            $body['multipart'][] = $this->getMultipartContentParam('cloud_token',$bearerToken);
        }

        if(!is_null($extraParams)){
            foreach ($extraParams->getValues() as $key => $value) {
                $body['multipart'][]=$this->getMultipartContentParam($key,$value);
            }
        }
        
        return $body;
    }

    /**
     * @param string|null $path
     * @return void
     * @throws AuthException
     * @throws PathException
     * @throws ProcessException
     * @throws UploadException
     * @throws DownloadException
     */
    public function download($path = null)
    {
        $this->validateTaskStarted();
        if ($path != null && !is_dir($path)) {
            if (pathinfo($path, PATHINFO_EXTENSION) == '') {
                throw new PathException('Invalid download path. Use method setOutputFilename() to set the output file name.');
            }
            throw new PathException('Invalid download path. Set a valid folder path to download the file.');
        }
        /** @psalm-suppress PossiblyNullOperand */
        $this->downloadFile($this->task);

        if (is_null($path)) $path = '.';
        /** @psalm-suppress PossiblyNullOperand */
        $destination = $path . '/' . $this->outputFileName;
        $file = fopen($destination, "w+");
        /** @psalm-suppress PossiblyNullArgument */
        fputs($file, $this->outputFile);
        fclose($file);
        return;
    }

    /**
     * @return string|null
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function blob()
    {
        $this->downloadFile($this->task);
        return $this->outputFile;
    }


    /**
     * @return void
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function toBrowser()
    {
        $this->downloadFile($this->task);

        if ($this->outputFileName == null || $this->outputFile == null) {
            throw new DownloadException('No output filename');
        }

        // Try to change headers.
        try {
            if ($this->outputFileType == 'pdf') {
                header("Content-type:application/pdf");
                header("Content-Disposition:attachment;filename=\"" . $this->outputFileName . "\"");
            } else {
                if (function_exists('mb_strlen')) {
                    $size = mb_strlen($this->outputFile, '8bit');
                } else {
                    $size = strlen($this->outputFile);
                }
                header('Content-Type: application/zip');
                header("Content-Disposition: attachment; filename=\"" . $this->outputFileName . "\"");
                header("Content-Length: " . $size);
            }
        } catch (\Throwable $th) {
            // Do nothing.
            // This happens when output stream is opened and headers
            // are changed.
        } finally {
            echo $this->outputFile;
        }
    }

    /**
     * @param string|null $task
     * @param string $path
     *
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     * @throws DownloadException
     */
    private function downloadFile($task): void
    {
        $response = $this->downloadRequestData($task);

        try {
            $this->outputFile = $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw new DownloadException('No file content for download');
        }
    }

    /**
     * @param string $task
     * @return ResponseInterface
     */
    public function downloadStream(): ResponseInterface
    {
        $response = $this->downloadRequestData($this->task);

        return $response;
    }


    /**
     * @param string $task
     * @return ResponseInterface
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    private function downloadRequestData(string $task): ResponseInterface
    {
        $data = array('v' => self::VERSION);
        $body = ['form_params' => $data];
        /** @psalm-suppress PossiblyNullOperand */
        $response = parent::sendRequest('get', 'download/' . $task, $body);
        $responseHeaders = $response->getHeaders();

        $contentDisposition = isset($responseHeaders['Content-Disposition']) ? $responseHeaders['Content-Disposition'] : $responseHeaders['content-disposition'];

        if (preg_match("/filename\*\=utf-8\'\'([\W\w]+)/", $contentDisposition[0], $matchesUtf)) {
            $filename = urldecode(str_replace('"', '', $matchesUtf[1]));
        } else {
            preg_match('/ .*filename=\"([\W\w]+)\"/', $contentDisposition[0], $matches);
            $filename = str_replace('"', '', $matches[1]);
        }

        $this->outputFileName = $filename;
        $this->outputFileType = pathinfo($this->outputFileName, PATHINFO_EXTENSION);

        return $response;
    }

    /**
     * Enable or disable file encryption
     * @param bool $value
     */
    public function sendEncryptedFiles(bool $value): void
    {
        $this->setEncryption($value);
    }

    /**
     * @return bool
     */
    public function isEncrypted()
    {
        return $this->isFileEncryption();
    }

    /**
     * Keep compat
     * @return bool
     */
    public function getEncrypted()
    {
        return $this->isEncrypted();
    }

    /**
     * @return Task
     * @throws Exceptions\AuthException
     * @throws Exceptions\ProcessException
     * @throws Exceptions\UploadException
     */
    public function execute()
    {
        $this->validateTaskStarted();

        $data = array_merge(
            $this->__toArray(),
            ['task' => $this->task, 'files' => $this->files, 'v' => self::VERSION]
        );

        //clean unwanted vars to be sent
        unset($data['timeoutLarge']);
        unset($data['timeout']);
        unset($data['timeDelay']);

        $body = ['form_params' => $data];

        //$response = parent::sendRequest('post', 'process', http_build_query($body, null, '&', PHP_QUERY_RFC3986));
        $response = parent::sendRequest('post', 'process', $body);

        $this->result = json_decode($response->getBody());

        return $this;
    }

    public function __toArray()
    {
        $props = [];
        $reflection = new \ReflectionClass($this);
        $properties = array_filter(
            $reflection->getProperties(\ReflectionProperty::IS_PUBLIC),
            function ($property) {
                return !$property->isStatic();
            }
        );
        foreach ($properties as $property) {
            $name = $property->name;
            $props[$name] = $this->$name;
        }

        return $props;
        // return call_user_func('get_object_vars', $this);
    }


    /**
     * @param string $filename Set filename for downloaded zip file
     * @return Task
     */
    public function setPackagedFilename($filename)
    {
        $this->packaged_filename = $filename;
        return $this;
    }

    /**
     * @param string $filename Set filename for individual file/s
     * @return Task
     */
    public function setOutputFilename($filename)
    {
        $this->output_filename = $filename;
        return $this;
    }

    /**
     * @param File $file
     * @return $this
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function deleteFile(File $file)
    {
        $this->validateTaskStarted();

        if (($key = array_search($file, $this->files)) !== false) {
            $body = ['form_params' => ['task' => $this->getTaskId(), 'server_filename' => $file->server_filename, 'v' => self::VERSION]];
            /** @psalm-suppress PossiblyNullOperand */
            $this->sendRequest('delete', 'upload/' . $this->getTaskId() . '/' . $file->server_filename, $body);
            unset($this->files[$key]);
        }
        return $this;
    }

    /**
     * @param mixed $value
     * @param mixed $allowedValues
     * @return bool
     */
    public function checkValues($value, $allowedValues): bool
    {
        if (!in_array($value, $allowedValues)) {
            if ($this->tool) {
                throw new \InvalidArgumentException('Invalid ' . $this->tool . ' value "' . $value . '". Must be one of: ' . implode(',', $allowedValues));
            }
            throw new \InvalidArgumentException('No tool is set');
        }

        return true;
    }

    /**
     * @param boolean $try_pdf_repair
     * @return Task
     */
    public function setTryPdfRepair($try_pdf_repair): self
    {
        $this->try_pdf_repair = $try_pdf_repair;

        return $this;
    }

    /**
     * @param boolean $ignore_errors
     */
    public function setIgnoreErrors($ignore_errors): self
    {
        $this->ignore_errors = $ignore_errors;

        return $this;
    }

    /**
     * @param boolean $ignore_password
     * @return Task
     */
    public function setIgnorePassword($ignore_password): self
    {
        $this->ignore_password = $ignore_password;

        return $this;
    }


    /**
     * alias for setIgnoreError
     *
     * Will be deprecated on v2.0
     *
     * @param boolean $value If true, and multiple archives are processed it will ignore files with errors and continue process for all others
     * @return Task
     */
    public function ignoreErrors($value): self
    {
        $this->ignore_errors = $value;

        return $this;
    }

    /**
     * alias for setIgnorePassword
     *
     * Will be deprecated on v2.0
     *
     * @param boolean $value
     * @return Task
     */
    public function ignorePassword($value): self
    {
        $this->ignore_password = $value;

        return $this;
    }


    /**
     * @param string|null $encryptKey
     * @return $this
     * @throws \Exception
     */
    public function setFileEncryption(?string $encryptKey = null): self
    {
        if (count($this->files) > 0) {
            throw new \Exception('Encrypth mode cannot be set after file upload');
        }

        parent::setFileEncryption($encryptKey);

        return $this;
    }

    /**
     * set meta values as http://www.adobe.com/content/dam/Adobe/en/devnet/acrobat/pdfs/pdf_reference_1-7.pdf (page 844)
     *
     * @param int|string $key
     * @param int|string|null $value
     * @return Task
     */
    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * @param int|null $custom_int
     * @return $this
     */
    public function setCustomInt(?int $customInt): self
    {
        $this->custom_int = $customInt;
        return $this;
    }

    /**
     * @param string|null $custom_string
     * @return $this
     */
    public function setCustomString(?string $customString): self
    {
        $this->custom_string = $customString;
        return $this;
    }

    /**
     * @param string|null $tool
     * @param string|null $status
     * @param int|null $customInt
     * @param int|null $page
     * @return mixed|string|null
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function listTasks(?string $tool = null, ?string $status = null, ?int $customInt = null, ?int $page = null): array
    {

        $this->checkValues($status, $this->statusValues);

        $data = [
            'tool' => $tool,
            'status' => $status,
            'custom_int' => $customInt,
            'page' => $page,
            'v' => self::VERSION,
            'secret_key' => $this->getSecretKey()
        ];

        $body = ['form_params' => $data];

        $response = parent::sendRequest('post', 'task', $body, true);
        $this->result = json_decode($response->getBody());

        return $this->result;
    }

    /**
     * @param string|null $webhook
     * @return $this
     */
    public function setWebhook(?string $webhook): self
    {
        $this->webhook = $webhook;
        return $this;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function validateTaskStarted(): void
    {
        if ($this->task === null) {
            throw new \Exception('Current task does not exists. You must start your task');
        }
    }

    /**
     * @param $remainingCredits
     * @return void
     */
    private function _setRemainingCredits($remainingCredits): void
    {
        $this->remainingCredits = $remainingCredits;
    }

    /**
     * @param $remainingFiles
     * @return void
     */
    private function _setRemainingFiles($remainingFiles): void
    {
        $this->remainingFiles = $remainingFiles;
    }

    /**
     * @param $remainingFiles
     * @return void
     */
    private function _setRemainingPages($remainingPages): void
    {
        $this->remainingPages = $remainingPages;
    }
}
