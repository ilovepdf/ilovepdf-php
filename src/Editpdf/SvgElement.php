<?php

namespace Ilovepdf\Editpdf;

use Ilovepdf\File;
use Ilovepdf\Editpdf\Traits\DimensionableTrait;

class SvgElement extends Element
{
  use DimensionableTrait;

  private $file = null;

  public function setFile(File $file){
    $this->file = $file;
  }

  public function validate(){
    parent::validate();
    
    if($this->file === null) $this->addError('file', 'required');
    if($this->file && empty($this->file->server_filename)){ 
      $this->addError('file', 'custom', ['message' => 'server_filename not present in file']);
    }

    return empty($this->errors);
  }

  public function __toArray()
    {
      $data = array_merge(
        parent::__toArray(),
        [
          'server_filename' => $this->file->getServerFilename(),
          'dimensions'      => $this->dimensions // From DimensionableTrait
        ]
      );
      return $data;
    }
}