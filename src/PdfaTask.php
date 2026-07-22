<?php

namespace Ilovepdf;
/**
 * Class PdfaTask
 *
 * @package Ilovepdf
 */
class PdfaTask extends Task
{
    /**
     * @var string
     */
    public $conformance = "pdfa-2b";

    /**
     * @var boolean
     */
    public $allow_downgrade = true;

    /**
     * @var string[]
     */
    private $conformanceValues = ['pdfa-1b', 'pdfa-1a', 'pdfa-2b', 'pdfa-2u', 'pdfa-2a', 'pdfa-3b', 'pdfa-3u', 'pdfa-3a'];

    /**
     * CompressTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'pdfa';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }

    /**
     * @param string $conformance
     * @return $this
     */
    public function setConformance($conformance): self
    {
        $this->checkValues($conformance, $this->conformanceValues);

        $this->conformance = $conformance;
        return $this;
    }


    /**
     * @param bool $allowDowngrade
     * @return $this
     */
    public function setAllowDowngrade(bool $allowDowngrade): self
    {
        $this->allow_downgrade = $allowDowngrade;
        return $this;
    }
}
