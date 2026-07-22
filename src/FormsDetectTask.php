<?php

namespace Ilovepdf;


use Ilovepdf\Exceptions\InvalidParamsException;

/**
 * Class FormDetectTask
 *
 * @package Ilovepdf
 */
class FormsDetectTask extends Task
{

    /**
     * SplitTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param null|string $region API region
     *
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'formsdetect';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }
}
