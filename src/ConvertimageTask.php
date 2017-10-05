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
    public $to = 'jpg';

    private $toValues = ["jpg", "png", "gif"];

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
    public function setTo($to)
    {
        $this->checkValues($to, $this->toValues);
        $this->to = $to;
        return $this;
    }
}
