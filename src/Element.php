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
     * @var string|null
     */
    public $text = null;

    /**
     * @var string|null
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
     * @var string[]
     */
    private $verticalPositionValues = ['bottom', 'middle', 'top'];

    /**
     * @var string
     */
    public $horizontal_position = 'Center';

    /**
     * @var string[]
     */
    private $horizontalPositionValues = ['left', 'center', 'right'];

    /**
     * @var integer
     */
    public $vertical_position_adjustment = 0;

    /**
     * @var integer
     */
    public $horizontal_position_adjustment = 0;

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
     * @var string|null
     */
    public $font_family;

    /**
     * @var string[]
     */
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
     * @var int
     */
    public $font_size = 14;

    /**
     * @var int
     */
    public $image_resize = 1;

    /**
     * @var int
     */
    public $zoom = 1;

    /**
     * @var string
     */
    public $gravity = 'Center';

    /**
     * @var int|null
     */
    public $border;

    /**
     * @var string|null
     */
    public $layer;

    /**
     * @var bool
     */
    public $bold = false;

    /**
     * @var string|null
     */
    public $server_filename;

    /**
     * @param array $values
     */
    public function __construct(array $values = null)
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
     * @return Element
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $text
     * @return Element
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $image
     * @return Element
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param int $rotation
     * @return Element
     */
    public function setRotation(int $rotation): self
    {
        $this->rotation = $rotation;
        return $this;
    }

    /**
     * @param string $font_family
     * @return Element
     */
    public function setFontFamily(string $font_family): self
    {
        $this->checkValues($font_family, $this->fontFamilyValues);

        $this->font_family = $font_family;
        return $this;
    }

    /**
     * @param string $font_style
     * @return Element
     */
    public function setFontStyle(string $font_style): self
    {
        $this->font_style = $font_style;
        return $this;
    }

    /**
     * @param int $font_size
     * @return Element
     */
    public function setFontSize(int $font_size): self
    {
        $this->font_size = $font_size;
        return $this;
    }

    /**
     * @param string $font_color
     */
    public function setFontColor(string $font_color): self
    {
        $this->font_color = $font_color;
        return $this;
    }

    /**
     * @param int $transparency
     */
    public function setTransparency(int $transparency): self
    {
        $this->transparency = $transparency;
        return $this;
    }


    /**
     * @param string $vertical_position
     */
    public function setVerticalPosition(string $vertical_position): self
    {
        $this->checkValues($vertical_position, $this->verticalPositionValues);

        $this->vertical_position = $vertical_position;
        return $this;
    }

    /**
     * @param string $horizontal_position
     */
    public function setHorizontalPosition(string $horizontal_position): self
    {
        $this->checkValues($horizontal_position, $this->horizontalPositionValues);

        $this->horizontal_position = $horizontal_position;
        return $this;
    }

    /**
     * @param int $vertical_position_adjustment
     */
    public function setVerticalPositionAdjustment(int $vertical_position_adjustment): self
    {
        $this->vertical_position_adjustment = $vertical_position_adjustment;
        return $this;
    }

    /**
     * @param int $horizontal_position_adjustment
     */
    public function setHorizontalPositionAdjustment($horizontal_position_adjustment): self
    {
        $this->horizontal_position_adjustment = $horizontal_position_adjustment;
        return $this;
    }

    /**
     * @param mixed $server_filename
     * @return Element
     */
    public function setServerFilename(string $server_filename): self
    {
        $this->server_filename = $server_filename;
        return $this;
    }

    /**
     * @param File $file
     * @return Element
     */
    public function setFile(File $file): self
    {
        $this->server_filename = $file->getServerFilename();
        return $this;
    }

    /**
     * @param mixed $value
     * @param mixed $allowedValues
     * @return bool
     */
    public function checkValues($value, $allowedValues): bool
    {
        if (!in_array($value, $allowedValues)) {
            throw new \InvalidArgumentException('Invalid element value "' . $value . '". Must be one of: ' . implode(',', $allowedValues));
        }

        return true;
    }
}