<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\DownloadException;
use Ilovepdf\Exceptions\ProcessException;
use Ilovepdf\Exceptions\TaskException;
use Ilovepdf\Exceptions\UploadException;
use Ilovepdf\Exceptions\StartException;
use Ilovepdf\Exceptions\AuthException;
use Ilovepdf\IlovepdfTool;
use Ilovepdf\Request\Body;
use Ilovepdf\Request\Request;
use Ilovepdf\Lib\JWT;

/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class Ilovepdf
{
    // @var string The Ilovepdf secret API key to be used for requests.
    private $secretKey = null;

    // @var string The Ilovepdf public API key to be used for requests.
    private $publicKey = null;

    // @var string The base URL for the Ilovepdf API.
    private static $startServer = 'https://api.ilovepdf.com';

    private $workerServer = null;

    // @var string|null The version of the Ilovepdf API to use for requests.
    public static $apiVersion = 'v1';

    const VERSION = 'php.1.1.18';

    public $token = null;

    /*
     * @var int delay in seconds, for timezone exceptions.
     * Time sholud be UTC, but some servers maybe are not using NAT.
     * This var is here to correct this delay. Currently 5400 seconds : 1h:30'
     */
    public $timeDelay = 5400;

    private $encrypted = false;
    private $encryptKey;

    public $timeout = 10;
    public $timeoutLarge = null;

    public $info = null;


    public function __construct($publicKey = null, $secretKey = null)
    {
        if ($publicKey && $secretKey)
            $this->setApiKeys($publicKey, $secretKey);
    }

    /**
     * @return string The API secret key used for requests.
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @return string The API secret key used for requests.
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public function setApiKeys($publicKey, $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion The API version to use for requests.
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * @return string The JWT to be used on api requests
     */
    public function getJWT()
    {
//        if (!is_null($this->token) && !$this->getFileEncryption()) {
//            return $this->token;
//        }

        // Collect all the data
        $secret = $this->getSecretKey();

        $currentTime = time();
        $request = '';
        $hostInfo = '';

        // Merge token with presets not to miss any params in custom
        // configuration
        $token = array_merge([
            'iss' => $hostInfo,
            'aud' => $hostInfo,
            'iat' => $currentTime - $this->timeDelay,
            'nbf' => $currentTime - $this->timeDelay,
            'exp' => $currentTime + 3600 + $this->timeDelay
        ], []);

        // Set up id
        $token['jti'] = $this->getPublicKey();

        // Set encryptKey
        if ($this->getFileEncryption()){
            $token['file_encryption_key'] = $this->getEncrytKey();
        }

        $this->token = JWT::encode($token, $secret, static::getTokenAlgorithm());

        return $this->token;
    }


    /**
     * @return string
     */
    public static function getTokenAlgorithm()
    {
        return 'HS256';
    }


    /**
     * @param string $method
     * @param string $endpoint
     * @param string $body
     *
     * @return mixed response from server
     *
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function sendRequest($method, $endpoint, $body=null, $start=false)
    {
        $to_server = self::$startServer;
        if (!$start && !is_null($this->getWorkerServer())) {
            $to_server = $this->workerServer;
        }

        if ($endpoint == 'process' || $endpoint == 'upload' || strpos($endpoint, 'download/') === 0) {
            Request::timeout($this->timeoutLarge);
        } else {
            Request::timeout($this->timeout);
        }

        $response = Request::$method($to_server . '/v1/' . $endpoint, array(
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getJWT()
        ), $body);

        if ($response->code != '200' && $response->code != '201') {
            if ($response->code == 401) {
                throw new AuthException($response->body->name, $response->code, null, $response);
            }
            if ($endpoint == 'upload') {
                if(is_string($response->body)){
                    throw new UploadException("Upload error", $response->code, null, $response);
                }
                throw new UploadException($response->body->error->message, $response->code, null, $response);
            }
            elseif ($endpoint == 'process') {
                throw new ProcessException($response->body->error->message, $response->code, null, $response);
            }
            elseif (strpos($endpoint, 'download')===0) {
                throw new DownloadException($response->body->error->message, $response->code, null, $response);
            }
            else{
                if ($response->code == 400) {
                    if(strpos($endpoint, 'task')!=-1){
                        throw new TaskException('Invalid task id');
                    }
                    throw new \Exception('Bad Request');
                }
                throw new \Exception($response->body->error->message);
            }
        }
        return $response;
    }

    /**
     * @param string $tool              Api tool to use
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     *
     * @return mixed Return implemented Task class for specified tool
     *
     * @throws \Exception
     */
    public function newTask($tool='', $makeStart = true)
    {
        $classname = '\\Ilovepdf\\' . ucwords(strtolower($tool)) . 'Task';
        if (!class_exists($classname)) {
            throw new \InvalidArgumentException();
        }
        return new $classname($this->getPublicKey(), $this->getSecretKey(), $makeStart);
    }

    public static function setStartServer($server){
        self::$startServer = $server;
    }


    public static function getStartServer(){
        return self::$startServer;
    }

    /**
     * @return string Return url
     */
    public function getWorkerServer()
    {
        return $this->workerServer;
    }

    /**
     * @param null $workerServer
     */
    public function setWorkerServer($workerServer)
    {
        $this->workerServer = $workerServer;
    }



    /**
     * @param boolean $value
     */
    public function setFileEncryption($value, $encryptKey=null)
    {
        $this->encrypted = $value;
        if($this->encrypted){
            $this->setEncryptKey($encryptKey);
        }
        else{
            $this->encryptKey = null;
        }
    }


    /**
     * @return bool
     */
    public function getFileEncryption()
    {
        return $this->encrypted;
    }

    /**
     * @return mixed
     */
    public function getEncrytKey()
    {
        return $this->encryptKey;
    }

    /**
     * @param mixed $encrytKey
     */
    public function setEncryptKey($encryptKey=null)
    {
        if($encryptKey==null){
            $encryptKey = IlovepdfTool::rand_sha1(32);
        }
        $len = strlen($encryptKey);
        if ($len != 16 && $len != 24 && $len != 32) {
            throw new \InvalidArgumentException('Encrypt key shold have 16, 14 or 32 chars length');
        }
        $this->encryptKey = $encryptKey;
    }

    /**
     * @return Task
     */
    public function getStatus($server, $taskId)
    {
        $workerServer = $this->getWorkerServer();
        $this->setWorkerServer($server);
        $response = $this->sendRequest('get', 'task/'.$taskId);
        $this->setWorkerServer($workerServer);

        return $response->body;
    }

    /**
     * @param $verify
     */
    public function verifySsl($verify){
        Request::verifyPeer($verify);
        Request::verifyHost($verify);
    }

    /**
     * @param $follow
     */
    public function followLocation($follow){
        Request::followLocation($follow);
    }

    private function getUpdatedInfo(){
        $data = array('v' => self::VERSION);
        $body = Body::Form($data);
        $response = self::sendRequest('get', 'info', $body);
        $this->info = $response->body;
        return $this->info;
    }



    /**
     * @return object
     */
    public function getInfo()
    {
        $info = $this->getUpdatedInfo();
        return $info;
    }

    /**
     * @return integer
     */
    public function getRemainingFiles()
    {
        $info = $this->getUpdatedInfo();
        return $info->remaining_files;
    }
}
