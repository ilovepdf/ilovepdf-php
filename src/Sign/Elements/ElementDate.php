<?php

namespace Ilovepdf\Sign\Elements;


class ElementDate extends ElementAbstract
{
    public $dateFormats = ["d-m-Y","d/m/Y","Y-m-d","Y/m/d"];
    public function __construct()
    {
        $this->setType("date");
        $this->setContent("Y-m-d");
    }

    public function setContent(string $newDate){
        if(!in_array($newDate,$this->dateFormats)){
            throw new \InvalidArgumentException("invalid date format, formats must be one of the following: ".$this->dateFormats);
        }
        $this->content = $newDate;
        return $this;
    }
}