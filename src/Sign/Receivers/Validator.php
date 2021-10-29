<?php

namespace Ilovepdf\Sign\Receivers;

use Ilovepdf\Sign\Receivers\ReceiverAbstract;

class Validator extends ReceiverAbstract
{
    public function __construct(string $name, string $email)
    {
        $this->setType("validator");
        parent::__construct($name,$email);
    }
}