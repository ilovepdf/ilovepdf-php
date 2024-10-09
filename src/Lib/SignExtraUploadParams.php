<?php

namespace Ilovepdf\Lib;
// This class is design so that every programmer adapts it to the additional Tools with specific needs and uses the setValue 
class SignExtraUploadParams extends BaseExtraUploadParams
{
    public function setPdfInfo(bool $activate = true){
        $this->extraParams['pdfinfo'] = $activate ? '1' : '0';
        return $this;
    }

    public function setPdfForms(bool $activate = true){
        $this->setPdfInfo(true);
        $this->extraParams['pdfforms'] = $activate ? '1' : '0';
        return $this;
    }


}