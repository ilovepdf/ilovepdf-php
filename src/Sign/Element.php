<?php

namespace Ilovepdf\Sign;


class Element
{

    /**
     * @var string
     */
    public $type = 'signature';

    /**
     * @var array Allowed $type values
     */
    private $typeValues = ['signature', 'initials', 'name', 'date', 'text', 'input'];

    /**
     * @var string
     */
    public $position = '0 0';

    /**
     * @var string
     */
    public $pages = '1';

    /**
     * @var integer
     */
    public $size = 40;

    /**
     * @var
     */
    public $measure_type;

    /**
     * @var
     */
    public $color;

    /**
     * @var
     */
    public $font;

    /**
     * @var
     */
    public $content;

    public function __construct(?string $type = 'signature')
    {
        $this->setType($type);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Element
     */
    public function setType(string $type): Element
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     * @return Element
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     * @return Element
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return Element
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeasureType()
    {
        return $this->measure_type;
    }

    /**
     * @param mixed $measure_type
     * @return Element
     */
    public function setMeasureType($measure_type)
    {
        $this->measure_type = $measure_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     * @return Element
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param mixed $font
     * @return Element
     */
    public function setFont($font)
    {
        $this->font = $font;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Element
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function __toArray(): array
    {
        return [
            'type' => $this->getType(),
            'position' => $this->getPosition(),
            'pages' => $this->getPages(),
            'size' => $this->getSize(),
            'measure_type' => $this->getMeasureType(),
            'color' => $this->getColor(),
            'content' => $this->getContent(),
        ];
    }
}