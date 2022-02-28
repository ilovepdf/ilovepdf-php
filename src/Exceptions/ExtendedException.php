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
    public function __construct($message, $responseBody = null, $code = 0, $previous = null)
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

                if (is_string($params)) {
                    $firstError = $params; //download exception
                } else {
                    $error = array_values($params);
                    if (is_array($error[0])) {
                        $error[0] = array_values($error[0]);
                        $firstError = $error[0][0];    //task deleted before execute
                    } else {
                        $firstError = $error[0];
                    }
                }
            }
            parent::__construct($message . ' (' . $firstError . ')', $code, $previous);
        } else {
            if ($responseBody && $responseBody->message) {
                $message .= ' (' . $responseBody->message . ')';
            }
            parent::__construct($message, $code, $previous);
        }
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
