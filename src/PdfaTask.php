<?php

namespace Ilovepdf;
/**
 * Class CompressTask
 *
 * @package Ilovepdf
 */
class PdfaTask extends Task
{
    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'pdfa';
        parent::__construct($publicKey, $secretKey);
    }
}
