<?php

namespace Ilovepdf\Sign\Receivers;
use Ilovepdf\Sign\SignatureFile;

abstract class ReceiverAbstract
{
    public $name;
    public $email;
    protected $type;
    public $access_code;
    public $files = [];

    

    public function __construct(string $name, string $email, array $signatureFiles = [])
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setFiles($signatureFiles);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Signer
     */
    public function setName($name): ReceiverAbstract
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Signer
     */
    public function setEmail($email): ReceiverAbstract
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Signer
     */
    protected function setType(string $type): ReceiverAbstract
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param array $files
     * @return ReceiverAbstract
     */
    public function setFiles(array $files): ReceiverAbstract
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @param SignatureFile $file
     * @return ReceiverAbstract
     */
    public function addFile(SignatureFile $file): ReceiverAbstract
    {
        $this->files[] = $file;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessCode()
    {
        return $this->access_code;
    }

    /**
     * @param mixed $access_code
     * @return ReceiverAbstract
     */
    public function setAccessCode($access_code): ReceiverAbstract
    {
        $this->access_code = $access_code;
        return $this;
    }

    public function getFilesData(): array
    {
        $data = [];
        foreach ($this->getFiles() as $file) {
            $data[] = $file->__toArray();
        }
        return $data;
    }


    public function __toArray()
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'type' => $this->getType(),
            'files' => $this->getFilesData(),
            'access_code' => $this->getAccessCode()
        ];
    }
}