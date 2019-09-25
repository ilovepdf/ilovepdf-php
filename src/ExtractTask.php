<?php

namespace Ilovepdf;

/**
 * Class ExtractTask
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
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'extract';
        parent::__construct($publicKey, $secretKey, $makeStart);
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
