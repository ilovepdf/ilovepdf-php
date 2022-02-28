<?php

namespace Ilovepdf;


/**
 * Class ImagepdfTask
 *
 * @package Ilovepdf
 */
class ImagepdfTask extends Task
{
    /**
     * @var string|null
     */
    public $orientation;

    /**
     * @var string[]
     */
    private $orientationValues = ['portrait', 'landscape'];

    /**
     * @var integer|null
     */
    public $margin;

    /**
     * @var bool|null
     */
    public $merge_after = true;

    /**
     * @var string|null
     */
    public $pagesize;

    /**
     * @var string[]
     */
    private $pagesizeValues = ['fit', 'A4', 'letter'];


    /**
     * CompressTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'imagepdf';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * @param string $orientation
     * @return $this
     */
    public function setOrientation(string $orientation): self
    {
        $this->checkValues($orientation, $this->orientationValues);

        $this->orientation = $orientation;
        return $this;
    }

    /**
     * @param int $margin
     * @return $this
     */
    public function setMargin(int $margin): self
    {
        $this->margin = $margin;
        return $this;
    }

    /**
     * @param string $pagesize
     * @return $this
     */
    public function setPagesize(string $pagesize): self
    {
        $this->checkValues($pagesize, $this->pagesizeValues);
        $this->pagesize = $pagesize;
        return $this;
    }

    /**
     * @param bool $merge_after
     * @return $this
     */
    public function setMergeAfter(bool $merge_after): self
    {
        $this->merge_after = $merge_after;
        return $this;
    }

}
