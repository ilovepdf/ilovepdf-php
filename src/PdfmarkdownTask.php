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
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'pdfmarkdown';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }
}
