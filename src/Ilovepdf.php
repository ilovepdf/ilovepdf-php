<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\DownloadException;
use Ilovepdf\Exceptions\ProcessException;
use Ilovepdf\Exceptions\SignatureException;
use Ilovepdf\Exceptions\StartException;
use Ilovepdf\Exceptions\TaskException;
use Ilovepdf\Exceptions\UploadException;
use Ilovepdf\Exceptions\AuthException;
use Ilovepdf\Http\Client;
use Ilovepdf\Http\ClientException;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class Ilovepdf
{
    /**
     * @var string|null The Ilovepdf secret API key to be used for requests.
     */
    private $secretKey;

    /**
     * @var string|null The Ilovepdf public API key to be used for requests.
     */
    private $publicKey;

    /**
     * @var string
     */
    private static $startServer = 'https://api.ilovepdf.com';

    /**
     * @var string|null
     */
    private $workerServer;

    /**
     * @var string|null The version of the Ilovepdf API to use for requests.
     */
    public static $apiVersion = 'v1';

    const VERSION = 'php.1.3.0';

    /**
     * @var string|null
     */
    public $token;

    /**
     * @var int delay in seconds, for timezone exceptions.
     * Time sholud be UTC, but some servers maybe are not using NAT.
     * This var is here to correct this delay. Currently 5400 seconds : 1h:30'
     */
    public $timeDelay = 5400;

    /**
     * @var bool
     */
    private $encrypted = false;

    /**
     * @var string|null
     */
    private $encryptKey;

    /**
     * @var int
     */
    public $timeout = 10;

    /**
     * @var int|null
     */
    public $timeoutLarge;


    /**
     * @var mixed|null
     */
    public $info;

    /**
     * @param string|null $publicKey
     * @param string|null $secretKey
     */
    public function __construct(?string $publicKey = null, ?string $secretKey = null)
    {
        if ($publicKey && $secretKey) {
            $this->setApiKeys($publicKey, $secretKey);
        }
    }

    /**
     * @return string The API secret key used for requests.
     */
    public function getSecretKey(): string
    {
        return $this->secretKey ?? '';
    }

    /**
     * @return string The API secret key used for requests.
     */
    public function getPublicKey(): string
    {
        return $this->publicKey ?? '';
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $publicKey
     * @param string $secretKey
     * @return void
     */
    public function setApiKeys(string $publicKey, string $secretKey): void
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion(): ?string
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion The API version to use for requests.
     */
    public static function setApiVersion($apiVersion): void
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
        if ($this->isFileEncryption() == true) {
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
     * @param array $params
     * @param bool $start
     *
     * @return ResponseInterface response from server
     *
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function sendRequest(string $method, string $endpoint, array $params = [], bool $start = false): ResponseInterface
    {
        $to_server = self::getStartServer();
        if (!$start && !is_null($this->getWorkerServer())) {
            $to_server = $this->workerServer;
        }

        /** @psalm-suppress PossiblyNullOperand */
        $timeout = ($endpoint == 'process' || $endpoint == 'upload' || strpos($endpoint, 'download/') === 0) ? $this->timeoutLarge : $this->timeout;
        $requestConfig = [
            'connect_timeout' => $timeout,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getJWT(),
                'Accept' => 'application/json'
            ],
        ];

        $requestParams = $requestConfig;
        if ($params) {
            $requestParams = array_merge($requestConfig, $params);
        }

        $client = new Client($params);
        $error = null;

        try {
            /** @psalm-suppress PossiblyNullOperand */
            $response = $client->request($method, $to_server . '/v1/' . $endpoint, $requestParams);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $error = $e;
        }
        $responseCode = $response->getStatusCode();
        if ($responseCode != 200 && $responseCode != 201) {
            $responseBody = json_decode((string)$response->getBody());
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
            } elseif (strpos($endpoint, 'start') === 0) {
                if (isset($responseBody->error) && isset($responseBody->error->type)) {
                    throw new StartException($responseBody->error->message, $responseBody, $responseCode);
                }
                throw new \Exception('Bad Request');
            } else {
                if ($response->getStatusCode() == 429) {
                    throw new \Exception('Too Many Requests');
                }
                if ($response->getStatusCode() == 400) {
                    //common process exception
                    if (strpos($endpoint, 'task') !== false) {
                        throw new TaskException('Invalid task id');
                    }
                    //signature exception
                    if(strpos($endpoint, 'signature') !== false){
                        throw new SignatureException($responseBody->error->type, $responseBody, $response->getStatusCode());
                    }

                    if (isset($responseBody->error) && isset($responseBody->error->type)) {
                        throw new \Exception($responseBody->error->message);
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
    public function newTask(string $tool = '', ?bool $makeStart = true)
    {
        $classname = '\\Ilovepdf\\' . ucwords(strtolower($tool)) . 'Task';
        if (!class_exists($classname)) {
            throw new \InvalidArgumentException('Invalid tool');
        }

        if ($tool == '') {
            $makeStart = false;
        }

        $task = new $classname($this->getPublicKey(), $this->getSecretKey(), $makeStart);
        return $task;
    }

    /**
     * @param string $server
     * @return void
     */
    public static function setStartServer(string $server)
    {
        self::$startServer = $server;
    }

    /**
     * @return string
     */
    public function getStartServer(): string
    {
        return self::$startServer;
    }

    /**
     * @return string|null
     */
    public function getWorkerServer(): ?string
    {
        return $this->workerServer;
    }

    /**
     * @param string|null $workerServer
     * @return void
     */
    public function setWorkerServer(?string $workerServer): void
    {
        $this->workerServer = $workerServer;
    }


    /**
     * @param string|null $encryptKey
     * @return $this
     */
    public function setFileEncryption(?string $encryptKey = null)
    {
        $this->setEncryption($encryptKey == null);
        $this->setEncryptKey($encryptKey);

        return $this;
    }

    /**
     * @param bool $enable
     * @return void
     */
    public function enableEncryption(bool $enable)
    {
        $this->encrypted = $enable;
    }

    /**
     * Compat, this will be removed
     *
     * @param bool $enable
     * @return void
     */
    public function setEncryption(bool $enable): void
    {
        $this->enableEncryption($enable);
    }

    /**
     * @return bool
     */
    public function isFileEncryption(): bool
    {
        return $this->encrypted;
    }

    /**
     * @return string|null
     */
    public function getEncrytKey(): ?string
    {
        return $this->encryptKey;
    }

    /**
     * @param string|null $encryptKey
     * @return void
     */
    public function setEncryptKey(?string $encryptKey = null): void
    {
        if ($encryptKey == null) {
            $encryptKey = IlovepdfTool::rand_sha1(32);
        }
        $len = strlen($encryptKey);
        if ($len != 16 && $len != 24 && $len != 32) {
            throw new \InvalidArgumentException('Encrypt key should have 16, 14 or 32 chars length');
        }
        $this->encryptKey = $encryptKey;
    }

    /**
     * @param string $server
     * @param string $taskId
     * @return mixed
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    public function getStatus(string $server, string $taskId)
    {
        $workerServer = $this->getWorkerServer();
        $this->setWorkerServer($server);
        $response = $this->sendRequest('get', 'task/' . $taskId);
        $this->setWorkerServer($workerServer);
        return json_decode($response->getBody());
    }

    /**
     * @param bool $verify
     */
    public function verifySsl(bool $verify): void
    {
        Client::setVerify($verify);
    }

    /**
     * @param bool $follow
     */
    public function followLocation(bool $follow): void
    {
        Client::setAllowRedirects($follow);
    }

    /**
     * @return object
     * @throws AuthException
     * @throws ProcessException
     * @throws UploadException
     */
    private function getUpdatedInfo(): object
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
