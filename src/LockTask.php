<?php

namespace Ilovepdf;
/**
 * Class LockTask
 *
 * @package Ilovepdf
 */
class LockTask extends Task
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
        $this->tool = 'lock';
        parent::__construct($publicKey, $secretKey);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
