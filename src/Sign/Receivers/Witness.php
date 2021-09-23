<?php

namespace Ilovepdf\Sign\Receivers;

use Ilovepdf\Sign\Receivers\ReceiverAbstract;

class Witness extends ReceiverAbstract
{
    public function __construct(string $name, string $email, array $signatureFiles = [])
    {
        $this->setType("viewer");
        parent::__construct($name,$email,$signatureFiles);
    }
}