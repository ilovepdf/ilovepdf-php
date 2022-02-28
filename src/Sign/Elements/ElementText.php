<?php

namespace Ilovepdf\Sign\Elements;


class ElementText extends ElementAbstract
{
    public function __construct()
    {
        $this->setType("text");
        $this->setText("text");
    }

    public function setText(string $text){
        $this->setContent($text);
        return $this;
    }

}