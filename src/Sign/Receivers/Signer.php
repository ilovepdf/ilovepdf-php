<?php

namespace Ilovepdf\Sign\Receivers;

use Ilovepdf\Sign\Receivers\ReceiverAbstract;
use Ilovepdf\File;
use Ilovepdf\Sign\Elements\ElementAbstract;

class Signer extends ReceiverAbstract
{
    public $phone;
    public $force_signature_type;
    public $valid_force_signature_types = ["all","text","sign","image"];
    
    private $_elements = [];

    public function __construct(string $name, string $email)
    {
        $this->setType("signer");
        parent::__construct($name,$email);
    }

    /**
     * @param File $file
     * @param ElementAbstract|ElementAbstract[]
     * 
     * @return Signer
     */
    public function addElements(File $file, $elements) : Signer {
        $serverFilename = $file->getServerFilename();
        if(!is_array($elements)){
            $elements = [$elements];
        }
        
        if(!array_key_exists($serverFilename, $this->_elements)){
            $this->_elements[$serverFilename] = ['file' => $file, 'elements' => []];
        }

        foreach($elements as $elem){
            array_push($this->_elements[$serverFilename]['elements'], $elem);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getForceSignatureType(): ?string
    {
        return $this->force_signature_type;
    }

    /**
     * @param string $force_signature_type
     * @return Signer
     */
    public function setForceSignatureType(string $force_signature_type): Signer
    {
        if(!in_array($force_signature_type,$this->valid_force_signature_types)){
            throw new \InvalidArgumentException("Invalid force_signature_type: {$force_signature_type}, valid arguments are: ".$this->valid_force_signature_types);
        }
        $this->force_signature_type = $force_signature_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Signer
     */
    public function setPhone($phone): Signer
    {
        $this->phone = $phone;
        return $this;
    }

    public function __toArray()
    {
        $array = parent::__toArray();
        $array["force_signature_type"] = $this->getForceSignatureType();
        $array["access_code"] = $this->getAccessCode();
        $array["phone"] = $this->getPhone();
        $array['files'] = $this->getFilesData();
        return $array;
    }

    private function getFilesData(){
        $output = [];
        foreach($this->_elements as $serverFilename => $item){
            $elementsData = [];
            foreach($item['elements'] as $singleElement){
                $elementsData[] = $singleElement->__toArray();
            }
            $output[] = ['server_filename' => $serverFilename, 'elements' => $elementsData];
        }
        return $output;
    }
}