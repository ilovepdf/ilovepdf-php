<?php

namespace Ilovepdf\Sign;

class Requester
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var int
     */
    public $custom_int;

    /**
     * @var string
     */
    public $custom_string;

    public function __construct(string $name, string $email, int $customInt = null, string $customString = null)
    {
        $this
            ->setName($name)
            ->setEmail($email)
            ->setCustomInt($customInt)
            ->setCustomString($customString);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Requester
     */
    public function setName(string $name): Requester
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Requester
     */
    public function setEmail(string $email): Requester
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomInt(): ?int
    {
        return $this->custom_int;
    }

    /**
     * @param int $custom_int
     * @return Requester
     */
    public function setCustomInt(?int $custom_int = null): Requester
    {
        $this->custom_int = $custom_int;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomString(): ?string
    {
        return $this->custom_string;
    }

    /**
     * @param string $custom_string
     * @return Requester
     */
    public function setCustomString(?string $custom_string = null): Requester
    {
        $this->custom_string = $custom_string;
        return $this;
    }

}