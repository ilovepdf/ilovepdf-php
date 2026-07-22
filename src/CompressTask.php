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
    public $compression_level = 'recommended';

    /**
     * @var string[]
     */
    private $compressionLevelValues = ["extreme", "recommended", "low"];

    /**
     * CompressTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'compress';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }

    /**
     * @param string $level
     *
     * values: ["extreme"|"recommended"|"low"]
     * default: "recommended"
     *
     * @return CompressTask
     */
    public function setCompressionLevel(string $level): self
    {
        $this->checkValues($level, $this->compressionLevelValues);

        $this->compression_level = $level;

        return $this;
    }
}
