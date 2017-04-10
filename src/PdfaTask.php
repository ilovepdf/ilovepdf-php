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
    public $conformance = "default";

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

    /**
     * @param string $conformance
     */
    public function setConformance($conformance)
    {
        $this->conformance = $conformance;
    }

    /**
     * @param null $processData
     * @return mixed
     */
    public function execute($processData = null)
    {
        return parent::execute(get_object_vars($this));
    }
}
