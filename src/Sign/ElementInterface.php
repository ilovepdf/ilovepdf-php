<?php

namespace Ilovepdf\Sign;


interface ElementInterface
{
    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return mixed
     */
    public function validate();
}