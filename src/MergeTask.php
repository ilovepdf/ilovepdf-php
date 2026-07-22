<?php

namespace Ilovepdf;
/**
 * Class MergeTask
 *
 * @package Ilovepdf
 */
class MergeTask extends Task
{

    public $ignore_errors = false;

    /**
     * MergeTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool='merge';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }
}
