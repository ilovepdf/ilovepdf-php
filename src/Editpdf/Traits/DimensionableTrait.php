<?php

namespace Ilovepdf\Editpdf\Traits;

trait DimensionableTrait
{
    /**
     * @var mixed|null
     */
    private $dimensions = null;

    /**
     * @param float $width
     * @param float $height
     * @return $this
     */
    public function setDimensions(float $width, float $height): self
    {
        $isValid = $width > 0 && $height > 0;
        if (!$isValid) {
            throw new \InvalidArgumentException("Width and height must be greater than 0");
        }

        $this->dimensions = ['w' => $width, 'h' => $height];
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }
}