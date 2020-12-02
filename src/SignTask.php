<?php

namespace Ilovepdf;

use Ilovepdf\Sign\Requester;
use Ilovepdf\Sign\Signer;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Class WatermarkTask
 *
 * @package Ilovepdf
 */
class SignTask extends Task
{
    public $PROCESS_ENDPOINT = 'signature';

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
    public $lock_order = 0;

    /**
     * @var int
     */
    public $expiration_date = 120;

    /**
     * @var int
     */
    public $certified = 0;

    /**
     * @var int
     */
    public $custom_int;

    /**
     * @var string
     */
    public $custom_string;

    /**
     * @var string
     */
    public $language = 'en';

    /**
     * @var array
     */
    private $languageValues = ['EN', 'ES', 'FR', 'IT', 'JA', 'ZH-CN', 'ZH-TW', 'BG'];

    /**
     * @var string
     */
    public $mode = 'single';

    /**
     * @var array
     */
    private $modeValues = ['single', 'multiple', 'batch'];


    /**
     * @var array
     */
    public $signers = [];

    /**
     * @var Boolean
     */
    public $uuid_visible = true;

    /**
     * @var Requester
     */
    private $requester;

    /**
     * SignatureTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param bool $makeStart Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'sign';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    function setRequester(Requester $requester)
    {
        $this->requester = $requester;
        $this
            ->setName($requester->getName())
            ->setEmail($requester->getEmail())
            ->setCustomInt($requester->getCustomInt())
            ->setCustomString($requester->getCustomString());
        return $this;
    }

    function addSigner(Signer $signer)
    {
        $this->signers[] = $signer;
        return $this;
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
     */
    public function setName(string $name): SignTask
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
     */
    public function setEmail(string $email): SignTask
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getLockOrder(): int
    {
        return $this->lock_order;
    }

    /**
     * @param int $lock_order
     * @return SignTask
     */
    public function setLockOrder(int $lock_order): SignTask
    {
        $this->lock_order = $lock_order;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationDate(): int
    {
        return $this->expiration_date;
    }

    /**
     * @param int $expiration_date
     * @return SignTask
     */
    public function setExpirationDate(int $expiration_date): SignTask
    {
        $this->expiration_date = $expiration_date;
        return $this;
    }

    /**
     * @return int
     */
    public function getCertified(): int
    {
        return $this->certified;
    }

    /**
     * @param int $certified
     * @return SignTask
     */
    public function setCertified(int $certified): SignTask
    {
        $this->certified = $certified;
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
     * @return SignTask
     */
    public function setCustomInt(?int $custom_int): SignTask
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
     * @return SignTask
     */
    public function setCustomString(?string $custom_string): SignTask
    {
        $this->custom_string = $custom_string;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return SignTask
     */
    public function setLanguage(string $language): SignTask
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return SignTask
     */
    public function setMode(string $mode): SignTask
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return array
     */
    public function getSigners(): array
    {
        return $this->signers;
    }

    /**
     * @param array $signers
     * @return SignTask
     */
    public function setSigners(array $signers): SignTask
    {
        $this->signers = $signers;
        return $this;
    }

    public function getSignersData(): array
    {
        $data = [];
        foreach ($this->getSigners() as $signer) {
            $data[] = $signer->__toArray();
        }
        return $data;
    }

    /**
     * @return Boolean
     */
    public function getUuidVisible(): Boolean
    {
        return $this->uuid_visible;
    }

    /**
     * @param Boolean $uuid_visible
     * @return SignTask
     */
    public function setUuidVisible(Boolean $uuid_visible): SignTask
    {
        $this->uuid_visible = $uuid_visible;
        return $this;
    }

    public function __toArray()
    {
        $data = array_merge(
            parent::__toArray(),
            array('signers' => $this->getSignersData())
        );
        return $data;
    }
}
