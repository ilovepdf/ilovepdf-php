<?php

namespace Ilovepdf;
/**
 * Class ProtectTask
 *
 * @package Ilovepdf
 */
class ProtectTask extends Task
{

    /**
     * @var string
     */
    public $password;

    /**
     * UnlockTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'protect';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
