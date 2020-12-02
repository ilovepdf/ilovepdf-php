<?php

namespace Ilovepdf\Sign;

class Signer
{

    public $name;
    public $email;
    public $type = 'signer';
    public $custom_int;
    public $custom_string;
    public $force_signature_type = 'all';
    public $files = [];

    public $access_code;
    public $password;
    public $phone;

    public function __construct(?string $name, ?string $email, array $signatureFiles = [])
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
    public function setName($name): Signer
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
    public function setEmail($email)
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
    public function setType(string $type): Signer
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomInt()
    {
        return $this->custom_int;
    }

    /**
     * @param mixed $custom_int
     * @return Signer
     */
    public function setCustomInt($custom_int)
    {
        $this->custom_int = $custom_int;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomString()
    {
        return $this->custom_string;
    }

    /**
     * @param mixed $custom_string
     * @return Signer
     */
    public function setCustomString($custom_string)
    {
        $this->custom_string = $custom_string;
        return $this;
    }

    /**
     * @return string
     */
    public function getForceSignatureType(): string
    {
        return $this->force_signature_type;
    }

    /**
     * @param string $force_signature_type
     * @return Signer
     */
    public function setForceSignatureType(string $force_signature_type): Signer
    {
        $this->force_signature_type = $force_signature_type;
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
     * @return Signer
     */
    public function setFiles(array $files): Signer
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @param SignatureFile $file
     * @return Signer
     */
    public function addFile(SignatureFile $file): Signer
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
     * @return Signer
     */
    public function setAccessCode($access_code)
    {
        $this->access_code = $access_code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Signer
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Signer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param Requester $requester
     * @return Signer
     */
    public static function fromRequester(Requester $requester, array $signatureFiles = []): Signer
    {
        $signer = new Signer($requester->getName(), $requester->getEmail(), $signatureFiles);
        $signer->setCustomInt($requester->getCustomInt());
        $signer->setCustomString($requester->getCustomString());
        return $signer;
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
            'custom_int' => $this->getCustomInt(),
            'custom_string' => $this->getCustomString(),
            'force_signature_type' => $this->getForceSignatureType(),
            'files' => $this->getFilesData(),
            'access_code' => $this->getAccessCode(),
            'password' => $this->getPassword(),
            'phone' => $this->getPhone()
        ];
    }
}