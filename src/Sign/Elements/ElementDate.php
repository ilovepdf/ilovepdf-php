<?php

namespace Ilovepdf\Sign\Elements;


class ElementDate extends ElementAbstract
{
    public $dateFormats = ["d-m-Y", "d/m/Y", "Y-m-d", "Y/m/d"];

    public function __construct()
    {
        $this->setType("date");
        $this->setContent("Y-m-d");
    }

    protected function setContent(string $content)
    {
        if (!in_array($content, $this->dateFormats)) {
            throw new \InvalidArgumentException("invalid date format, formats must be one of the following: " . $this->dateFormats);
        }

        $this->content = $content;
        return $this;
    }
}