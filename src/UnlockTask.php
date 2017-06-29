<?php

namespace Ilovepdf;
/**
 * Class UnlockTask
 *
 * @package Ilovepdf
 */
class UnlockTask extends Task
{

    /**
     * UnlockTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'unlock';
        parent::__construct($publicKey, $secretKey, true);
    }
}
