<?php
namespace Ilovepdf\Editpdf\Traits;

trait DimensionableTrait
{
  private $dimensions = null;

  public function setDimensions(float $width, float $height){
    $isValid = $width > 0 && $height > 0;
    if(!$isValid) {
      throw new \InvalidArgumentException("Width and height must be greater than 0");
    }
    
    $this->dimensions = ['w' => $width, 'h' => $height];
    return $this;
  }

  public function getDimensions($w, $h){
    return $this->dimensions;
  }
}