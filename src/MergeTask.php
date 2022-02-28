<?php

namespace Ilovepdf;
/**
 * Class MergeTask
 *
 * @package Ilovepdf
 */
class MergeTask extends Task
{

    public $ignore_errors = false;

    /**
     * MergeTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool='merge';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }
}
