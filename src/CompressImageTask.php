<?php

namespace Ilovepdf;
/**
 * Class CompressimageTask
 *
 * @package Ilovepdf
 */
class CompressimageTask extends Task
{

    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'compressimage';
        parent::__construct($publicKey, $secretKey, true);
    }

}
