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
        if (isset($response->body->error) && $response->body->error->type) {
            $this->type = $response->body->error->type;
        }
        if (isset($response->body->error->param)) {
            $this->params = $response->body->error->param;
        }
        if ($this->params) {
            if (is_array($this->params)) {
                if(is_object($this->params[0])){
                    $firstError = $this->params[0]->error;  //test unlock fail
                }
                else{
                    $firstError = $this->params[0];
                }
            } else {
                $params = json_decode(json_encode($this->params), true);

                if(is_string($params)){
                    $firstError = $params; //download exception
                }
                else{
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
