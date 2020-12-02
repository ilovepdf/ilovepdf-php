<?php
namespace Ilovepdf\Sign;

class SignConfig{

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
     * @var string
     */
    public $language = 'EN';

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
     * @var Boolean
     */
    public $uuid_visible = true;

    /**
     * @return int
     */
    public function getLockOrder(): int
    {
        return $this->lock_order;
    }

    /**
     * @param int $lock_order
     * @return SignConfig
     */
    public function setLockOrder(int $lock_order): SignConfig
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
     * @return SignConfig
     */
    public function setExpirationDate(int $expiration_date): SignConfig
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
     * @return SignConfig
     */
    public function setCertified(int $certified): SignConfig
    {
        $this->certified = $certified;
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
     * @return SignConfig
     */
    public function setLanguage(string $language): SignConfig
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
     * @return SignConfig
     */
    public function setMode(string $mode): SignConfig
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUuidVisible(): bool
    {
        return $this->uuid_visible;
    }

    /**
     * @param bool $uuid_visible
     * @return SignConfig
     */
    public function setUuidVisible(bool $uuid_visible): SignConfig
    {
        $this->uuid_visible = $uuid_visible;
        return $this;
    }
}