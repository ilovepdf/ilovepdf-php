<?php

namespace Ilovepdf;

/**
 * Class SummarizeTask
 *
 * @package Ilovepdf
 */
class SummarizeTask extends Task
{

    /**
     * @var string Output file format of the summary.
     */
    public $output_format = 'pdf';

    /**
     * @var string[]
     */
    private $outputFormatValues = ["pdf", "md"];

    /**
     * @var null Language of the input document.
     */
    public $language = null;

    private $languageValues = [
        "en", "es", "fr", "de", "it", "pt", "ja", "ru", "ko", "zh-cn",
        "zh-tw", "ar", "bg", "ca", "nl", "el", "hi", "id", "ms", "pl",
        "sv", "th", "tr", "uk", "vi"
    ];

    /**
     * CompressTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param null|string $region       API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'summarize';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }

    /**
     * @param string $language
     *
     *  values: ["en", "es", "fr", "de", "it", "pt", "ja", "ru", "ko", "zh-cn",
     * "zh-tw", "ar", "bg", "ca", "nl", "el", "hi", "id", "ms", "pl",
     * "sv", "th", "tr", "uk", "vi"]
     *  default: null
     *
     * @return $this
     */
    function setLanguage(string $language):self{
        $this->checkValues($language, $this->languageValues);
        $this->language = $language;
        return $this;
    }

    /**
     * @param string $format
     *
     *  values: ["pdf", "md"]
     *  default: "pdf"
     *
     * @return $this
     */
    function setOutputFormat(string $format): self
    {
        $this->checkValues($format, $this->outputFormatValues);
        $this->output_format = $format;
        return $this;
    }
}
