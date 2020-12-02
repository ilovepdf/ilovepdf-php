<?php

namespace Ilovepdf\Editpdf;

use Ilovepdf\File;
use Ilovepdf\Editpdf\Traits\DimensionableTrait;

class ImageElement extends Element
{
  use DimensionableTrait;

  private $file = null;

  public function setImage(File $file){
    $this->file = $file;
  }

  public function validate(){
    parent::validate();
    
    if($this->dimensions === null) $this->addError('image', 'required');
    if($this->file === null) $this->addError('image', 'required');
    if($this->file && empty($this->file->server_filename)){ 
      $this->addError('image', 'custom', ['message' => 'server_filename not present in image ']);
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