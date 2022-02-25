<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\DownloadException;
use Ilovepdf\Exceptions\ProcessException;
use Ilovepdf\Exceptions\TaskException;
use Ilovepdf\Exceptions\UploadException;
use Ilovepdf\Exceptions\StartException;
use Ilovepdf\Exceptions\AuthException;
use Ilovepdf\Http\Client;
use Ilovepdf\Http\ClientException;
use Ilovepdf\IlovepdfTool;
use Firebase\JWT\JWT;

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

    private static $startServer = 'https://api.ilovepdf.com';

    private $workerServer = null;

    // @var string|null The version of the Ilovepdf API to use for requests.
    public static $apiVersion = 'v1';

    const VERSION = 'php.1.2.2';

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
        return $this->secretKey ?? '';
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
        if ($this->getFileEncryption()) {
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
     * @param mixed $body
     *
     * @return mixed response from server
     *
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function sendRequest($method, $endpoint, $params = [], $start = false)
    {
        $to_server = self::getStartServer();
        if (!$start && !is_null($this->getWorkerServer())) {
            $to_server = $this->workerServer;
        }
        $timeout = ($endpoint == 'process' || $endpoint == 'upload' || strpos($endpoint, 'download/') === 0) ? $this->timeoutLarge : $this->timeout;
        $requestConfig = [
            'connect_timeout' => $timeout,
            'headers' => ['Authorization' => 'Bearer ' . $this->getJWT(), 'Accept' => 'application/json'],
        ];

        $requestParams = $requestConfig;
        if($params) {
            $requestParams = array_merge($requestConfig, $params);
        }

        $client = new Client($params);
        $error = null;

        try {
            $response = $client->request($method, $to_server . '/v1/' . $endpoint, $requestParams);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $error = $e;
        }
        $responseCode = $response->getStatusCode();
        if ($responseCode != '200' && $responseCode != '201') {
            $responseBody = json_decode($response->getBody());
            if ($responseCode == 401) {
                throw new AuthException($responseBody->name, $responseBody, $responseCode);
            }
            if ($endpoint == 'upload') {
                if (is_string($responseBody)) {
                    throw new UploadException("Upload error", $responseBody, $responseCode);
                }
                throw new UploadException($responseBody->error->message, $responseBody, $responseCode);
            } elseif ($endpoint == 'process') {
                throw new ProcessException($responseBody->error->message, $responseBody, $responseCode);
            } elseif (strpos($endpoint, 'download') === 0) {
                throw new DownloadException($responseBody->error->message, $responseBody, $responseCode);
            } else {
                if ($response->getStatusCode() == 429) {
                    throw new \Exception('Too Many Requests');
                }
                if ($response->getStatusCode() == 400) {
                    if (strpos($endpoint, 'task') != -1) {
                        throw new TaskException('Invalid task id');
                    }
                    throw new \Exception('Bad Request');
                }
                if (isset($responseBody->error) && isset($responseBody->error->message)) {
                    throw new \Exception($responseBody->error->message);
                }
                throw new \Exception('Bad Request');
            }
        }

        return $response;
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
        $classname = '\\Ilovepdf\\' . ucwords(strtolower($tool)) . 'Task';
        if (!class_exists($classname)) {
            throw new \InvalidArgumentException('Invalid tool');
        }

        if($tool == ''){
            $makeStart = false;
        }

        $task = new $classname($this->getPublicKey(), $this->getSecretKey(), $makeStart);
        return $task;
    }

    public static function setStartServer($server)
    {
        self::$startServer = $server;
    }

    public static function getStartServer()
    {
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
    public function setFileEncryption($value, $encryptKey = null)
    {
        $this->encrypted = $value;
        if ($this->encrypted) {
            $this->setEncryptKey($encryptKey);
        } else {
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
    public function setEncryptKey($encryptKey = null)
    {
        if ($encryptKey == null) {
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
        $response = $this->sendRequest('get', 'task/' . $taskId);
        $this->setWorkerServer($workerServer);
        return json_decode($response->getBody());
    }

    /**
     * @param $verify
     */
    public function verifySsl($verify)
    {
        Client::setVerify($verify);
    }

    /**
     * @param $follow
     */
    public function followLocation($follow)
    {
        Client::setAllowRedirects($follow);
    }

    private function getUpdatedInfo()
    {
        $data = array('v' => self::VERSION);
        $body = ['form_params' => $data];
        $response = self::sendRequest('get', 'info', $body);
        $this->info = json_decode($response->getBody());
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
