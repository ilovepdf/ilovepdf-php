<?php

namespace Ilovepdf;

/**
 * Class OfficepdfTask
 *
 * @package Ilovepdf
 */
class OfficepdfTask extends Task
{

    /**
     * OfficepdfTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'officepdf';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }
}
