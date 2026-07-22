<?php

namespace Ilovepdf;


/**
 * Class RotateTask
 *
 * @package Ilovepdf
 */
class RotateTask extends Task
{

    /**
     * RotateTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'rotate';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }
}
