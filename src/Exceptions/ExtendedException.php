<?php

namespace Ilovepdf\Exceptions;

class ExtendedException extends \Exception
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
        $this->type = $response->body->error->type;
        $this->params = $response->body->error->param;

        if (is_array($this->params) && isset($this->params[0]) && isset($this->params[0]->error)) {
            parent::__construct($message . ' (' . $this->params[0]->error . ')', $code, $previous);
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
