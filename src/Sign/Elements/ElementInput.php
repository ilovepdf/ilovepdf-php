<?php

namespace Ilovepdf\Sign\Elements;


class ElementInput extends ElementAbstract
{
    /**
     * @var
     */
    public $info = ["label" => "input text","description" => null];

    public function __construct()
    {
        $this->setType("input");
    }

    public function setLabel(string $text){
        $this->info["label"] = $text;
        return $this;
    }

    public function setText(string $text){
        $this->info["description"] = $text;
        return $this;
    }
}