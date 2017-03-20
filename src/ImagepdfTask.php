<?php

namespace Ilovepdf;


/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class ImagepdfTask extends Task
{
    /**
     * @var string
     */
    public $orientation;

    /**
     * @var integer
     */
    public $margin;

    /**
     * @var string
     */
    public $pagesize;


    /**
     * CompressTask constructor.
     * @param string $publicKey
     * @param string $secretKey
     */
    function __construct($publicKey, $secretKey)
    {
        $this->tool = 'imagepdf';
        parent::__construct($publicKey, $secretKey);
    }

    /**
     * @param string $orientation
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;
    }

    /**
     * @param integer $margin
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;
    }

    /**
     * @param string $pagesize
     */
    public function setPagesize($pagesize)
    {
        $this->pagesize = $pagesize;
    }
}
