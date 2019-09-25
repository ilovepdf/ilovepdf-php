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
     * @var string
     */
    public $orientation;

    private $orientationValues = ['portrait', 'landscape'];

    /**
     * @var integer
     */
    public $margin;

    /**
     * @var boolean
     */
    public $merge_after = true;

    /**
     * @var string
     */
    public $pagesize;

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
     */
    public function setOrientation($orientation)
    {
        $this->checkValues($orientation, $this->orientationValues);

        $this->orientation = $orientation;
        return $this;
    }

    /**
     * @param integer $margin
     * @return Task
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;
        return $this;
    }

    /**
     * @param string $pagesize
     * @return Task
     */
    public function setPagesize($pagesize)
    {
        $this->checkValues($pagesize, $this->pagesizeValues);
        $this->pagesize = $pagesize;
        return $this;
    }

    /**
     * @param boolean $merge_after
     */
    public function setMergeAfter($merge_after)
    {
        $this->merge_after = $merge_after;
        return $this;
    }

    /**
     * @param null $processData
     * @return mixed
     */
    public function execute($processData = null)
    {
        return parent::execute(get_object_vars($this));
    }
}
