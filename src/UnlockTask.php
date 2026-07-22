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
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'unlock';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }
}
