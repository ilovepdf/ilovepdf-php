<?php

namespace Ilovepdf\Sign\Elements;


class ElementInitials extends ElementAbstract
{
    public function __construct()
    {
        $this->setType("initials");
    }
}