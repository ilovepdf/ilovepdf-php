<?php

namespace Ilovepdf\Exceptions;

use Exception;

class ExtendedException extends Exception
{

    /**
     * @var mixed|null
     */
    private $params;

    /**
     * @var string|null
     */
    private $type;

    /**
     * ExtendedException constructor.
     *
     * @param string $message
     * @param mixed $responseBody
     * @param int $code
     * @param \Throwable $previous
     */
    public function __construct($message,  $responseBody = null, $code = 0, $previous = null)
    {
        if (!$code) {
            $code = 0;
        }
        if ($responseBody && isset($responseBody->error) && $responseBody->error->type) {
            $this->type = $responseBody->error->type;
        }
        if ($responseBody && isset($responseBody->error) && isset($responseBody->error->param)) {
            $this->params = $responseBody->error->param;
        }
        if ($this->params) {
            if (is_array($this->params)) {
                if (is_object($this->params[0])) {
                    $firstError = $this->params[0]->error;  //test unlock fail
                } else {
                    $firstError = $this->params[0];
                }
            } else {
                $params = json_decode(json_encode($this->params), true);
                $firstError = $this->getFirstErrorString($params);
            }
            parent::__construct($message . ' (' . $firstError . ')', $code, $previous);
        } else {
            if ($responseBody) {
                $message .= ' (' . $responseBody->error->message . ')';
            }
            parent::__construct($message, $code, $previous);
        }
    }

    private function getFirstErrorString($error){
        if (!is_string($error)) {
            return $this->getFirstErrorString(array_values($error)[0]);
        }
        return $error;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        if (!is_countable($this->params)) {
            return [];
        }
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
