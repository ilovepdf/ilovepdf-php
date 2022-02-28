<?php

namespace Ilovepdf\Http;


use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * @var bool
     */
    private static $verify = true;

    /**
     * @var bool
     */
    private static $allowRedirects = true;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $defaultParams = [
            'allow_redirects' => self::$allowRedirects,
            'http_errors' => false,
            'verify' => self::$verify,
        ];

        $this->client = new \GuzzleHttp\Client(array_merge_recursive($defaultParams, $params));
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $uri = '', array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri, $options);
    }

    /**
     * @param bool $follow
     * @return void
     */
    public static function setAllowRedirects(bool $follow): void
    {
        self::$allowRedirects = $follow;
    }

    /**
     * @param bool $verify
     */
    public static function setVerify(bool $verify): void
    {
        self::$verify = $verify;
    }
}