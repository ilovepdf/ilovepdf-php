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
     * @var string
     */
    public $conformance = "pdfa-2b";


    /**
     * @var boolean
     */
    public $allow_downgrade = true;

    private $conformanceValues = ['pdfa-1b', 'pdfa-1a', 'pdfa-2b', 'pdfa-2u', 'pdfa-2a', 'pdfa-3b', 'pdfa-3u', 'pdfa-3a'];

    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'pdfa';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param string $conformance
     * @return Task
     */
    public function setConformance($conformance)
    {
        $this->checkValues($conformance, $this->conformanceValues);

        $this->conformance = $conformance;
        return $this;
    }

    /**
     * @param null $processData
     * @return mixed
     */
    public function execute($processData = null)
    {
        return parent::execute(get_object_vars($this));
    }

    /**
     * @param boolean $allowDowngrade
     */
    public function setAllowDowngrade($allowDowngrade)
    {
        $this->allow_downgrade = $allowDowngrade;
    }
}
