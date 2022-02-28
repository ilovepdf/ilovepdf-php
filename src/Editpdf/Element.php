<?php

namespace Ilovepdf\Editpdf;

use Ilovepdf\Lib\Helper;

/**
 * Class Element
 *
 * @package Ilovepdf\Editpdf
 */
class Element
{
    private const VALIDATION_ERROR_MESSAGE = [
        'required' => 'This parameter is required',
        'custom' => '%message'
    ];

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $pages;

    /**
     * @var integer
     */
    private $rotation = 0;

    /**
     * @var integer
     */
    private $opacity = 100;

    /**
     * @var array|null
     */
    private $coordinates;

    /**
     * @var array
     */
    private $errors = [];


    public function __construct()
    {
        $className = explode("\\", static::class);
        $className = array_pop($className);
        $className = str_replace("Element", "", $className);
        $this->type = strtolower($className);
    }

    /**
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param string $pages
     * @return $this
     */
    public function setPages(string $pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return int
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * @param int $rotation
     * @return $this
     */
    public function setRotation(int $rotation)
    {
        $isValid = $rotation >= 0 && $rotation <= 360;
        if (!$isValid) {
            throw new \InvalidArgumentException("Rotation must be an integer between 0 and 360");
        }
        $this->rotation = $rotation;
        return $this;
    }

    /**
     * @return int
     */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
     * @param int $opacity
     * @return $this
     */
    public function setOpacity(int $opacity)
    {
        $isValid = $opacity >= 0 && $opacity <= 100;
        if (!$isValid) {
            throw new \InvalidArgumentException("Opacity must be an integer between 0 and 100");
        }
        $this->opacity = $opacity;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @param float $x
     * @param float $y
     * @return $this
     */
    public function setCoordinates(float $x, float $y)
    {
        $isValid = $x >= 0 && $y >= 0;
        if (!$isValid) {
            throw new \InvalidArgumentException("x and y must be greater than 0");
        }

        $this->coordinates = ['x' => $x, 'y' => $y];
        return $this;
    }

    /**
     * @return TextElement
     */
    static public function createText()
    {
        $instance = new TextElement();
        return $instance;
    }

    /**
     * @return ImageElement
     */
    static public function createImage()
    {
        $instance = new ImageElement();
        return $instance;
    }

    /**
     * @return SvgElement
     */
    static public function createSvg()
    {
        $instance = new SvgElement();
        return $instance;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $this->errors = [];

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param string $attrName
     * @param string $errorType
     * @param array $params
     * @return void
     */
    function addError(string $attrName, string $errorType, array $params = [])
    {
        $msg = self::VALIDATION_ERROR_MESSAGE[$errorType] ?? null;
        if ($msg === null) throw new \InvalidArgumentException("Unknown errorType '{$errorType}'");
        $formattedMsg = Helper::namedSprintf($msg, $params);

        if (!array_key_exists($attrName, $this->errors)) $this->errors[$attrName] = [];

        $this->errors[$attrName][] = $formattedMsg;
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        return [
            'type' => $this->type,
            'pages' => $this->pages,
            'rotation' => $this->rotation,
            'opacity' => $this->opacity,
            'coordinates' => $this->coordinates,
        ];
    }
}