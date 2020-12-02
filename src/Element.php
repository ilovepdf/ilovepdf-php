<?php

namespace Ilovepdf;

class Element
{

    /**
     * @var string
     */
    public $type = 'text';

    /**
     * @var string
     */
    public $mode = 'text';

    /**
     * @var string
     */
    public $text = null;

    /**
     * @var string
     */
    public $image = null;

    /**
     * @var string
     */
    public $pages = 'all';

    /**
     * @var string
     */
    public $vertical_position = 'Middle';

    /**
     * @var string
     */
    public $horizontal_position = 'Center';

    /**
     * @var integer
     */
    public $vertical_adjustment = 0;

    /**
     * @var integer
     */
    public $horizontal_adjustment = 0;

    /**
     * @var integer
     */
    public $rotation = 0;

    /**
     * @var integer
     */
    public $transparency = 100;

    /**
     * @var integer
     */
    public $opacity = 100;

    /**
     * @var bool
     */
    public $mosaic = false;

    /**
     * @var string
     */
    public $font_family;

    private $fontFamilyValues = ['Arial', 'Arial Unicode MS', 'Verdana', 'Courier', 'Times New Roman', 'Comic Sans MS', 'WenQuanYi Zen Hei', 'Lohit Marathi'];

    /**
     * @var string
     */
    public $font_style = 'Regular';

    /**
     * @var string
     */
    public $font_color = '#000000';

    /**
     * @var
     */
    public $font_size = 14;

    /**
     * @var
     */
    public $image_resize = 1;

    /**
     * @var
     */
    public $zoom = 1;

    /**
     * @var
     */
    public $gravity = 'Center';

    /**
     * @var int
     */
    public $border;

    /**
     * @var string
     */
    public $layer;


    public $bold = false;

    /**
     * string
     * @var
     */
    public $server_filename;

    public function __construct($values = null)
    {
        if (is_array($values)) {
            foreach ($values as $name => $value) {
                if (property_exists(self::class, $name)) {
                    $this->$name = $value;
                }
            }
        }
    }

    /**
     * @param string $mode
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @param mixed $server_filename
     * @return Element
     */
    public function setServerFilename($server_filename)
    {
        $this->server_filename = $server_filename;
        return $this;
    }

    /**
     * @param File $file
     * @return Element
     */
    public function setFile($file)
    {
        $this->server_filename = $file->getServerFilename();
        return $this;
    }
}