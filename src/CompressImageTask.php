<?php

namespace Ilovepdf;
/**
 * Class CompressimageTask
 *
 * @package Ilovepdf
 */
class CompressimageTask extends Task
{
    /**
     * @var string
     */
    public $compression_level='recommended';

    private $compressionLevelValues = ["extreme", "recommended", "low"];

    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'compressimage';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param $level string
     *
     * values: ["extreme"|"recommended"|"low"]
     * default: "recommended"
     */
    public function setCompressionLevel($level)
    {
        $this->checkValues($level, $this->compressionLevelValues);

        $this->compression_level = $level;

        return $this;
    }
}
