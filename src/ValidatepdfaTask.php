<?php

namespace Ilovepdf;
/**
 * Class CompressTask
 *
 * @package Ilovepdf
 */
class ValidatepdfaTask extends Task
{
    /**
     * @var string
     */
    public $conformance = "pdfa-2b";

    private $conformanceValues = ['pdfa-1b', 'pdfa-1a', 'pdfa-2b', 'pdfa-2u', 'pdfa-2a', 'pdfa-3b', 'pdfa-3u', 'pdfa-3a'];

    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'validatepdfa';
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

    public function download($path = null)
    {
        return;
    }

    public function blob(){
        $this->download();
    }

    public function toBrowser(){
        $this->download();
    }
}
