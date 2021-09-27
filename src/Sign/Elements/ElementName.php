<?php

namespace Ilovepdf\Sign\Elements;


class ElementName extends ElementAbstract
{
    public function __construct()
    {
        $this->setType("name");
    }
}