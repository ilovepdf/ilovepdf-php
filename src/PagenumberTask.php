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
     * @var bool|null
     */
    public $facing_pages;

    /**
     * @var boolean|null
     */
    public $first_cover;

    /**
     * @var string|null
     */
    public $pages;

    /**
     * @var integer|null
     */
    public $starting_number;

    /**
     * @var string|null
     */
    public $vertical_position;

    /**
     * @var string[]
     */
    private $verticalPositionValues = ['bottom', 'top'];

    /**
     * @var string|null
     */
    public $horizontal_position;

    /**
     * @var string[]
     */
    private $horizontalPositionValues = ['left', 'center', 'right'];

    /**
     * @var integer|null
     */
    public $vertical_position_adjustment;

    /**
     * @var integer|null
     */
    public $horizontal_position_adjustment;

    /**
     * @var string|null
     */
    public $font_family;

    /**
     * @var string[]
     */
    private $fontFamilyValues = ['Arial', 'Arial Unicode MS', 'Verdana', 'Courier', 'Times New Roman', 'Comic Sans MS', 'WenQuanYi Zen Hei', 'Lohit Marathi'];

    /**
     * @var string|null
     */
    public $font_style;

    /**
     * @var integer|null
     */
    public $font_size;

    /**
     * @var string|null
     */
    public $font_color;

    /**
     * @var string|null
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
     * @param bool $facing_pages
     * @return $this
     */
    public function setFacingPages(bool $facing_pages): self
    {
        $this->facing_pages = $facing_pages;
        return $this;
    }

    /**
     * @param bool $first_cover
     * @return $this
     */
    public function setFirstCover(bool $first_cover): self
    {
        $this->first_cover = $first_cover;
        return $this;
    }

    /**
     * @param string $pages
     * @return $this
     */
    public function setPages(string $pages): self
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @param int $starting_number
     * @return $this
     */
    public function setStartingNumber(int $starting_number): self
    {
        $this->starting_number = $starting_number;
        return $this;
    }

    /**
     * @param string $vertical_position
     * @return $this
     */
    public function setVerticalPosition(string $vertical_position): self
    {
        $this->checkValues($vertical_position, $this->verticalPositionValues);

        $this->vertical_position = $vertical_position;
        return $this;
    }

    /**
     * @param string $horizontal_position
     * @return $this
     */
    public function setHorizontalPosition(string $horizontal_position): self
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
     * @return $this
     */
    public function setVerticalPositionAdjustment(int $vertical_position_adjustment): self
    {
        $this->vertical_position_adjustment = $vertical_position_adjustment;
        return $this;
    }

    /**
     * @param string $font_family
     * @return $this
     */
    public function setFontFamily(string $font_family): self
    {
        $this->checkValues($font_family, $this->fontFamilyValues);

        $this->font_family = $font_family;
        return $this;
    }


    /**
     * @param string $font_style
     * @return $this
     */
    public function setFontStyle(string $font_style): self
    {
        $this->font_style = $font_style;
        return $this;
    }

    /**
     * @param int $font_size
     * @return $this
     */
    public function setFontSize(int $font_size): self
    {
        $this->font_size = $font_size;
        return $this;
    }

    /**
     * @param string $font_color
     * @return $this
     */
    public function setFontColor(string $font_color): self
    {
        $this->font_color = $font_color;
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }
}
