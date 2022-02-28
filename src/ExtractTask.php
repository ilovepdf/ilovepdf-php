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
     * @var bool
     */
    public $detailed = false;

    /**
     * @var bool
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
    public function setDetailed($detailed): self
    {
        $this->detailed = $detailed;
        return $this;
    }


    /**
     * @param bool $by_word
     */
    public function setByWord(bool $by_word): self
    {
        $this->by_word = $by_word;
        return $this;
    }
}
