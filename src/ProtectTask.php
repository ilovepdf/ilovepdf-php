<?php

namespace Ilovepdf;
/**
 * Class LockTask
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
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'protect';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
