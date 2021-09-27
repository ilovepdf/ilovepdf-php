<?php

namespace Ilovepdf\Sign\Elements;


class ElementSignature extends ElementAbstract
{
    public function __construct()
    {
        $this->setType("signature");
    }

}