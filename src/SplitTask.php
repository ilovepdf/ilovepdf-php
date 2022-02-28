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
     * @var string|null
     */
    public $ranges;

    /**
     * @var string|null
     */
    public $split_mode;

    /**
     * @var integer|null
     */
    public $fixed_range;

    /**
     * @var string|null
     */
    public $remove_pages;

    /**
     * @var bool
     */
    public $merge_after = false;


    /**
     * SplitTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'split';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }


    /**
     * @param int $range
     */
    public function setFixedRange($range = 1): self
    {
        $this->split_mode = 'fixed_range';
        $this->fixed_range = $range;
        return $this;
    }

    /**
     * @param string $pages
     */
    public function setRemovePages(string $pages): self
    {
        $this->split_mode = 'remove_pages';
        $this->remove_pages = $pages;
        return $this;
    }

    /**
     * @param string $pages       example: "1,5,10-14", default null
     */
    public function setRanges(string $pages): self
    {
        $this->split_mode = 'ranges';
        $this->ranges = $pages;
        return $this;
    }

    /**
     * @param bool $value
     */
    public function setMergeAfter(bool $value): self
    {
        $this->merge_after = $value;
        return $this;
    }
}
