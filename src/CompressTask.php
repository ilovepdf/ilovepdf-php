<?php

namespace Ilovepdf;
/**
 * Class CompressTask
 *
 * @package Ilovepdf
 */
class CompressTask extends Task
{
    /**
     * @var string
     */
    public $compression_level;

    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'compress';
        parent::__construct($publicKey, $secretKey);
    }

    /**
     * @param $level string
     *
     * values: ["extreme"|"recommended"|"less"]
     * default: "recommended"
     */
    public function setCompressionLevel($level)
    {
        $this->compression_level = $level;
    }
}
