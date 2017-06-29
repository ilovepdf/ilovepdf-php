<?php

namespace Ilovepdf;


/**
 * Class SplitTask
 *
 * @package Ilovepdf
 */
class SplitTask extends Task
{
    /**
     * @var string
     */
    public $ranges;

    /**
     * @var string
     */
    public $split_mode;

    /**
     * @var integer
     */
    public $fixed_range;

    /**
     * @var string
     */
    public $remove_pages;

    /**
     * @var bool
     */
    public $merge_after = false;


    /**
     * SplitTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'split';
        parent::__construct($publicKey, $secretKey, true);
    }


    /**
     * @param int $range
     */
    public function setFixedRange($range = 1)
    {
        $this->split_mode = 'fixed_range';
        $this->fixed_range = $range;
        return $this;
    }

    /**
     * @param string $pages
     */
    public function setRemovePages($pages)
    {
        $this->split_mode = 'remove_pages';
        $this->remove_pages = $pages;
        return $this;
    }

    /**
     * @param $pages string      example: "1,5,10-14", default null
     */
    public function setRanges($pages)
    {
        $this->split_mode = 'ranges';
        $this->ranges = $pages;
        return $this;
    }

    /**
     * @param boolean $value
     */
    public function setMergeAfter($value)
    {
        $this->merge_after = $value;
        return $this;
    }

    /**
     * @param null $processData
     * @return mixed
     */
    public function execute($processData = null)
    {
        $this->tool = 'split';
        return parent::execute(get_object_vars($this));
    }
}
