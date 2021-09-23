<?php

namespace Ilovepdf\Sign\Receivers;

use Ilovepdf\Sign\Receivers\ReceiverAbstract;

class Validator extends ReceiverAbstract
{
    public function __construct(string $name, string $email, array $signatureFiles = [])
    {
        $this->setType("validator");
        parent::__construct($name,$email,$signatureFiles);
    }
}