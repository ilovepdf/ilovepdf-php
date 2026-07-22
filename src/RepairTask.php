<?php

namespace Ilovepdf;
/**
 * Class RepairTask
 *
 * @package Ilovepdf
 */
class RepairTask extends Task
{

    /**
     * RepairTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'repair';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }
}
