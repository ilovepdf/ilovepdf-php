<?php

namespace Ilovepdf\Sign\Elements;


class ElementInitials extends ElementAbstract
{
    /**
     * @var integer
     */
    public $size = 28;

    public function __construct()
    {
        $this->setType("initials");
    }
}