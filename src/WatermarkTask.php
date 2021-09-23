<?php

namespace Ilovepdf;

use Ilovepdf\Element;

/**
 * Class WatermarkTask
 *
 * @package Ilovepdf
 */
class WatermarkTask extends Task
{
    /**
     * @var string
     */
    public $mode;
    private $modeValues = ['image', 'text', 'multi'];

    /**
     * @var string
     */
    public $text;

    /**
     * @var strig
     */
    public $image;

    /**
     * @var string
     */
    public $pages;

    /**
     * @var string
     */
    public $vertical_position;

    private $verticalPositionValues = ['bottom', 'middle', 'top'];
    /**
     * @var string
     */
    public $horizontal_position;

    private $horizontalPositionValues = ['left', 'center', 'right'];

    /**
     * @var integer
     */
    public $vertical_position_adjustment;

    /**
     * @var integer
     */
    public  $horizontal_position_adjustment;

    /**
     * @var boolean
     */
    public $mosaic;

    /**
     * @var integer
     */
    public $rotation;

    /**
     * @var string
     */
    public $font_family;

    private $fontFamilyValues = ['Arial', 'Arial Unicode MS', 'Verdana', 'Courier', 'Times New Roman', 'Comic Sans MS', 'WenQuanYi Zen Hei', 'Lohit Marathi'];

    /**
     * @var string
     */
    public $font_style;

    /**
     * @var integer
     */
    public $font_size;

    /**
     * @var string
     */
    public $font_color;

    /**
     * @var integer
     */
    public $transparency;

    /**
     * @var string
     */
    public $layer;

    private $layerValues = ['above', 'below'];

    /**
     * @var array
     */
    public $elements;


    /**
     * WatermarkTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool='watermark';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }



    /**
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param strig $image
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param File $image
     */
    public function setImageFile(File $imageFile)
    {
        $this->image = $imageFile->getServerFilename();
        return $this;
    }

    /**
     * @param string $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @param string $vertical_position
     */
    public function setVerticalPosition($vertical_position)
    {
        $this->checkValues($vertical_position, $this->verticalPositionValues);

        $this->vertical_position = $vertical_position;
        return $this;
    }

    /**
     * @param string $horizontal_position
     */
    public function setHorizontalPosition($horizontal_position)
    {
        $this->checkValues($horizontal_position, $this->horizontalPositionValues);

        $this->horizontal_position = $horizontal_position;
        return $this;
    }

    /**
     * @param int $vertical_position_adjustment
     */
    public function setVerticalPositionAdjustment($vertical_position_adjustment)
    {
        $this->vertical_position_adjustment = $vertical_position_adjustment;
        return $this;
    }

    /**
     * @param int $horizontal_position_adjustment
     */
    public function setHorizontalPositionAdjustment($horizontal_position_adjustment)
    {
        $this->horizontal_position_adjustment = $horizontal_position_adjustment;
        return $this;
    }

    /**
     * @param boolean $mosaic
     */
    public function setMosaic($mosaic)
    {
        $this->mosaic = $mosaic;
        return $this;
    }

    /**
     * @param int $rotation
     */
    public function setRotation($rotation)
    {
        $this->rotation = $rotation;
        return $this;
    }

    /**
     * @param string $font_family
     */
    public function setFontFamily($font_family)
    {
        $this->checkValues($font_family, $this->fontFamilyValues);

        $this->font_family = $font_family;
        return $this;
    }

    /**
     * @param string $font_style
     */
    public function setFontStyle($font_style)
    {
        $this->font_style = $font_style;
        return $this;
    }

    /**
     * @param int $font_size
     */
    public function setFontSize($font_size)
    {
        $this->font_size = $font_size;
        return $this;
    }

    /**
     * @param string $font_color
     */
    public function setFontColor($font_color)
    {
        $this->font_color = $font_color;
        return $this;
    }

    /**
     * @param int $transparency
     */
    public function setTransparency($transparency)
    {
        $this->transparency = $transparency;
        return $this;
    }

    /**
     * @param string $layer
     */
    public function setLayer($layer)
    {
        $this->checkValues($layer, $this->layerValues);

        $this->layer = $layer;
        return $this;
    }

    /**
     * adds a watermark element
     *
     * @param $element
     * @return $this
     */
    public function addElement($element)
    {

        if (is_a($element, 'Element')) {
            $this->elements[] = $element;
        } elseif (is_array($element)) {
            $this->elements[] = new Element($element);
        }
        return $this;
    }
}
