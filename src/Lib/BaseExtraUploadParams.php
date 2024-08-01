<?php

namespace Ilovepdf\Lib;
// This class is design so that every programmer adapts it to the additional Tools with specific needs and uses the setValue 
abstract class BaseExtraUploadParams
{
    protected $extraParams = [];

    protected function setValue(string $key, string $value){
        $this->extraParams[$key] = $value;
    }

    public function getValues(): array{
        return $this->extraParams;
    }

}