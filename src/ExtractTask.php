<?php

namespace Ilovepdf;
/**
 * Class CompressTask
 *
 * @package Ilovepdf
 */
class ExtractTask extends Task
{
    /**
     * @var boolean
     */
    public $detailed = false;

    /**
     * @var boolean
     */
    public $by_word = false;

    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'extract';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param boolean $detailed
     * @return $this
     */
    public function setDetailed($detailed)
    {
        $this->detailed = $detailed;
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
     * @param boolean $by_word
     */
    public function setByWord($by_word)
    {
        $this->by_word = $by_word;
    }

}
