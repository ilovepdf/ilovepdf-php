<?php

namespace Ilovepdf\Exceptions;

class AuthException extends \Exception
{

    private $params;
    private $type;

    public function __construct($message,
                                $code = 0,
                                Exception $previous = null,
                                $response)
    {
        parent::__construct($message, $code, $previous);

        $this->type = $response->body->name;
        $this->params = null;
    }

    public function getErrors()
    {
        return $this->params;
    }

    public function getType()
    {
        return $this->type;
    }
}
