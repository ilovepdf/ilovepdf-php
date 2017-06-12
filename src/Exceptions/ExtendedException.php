<?php

namespace Ilovepdf\Exceptions;

use Exception;

class ExtendedException extends Exception
{

    private $params;
    private $type;

    /**
     * ExtendedException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     * @param $response
     */
    public function __construct($message, $code = 0, Exception $previous = null, $response)
    {
        if(isset($response->body->error) && $response->body->error->type){
            $this->type = $response->body->error->type;
        }
        if (isset($response->body->error->param)) {
            $this->params = $response->body->error->param;
        }
        if ($this->params) {
            $firstError = reset(json_decode(json_encode($this->params), true));
            parent::__construct($message . ' (' . $firstError[0] . ')', $code, $previous);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}
