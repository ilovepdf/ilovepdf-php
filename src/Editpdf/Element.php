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
      'required'  => 'This parameter is required',
      'custom'    => '%message'
    ];

    /**
     * @var string
     */
    private $type = null;

    /**
     * @var string
     */
    private $pages = null;

    /**
     * @var integer
     */
    private $rotation = 0;

    /**
     * @var integer
     */
    private $opacity = 100;

    /**
     * @var array
     */
    private $coordinates = null;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(){
      $className = explode("\\", (string)static::class);
      $className = array_pop($className);
      $className = str_replace("Element", "", $className);
      $this->type = strtolower($className);
    }

    public function getType(){
      return $this->type;
    }

    public function getPages(){
      return $this->pages;
    }

    public function setPages($pages){
      $this->pages = (string)$pages;
      return $this;
    }

    public function getRotation(){
      return $this->rotation;
    }

    public function setRotation(int $rotation){
      $isValid = (is_int($rotation) && $rotation >= 0 && $rotation <= 360);
      if(!$isValid){
        throw new \InvalidArgumentException("Rotation must be an integer between 0 and 360");
      }
      return $this->rotation = $rotation;
      return $this;
    }

    public function getOpacity(){
      return $this->opacity;
    }

    public function setOpacity(int $opacity){
      $isValid = (is_int($opacity) && $opacity >= 0 && $opacity <= 100);
      if(!$isValid){
        throw new \InvalidArgumentException("Opacity must be an integer between 0 and 100");
      }
      $this->opacity = $opacity;
      return $this;
    }

    public function getCoordinates(){
      return $this->coordinates;
    }

    public function setCoordinates(float $x, float $y){
      $isValid = $x >= 0 && $y >= 0;
      if(!$isValid) {
        throw new \InvalidArgumentException("x and y must be greater than 0");
      }
      
      $this->coordinates = ['x' => $x, 'y' => $y];
      return $this;
    }

    static public function createText(){
      $instance = new TextElement();
    }
    
    static public function createImage(){
      $instance = new ImageElement();
    }

    static public function createSvg(){
      $instance = new SvgElement();
    }

    public function validate(){
      $this->errors = [];

      return empty($this->errors);
    }

    public function getErrors(){
      return $this->errors;
    }

    private function addError(string $attrName, string $errorType, array $params=[]){
      $msg = @self::VALIDATION_ERROR_MESSAGE[$errorType];
      if($msg === null) throw new \InvalidArgumentException("Unknown errorType '{$errorType}'");
      $formattedMsg = Helper::namedSprintf($msg, $params);

      if(!array_key_exists($attrName, $this->errors)) $this->errors[$attrName] = [];

      $this->errors[$attrName][] = $formattedMsg;
    }

    public function __toArray()
    {
      return [
        'type'        => $this->type,
        'pages'       => $this->pages,
        'rotation'    => $this->rotation,
        'opacity'     => $this->opacity,
        'coordinates' => $this->coordinates,
      ];
    }
}