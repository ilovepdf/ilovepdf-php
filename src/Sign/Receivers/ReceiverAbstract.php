<?php

namespace Ilovepdf\Sign\Receivers;

abstract class ReceiverAbstract
{
    public $name;
    public $email;
    protected $type;
    public $access_code;

    public function __construct(string $name, string $email)
    {
        $this->setName($name);
        $this->setEmail($email);
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

    public function __toArray()
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'type' => $this->getType(),
            'access_code' => $this->getAccessCode()
        ];
    }
}