<?php

namespace Ilovepdf\Exceptions;

class ProcessException extends \Exception {

    private $params;
    private $type;

    public function __construct($message,
                                $code = 0,
                                Exception $previous = null,
                                $response)
    {
        parent::__construct($message, $code, $previous);

        $this->type = $response->body->error->type;
        $this->params = $response->body->error->param;
    }

    public function getErrors() {

        /*foreach($this->params as $key=>$error_param){
            foreach($error_param as $single_param){
                $errors[$key]=$single_param;
            }
        }*/
        return $this->params;
    }
    public function getType() {

        /*foreach($this->params as $key=>$error_param){
            foreach($error_param as $single_param){
                $errors[$key]=$single_param;
            }
        }*/
        return $this->type;
    }
}
