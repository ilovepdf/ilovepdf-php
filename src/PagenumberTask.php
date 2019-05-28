<?php

namespace Ilovepdf;
/**
 * Class Ilovepdf
 *
 * @package Ilovepdf
 */
class PagenumberTask extends Task
{
    /**
     * @var boolean
     */
    public $facing_pages;

    /**
     * @var boolean
     */
    public $first_cover;

    /**
     * @var string
     */
    public $pages;

    /**
     * @var integer
     */
    public $starting_number;

    /**
     * @var string
     */
    public $vertical_position;

    private $verticalPositionValues = ['bottom', 'top'];

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
    public $horizontal_position_adjustment;

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
     * @var string
     */
    public $text;

    /**
     * AddnumbersTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'pagenumber';
        parent::__construct($publicKey, $secretKey, $makeStart);

        return true;
    }

    /**
     * @param boolean $facing_pages
     */
    public function setFacingPages($facing_pages)
    {
        $this->facing_pages = $facing_pages;
        return $this;
    }

    /**
     * @param boolean $first_cover
     */
    public function setFirstCover($first_cover)
    {
        $this->first_cover = $first_cover;
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
     * @param int $starting_number
     * @return Task
     */
    public function setStartingNumber($starting_number)
    {
        $this->starting_number = $starting_number;
        return $this;
    }

    /**
     * @param string $vertical_position
     * @return Task
     */
    public function setVerticalPosition($vertical_position)
    {
        $this->checkValues($vertical_position, $this->verticalPositionValues);

        $this->vertical_position = $vertical_position;
        return $this;
    }

    /**
     * @param string $horizontal_position
     * @return Task
     */
    public function setHorizontalPosition($horizontal_position)
    {
        $this->checkValues($horizontal_position, $this->horizontalPositionValues);

        $this->horizontal_position = $horizontal_position;
        return $this;
    }

    /**
     * @param int $horizontal_position_adjustment
     * @return Task
     */
    public function setHorizontalPositionAdjustment($horizontal_position_adjustment)
    {
        $this->horizontal_position_adjustment = $horizontal_position_adjustment;
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
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
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
