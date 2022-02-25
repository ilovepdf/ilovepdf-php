<?php

namespace Ilovepdf\Http;


use Psr\Http\Message\ResponseInterface;

class Client
{
    private static $verify = true;
    private static $allowRedirects = true;

    private $client;

    public function __construct(array $params = [])
    {
        $defaultParams = [
            'allow_redirects' => self::$allowRedirects,
            'http_errors' => false,
            'verify' => self::$verify,
        ];

        $this->client = new \GuzzleHttp\Client(array_merge_recursive($defaultParams, $params));
    }

    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri, $options);
    }

    public static function setAllowRedirects(bool $follow)
    {
        self::$allowRedirects = $follow;
    }

    /**
     * @param $verify
     */
    public static function setVerify($verify)
    {
        self::$verify = $verify;
    }
}