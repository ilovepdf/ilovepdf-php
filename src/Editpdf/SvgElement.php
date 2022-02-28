<?php

namespace Ilovepdf\Editpdf;

use Ilovepdf\File;
use Ilovepdf\Editpdf\Traits\DimensionableTrait;

class SvgElement extends Element
{
    use DimensionableTrait;

    /**
     * @var File|null
     */
    private $file = null;

    /**
     * @param File $file
     * @return $this
     */
    public function setFile(File $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        parent::validate();

        if ($this->file === null) $this->addError('file', 'required');
        if ($this->file && empty($this->file->server_filename)) {
            $this->addError('file', 'custom', ['message' => 'server_filename not present in file']);
        }

        return empty($this->getErrors());
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        $data = array_merge(
            parent::__toArray(),
            [
                'server_filename' => $this->file ? $this->file->getServerFilename() : null,
                'dimensions' => $this->dimensions // From DimensionableTrait
            ]
        );
        return $data;
    }
}