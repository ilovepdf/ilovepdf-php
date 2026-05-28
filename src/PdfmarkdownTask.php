<?php

namespace Ilovepdf;
/**
 * Class PdfjpgTask
 *
 * @package Ilovepdf
 */
class PdfmarkdownTask extends Task
{

    /**
     * PdfjpgTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'pdfmarkdown';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }
}
