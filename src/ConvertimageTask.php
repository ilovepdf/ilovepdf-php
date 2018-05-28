<?php

namespace Ilovepdf;
/**
 * Class ConvertimageTask
 *
 * @package Ilovepdf
 */
class ConvertimageTask extends Task
{
    /**
     * @var string
     */
    public $convert_to = 'jpg';

    private $convert_toValues = ["jpg", "png", "gif"];

    /**
     * ConvertimageTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'convertimage';
        parent::__construct($publicKey, $secretKey, true);
    }

    /**
     * @param $level string
     *
     * values: ["jpg"|"png"|"gif"]
     * default: "jpg"
     */
    public function setTo($convert_to)
    {
        $this->checkValues($convert_to, $this->convert_toValues);
        $this->convert_to = $convert_to;
        return $this;
    }
}
